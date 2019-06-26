@include('layouts.header')

<div class="container">
    <div>
        <br>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="panel panel-info">
                <div class=""><h4>Users</h4></div>
            </div>
        </div>
    </div>
    <div class="row"> 
        <div class="col-md-10">
            <input type="text" name="search_user" id="search_user" class="form-control" placeholder="Search User">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" id="add_user_btn">Add User</button>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" id="users_table">
                <table class="table table-bordered">
                    <thead>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Last Updated</th>
                    </thead>
                    <tbody id="users_listing">
                        
                    </tbody>
                </table>
            </div>
            <div id="error_msg_div" style="display: none;">
                <div class="alert alert-info text-center">
                    <strong>Sorry no data found.</strong>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4" id="showing_result">
            
        </div>
        <div class="col-md-8 text-right" id="showing_pagination">
            
        </div>
    </div>
</div>

<div id="mySidenavUser" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onClick="closeNavUser()">&times;</a>
      <div class="side_content_div">
        <h3>User Info</h3>
        <div class="side_inner_content_div">
          <p><b>Firstname:</b> <span id="view_user_firstname"></span></p>
          <p><b>Lastname:</b> <span id="view_user_lasttname"></span></p>
          <p><b>Email:</b> <span id="view_user_email"></span></p>
          <p><b>Last updated:</b> <span id="view_user_update_at"></span></p>
        </div>
      </div>
  </div>

<div id="addUserModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add User</h4>
      </div>
      <div class="modal-body">
        <form id="add_user_form">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger" id="error_msg_add_user">
                        <ul id="ul_errormsg"></ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success" id="success_msg_add_user">
                        <strong>User Added successfully.</strong>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="firstname" class="form-control" placeholder="Firstname" id="firstname">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="lastname" class="form-control" placeholder="Lastname" id="lastname">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" id="email">
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button class="btn btn-success" id="add_new_user_btn">Add</button>
      </div>
    </div>

  </div>
</div>

@include('layouts.footer')