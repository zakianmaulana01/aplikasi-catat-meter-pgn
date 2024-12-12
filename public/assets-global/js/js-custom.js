$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#show_hide_password .input-group-prepend").on('click', function(event) {
        event.preventDefault();
        
        ShowHidePass("#show_hide_password")
    });

    $("#show_hide_confirm_password .input-group-prepend").on('click', function(event) {
        event.preventDefault();
        
        ShowHidePass("#show_hide_confirm_password")
    });
    
    function ShowHidePass(idElemen) {
        if($(idElemen + ' input').attr("type") == "text"){
            $(idElemen + ' input').attr('type', 'password');
            $(idElemen + ' i').addClass( "fa-eye-slash" );
            $(idElemen + ' i').removeClass( "fa-eye" );
        }else if($(idElemen + ' input').attr("type") == "password"){
            $(idElemen + ' input').attr('type', 'text');
            $(idElemen + ' i').removeClass( "fa-eye-slash" );
            $(idElemen + ' i').addClass( "fa-eye" );
        }
    }

});