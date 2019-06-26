<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = User::validate($request->all());

        if($validation->fails() == false){
            $add_user = User::addData($request->all());

            return response()->json(['success' => 'Successfully added new user.'], 200);
        }else{
            $errors = $validation->errors()->all();

            return response()->json($errors, 422);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if(!is_null($user)){
            $user->created_at_str = \Carbon\Carbon::parse($user->created_at)->format('Y-m-d h:i a');
            $user->updated_at_str = \Carbon\Carbon::parse($user->updated_at)->format('Y-m-d h:i a');
            return response()->json($user, 200);
        }else{
            return response()->json(['error' => 'Sorry no user found.'], 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAllUsers(Request $request){
        $users = User::getAllUsers($request);

        return response()->json($users,200);
    }

    public function insertusers(){
        for($i=0;$i<=5000;$i++){

            $array_firstname = array_merge(range('A','Z'),range('a','z'));
            shuffle($array_firstname);
            $firstname_str = implode('',array_slice($array_firstname,0,7));

            $array_lastname = array_merge(range('A','Z'),range('a','z'));
            shuffle($array_lastname);
            $lastname_str = implode('',array_slice($array_lastname,0,7));

            $array_email = array_merge(range('A','Z'),range('a','z'));
            shuffle($array_email);
            $email_str = implode('',array_slice($array_email,0,7));

            $array_email_domain = array_merge(range('A','Z'),range('a','z'));
            shuffle($array_email_domain);
            $email_domain_str = implode('',array_slice($array_email_domain,0,5));

            $user = new User();
            $user->firstname = $firstname_str;
            $user->lastname = $lastname_str;
            $user->email = $email_str.'@'.$email_domain_str.'.com';
            $user->save();
        }

    }
}
