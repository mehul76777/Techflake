function getUrlVars(url){
    var vars = [], hash;
    var hashes = url.slice(url.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++){
        hash = hashes[i].split('=');
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function openNavUser() {
    $('#mySidenavUser').css('width','250px');
}

function closeNavUser() {
    $('#mySidenavUser').css('width','0px');
}

function loadallusers(){
    closeNavUser();
    
    var url = '/api/users?page='+window.page+'&search='+window.search;
    $.ajax({
      url: url,
      type: "GET"
    }).done(function(response){
        if(response){
            if(response.users.length){
                var user_html = '';
                $.each(response.users,function(i,v){
                    if(v.id){

                        user_html += '<tr class="tr_raw" data-id="'+ v.id +'">';
                        user_html += '<td>'+ v.firstname +'</td>';
                        user_html += '<td>'+ v.lastname +'</td>';
                        user_html += '<td>'+ v.email +'</td>';
                        user_html += '<td>'+ v.updated_at +'</td>';
                        user_html += '</tr>';

                    }
                });

                $('#users_listing').html('');
                $('#users_listing').append(user_html);

                $('#users_table').show();
                $('#error_msg_div').hide();

                $('#showing_result').html(response.showing_users);
                $('#showing_pagination').html(response.pagination_links);

            }else{
                $('#users_table').hide();
                $('#error_msg_div').show();
                $('#showing_result').html('');
                $('#showing_pagination').html('');
            }
        }else{
            $('#users_table').hide();
            $('#error_msg_div').show();
            $('#showing_result').html('');
            $('#showing_pagination').html('');
        }
        

    }).fail(function(jqXHR, textStatus){
      alert("Request failed: " + textStatus);
    });

}

$(document).ready(function(){
    $('#users_table').hide();
    $('#error_msg_div').hide();
    $('#showing_result').html('');
    $('#showing_pagination').html('');
    $('#error_msg_add_user').hide();
    $('#success_msg_add_user').hide();
    closeNavUser();
    window.page = 1;
    window.search = '';
    loadallusers();
});

$(document).on('click','.ajax_pagination', function(event){
    closeNavUser();
    event.preventDefault();
    event.stopPropagation();
    var href = event.target.href;

    var vars = getUrlVars(href);

    var search_string = vars['search'];
    if(search_string){
        window.search = search_string;
        var page_no = vars['page'];
        if(page_no){
            window.page = page_no;
        }
    }else{
        var page_no = vars['page'];
        if(page_no){
            window.page = page_no;
        }
    }

    loadallusers();

    return false;
});

$(document).on('keyup','#search_user', function(event){
    closeNavUser();
    window.page = 1;
    window.search = $(this).val();
    loadallusers();
});

$(document).on('click','#add_user_btn', function(event){
    closeNavUser();
    $('#error_msg_add_user').hide();
    $('#success_msg_add_user').hide();
    $('#firstname').val('');
    $('#lastname').val('');
    $('#email').val('');
    $('#addUserModal').modal('show');
});

$(document).on('click','#add_new_user_btn', function(event){

    closeNavUser();

    var url = '/api/users/create';
    $.ajax({
      url: url,
      type: "POST",
      data: $('#add_user_form').serialize()
    }).done(function(response){
        $('#error_msg_add_user').hide();
        $('#ul_errormsg').html('');
        $('#success_msg_add_user').show();
        window.page = 1;
        window.search = '';
        loadallusers();
        setTimeout(function(){
            $('#addUserModal').modal('hide');
        },2000);

    }).fail(function(jqXHR, textStatus){
      var error_html = '';
      if(jqXHR.responseJSON){
        if(jqXHR.responseJSON.length){
            $.each(jqXHR.responseJSON, function(i,v){
                if(v){
                    error_html += '<li>'+ v +'</li>';
                }
            });
        }else{
            error_html = 'Something went wrong.';
        }
        
      }else{
        error_html = 'Something went wrong.';
      }

      $('#error_msg_add_user').show();
      $('#ul_errormsg').html('');
      $('#ul_errormsg').append(error_html);
    });
});

$(document).on('click','.tr_raw',function(event){

    var id = $(this).attr('data-id');

    var url = '/api/users/view/'+id;
    $.ajax({
      url: url,
      type: "GET"
    }).done(function(response){
        
        if(response){
            $('#view_user_firstname').html(response.firstname);
            $('#view_user_lasttname').html(response.lastname);
            $('#view_user_email').html(response.email);
            $('#view_user_update_at').html(response.updated_at_str);
        }else{
            $('#view_user_firstname').html('');
            $('#view_user_lasttname').html('');
            $('#view_user_email').html('');
            $('#view_user_update_at').html('');
        }
        
        openNavUser();

    }).fail(function(jqXHR, textStatus){
      alert("Request failed: " + textStatus);
    });
});