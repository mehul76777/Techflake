<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getAllUsers($request){

        $return = array();
        $return_main = array();
        $appends = array();

        $users = User::select(['id','firstname','lastname','email','created_at','updated_at']);

        if(!is_null($request->search)){
            $users = $users->where('firstname', 'like', '%' . $request->search . '%')->orWhere('lastname', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%');

            $appends['search'] = $request->search;
        }else{
            $appends['search'] = '';
        }

        $users = $users->orderBy('updated_at','DESC');

        $users = $users->paginate(10);

        $users->appends($appends);

        $links = str_replace("<a", "<a class='ajax_pagination' ", (string)$users->links());

        $return_main['pagination_links'] = (string)$links;

        $showing_users = 'Showing '. (($users->currentPage() * $users->perPage()) - $users->perPage() + 1). ' to ' . ($users->lastPage() == $users->currentPage() ? $users->total() : $users->currentPage() * $users->perPage()). ' of '. ($users->total());

        $return_main['showing_users'] = (string)$showing_users;

        if(!is_null($users)){
            foreach ($users as $key => $user) {
                $return[$key]['id'] = $user->id;
                $return[$key]['firstname'] = $user->firstname;
                $return[$key]['lastname'] = $user->lastname;
                $return[$key]['email'] = $user->email;
                $return[$key]['created_at'] = \Carbon\Carbon::parse($user->created_at)->format('Y-m-d h:i a');
                $return[$key]['updated_at'] = \Carbon\Carbon::parse($user->updated_at)->format('Y-m-d h:i a');
            }
        }

        $return_main['users'] = $return;

        return $return_main;
    }

    public static function validate($data) {
        $rules = array(
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            
        );
        return Validator::make($data, $rules);
    }

    public static function addData($data){
        $user = new Self();
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->save();

        return $user;
    }
}
