$(document).ready(function(){

/* -------------------------------------------root elements*/

$("#snipper").hide();
$("#pass_field").hide();
$("#pass_btn").hide();
$("#register_model").on('click',function(){
    location.reload();
});
$("#forgot_pass_model").on('click',function(){
    location.reload();
});


$("#verify_ajax").on('click',function(){


/*------------------------------------------- validate for username*/

var name=$("#user_name").val();
var reg_name =/^[a-zA-Z]{3,30}$/
if(name==""){
    $("#name_error").html("Required Name");
    $("#name_error").css("color","red");
    return false;
}
else if(!name.match(reg_name)){
    $("#name_error").html("Enter proper name");
    $("#name_error").css("color","red");
    $("#user_name").reset();
    return false;
}
else{
    $("#name_error").html('');
}
/*------------------------------------------- validate for email--*/

var email=$("#user_email").val();
var reg_email =/^[a-z0-9.-_]+@[a-z]+.[a-z]{2,3}$/
if(email==""){
    $("#email_error").html("Required email");
    $("#email_error").css("color","red");
    return false;
}
else if(!email.match(reg_email)){
    $("#email_error").html("Enter proper email");
    $("#email_error").css("color","red");
    return false;
}
else{
    $("#email_error").html('');
}

/*-----------------------------------------Validation for password----*/
var password=$("#userRegPass").val();
if(password==""){
    $("#password_error").html("Required Password");
    $("#password_error").css("color","red");
    return false;
}
else if(password.length<3){
    var passnotproper="Enter proper password. Required Minimum 8.";
    $("#password_error").html(passnotproper);
    $("#password_error").css("color","red");
    return false;
}
else{
    $("#password_error").html('');
}
/*-----------------------------------------Validation for Confpassword----*/
var confpassword=$("#user_confpass").val();
if(confpassword==""){
    $("#confp_error").html("Required Confirm Password");
    $("#confp_error").css("color","red");
    return false;
}
else if(password!=confpassword){
    $("#not_match_error").html("Password and Confirm Pssword dosen't match");
    $("#not_match_error").css("color","red");
    return false;
}
else{
    $("#confp_error").html("");
    $("#not_match_error").html("");
    $("#verify_ajax").hide();
    $("#snipper").show();
    $.ajax({
        type:'POST',
        url:'web_services/register.php',
        data:$("#register_form").serialize(),
        success:function(result){
            // alert(result.status);
            if(result.status=='fail'){
                $("#email_error").html("Email alredy exist");
                $("#email_error").css("color","red");
                $("#verify_ajax").show();
                $("#snipper").hide();
            }
            else if(result.status=='success'){
                $("#register_form")[0].reset();
                $("#message").html("Registered Successfully");
                $("#message").css("color","green");
                $("#verify_ajax").show();
                $("#snipper").hide();
            }
        } 
    });
}

});

/*-----------------------------------------Forgot Password Enter Email Verify----*/
$("#email_btn").on('click',function(){

    var verify_user_email = $("#verify_email").val();
    var reg_email =/^[a-z0-9.-_]+@[a-z]+.[a-z]{2,3}$/
    if(verify_user_email==""){
        $("#email_error1").html("Required email");
        $("#email_error1").css("color","red");
        return false;
    }
    else if(!verify_user_email.match(reg_email)){
        $("#email_error1").html("Enter proper email");
        $("#email_error1").css("color","red");
        return false;
    }
    else{
        $("#email_error1").html('');
        $.ajax({
            type: 'POST',
            url:'web_services/verify_email.php',
            data:$("#forgot_form").serialize(),
            success:function(result){
                // alert(result);
                if(result.status=='success'){
                    $("#pass_field").show();
                    $("#pass_btn").show();
                    $("#email_btn").hide();
                }
                else if(result.status=='fail'){
                    $("#forgot_form")[0].reset();
                    $("#message1").html("Email not found");
                    $("#message1").css("color","red");
                }
            }
        })
    }
});

/* ------------------------------Change the Password----------*/
$("#pass_btn").on('click',function(){

    var verify_user_email = $("#verify_email").val();
    var reg_email =/^[a-z0-9.-_]+@[a-z]+.[a-z]{2,3}$/
    if(verify_user_email==""){
        $("#email_error1").html("Required email");
        $("#email_error1").css("color","red");
        return false;
    }
    else if(!verify_user_email.match(reg_email)){
        $("#email_error1").html("Enter proper email");
        $("#email_error1").css("color","red");
        return false;
    }
    else{
        $("#email_error1").html('');
    }
    var new_password_verify= $("#verify_pass").val();
    if(new_password_verify==""){
        $("#password_error1").html("Required Password");
        $("#password_error1").css("color","red");
        return false;
    }
    else if(new_password_verify.length<3){
        var passnotproper="Enter proper password. Required Minimum 8.";
        $("#password_error1").html(passnotproper);
        $("#password_error1").css("color","red");
        return false;
    }
    else{
        $("#password_error1").html('');
        $.ajax({
            type: 'POST',
            url:'web_services/change_password.php',
            data:$("#forgot_form").serialize(),
            success:function(result){
                // alert(result);
                if(result.status=='success'){
                    $("#forgot_form")[0].reset();
                    $("#message1").html("Password updated");
                    $("#message1").css("color","green");
                }
                else if(result.status=='fail'){
                    $("#forgot_form")[0].reset();
                    $("#message1").html("Password not updated");
                    $("#message1").css("color","red");
                }
            }
        })
    }
});
/*----------------------------------LOGIN Validation*/ 

$("#login_btn").on('click',function(){

    var login_email = $("#login_email").val();
    var reg_email =/^[a-z0-9.-_]+@[a-z]+.[a-z]{2,3}$/
    if(login_email==""){
        $("#login_email_error").html("Required email");
        $("#login_email_error").css("color","red");
        return false;
    }
    else if(!login_email.match(reg_email)){
        $("#login_email_error").html("Enter proper email");
        $("#login_email_error").css("color","red");
        return false;
    }
    else{
        $("#login_email_error").html('');
    }
    var login_pass= $("#login_pass").val();
    if(login_pass==""){
        $("#login_pass_error").html("Required Password");
        $("#login_pass_error").css("color","red");
        return false;
    }
    else if(login_pass.length<3){
        var passnotproper="Enter proper password. Required Minimum 8.";
        $("#login_pass_error").html(passnotproper);
        $("#login_pass_error").css("color","red");
        return false;
    }
    else{
        $("#login_email_error").html('');
    }
});

});
