
$(document).ready(function () {

    //inicializar controles clock

    //////////////////////////////////////////////
    //////////// FIN DE INICIALIZACIONES//////////
    //////////////////////////////////////////////   
    
    $('#RG_PASSWD_USUARIO').on('keydown', function (e) {
        if (e.which == 13) {
            $('#btnEntrar').click();
        }
    });
    
    $('#RG_USERNAME_USUARIO').on('keydown', function (e) {
        if (e.which == 13) {
            $('#btnEntrar').click();
        }
    });

    $("#LOGIN_FORM").submit(function(e){
        e.preventDefault();
        $('#btnEntrar').html('<img src="' + raiz_url + 'assets/img/loader.gif" width="20px">  ...Cargando');
        
        $.ajax({
            url: raiz_url + "Login/ajax_validate_user",
            type: 'POST',
            data: 'USR_USUARIO=' + $('#RG_USERNAME_USUARIO').val()+
                  '&PSWD_USUARIO=' + $('#RG_PASSWD_USUARIO').val(),  
            success: function (data) {
                console.log(data);
                if (data == 'Ok') {
                    $("#loadercss").show()
                    const element =  document.querySelector('.wrap-login100')
                    element.classList.add('bounceOutUp','fastest')
                    
                    element.addEventListener('animationend', function() { 
                        window.location.href = "Inicio/index";
                        $("#btnEntrar").hide();
                       
                    })
                    $('#btnEntrar').html('<i class="fa fa-check"></i>  Inicio correcto');
                    /*  $("#MAIN").addClass('slideOutLeft'); 
                     window.location.href = "Inicio/index";  */
                }
                else {
                    $('#messages').html(data);
                    $('#messages').focus();
                    $('#btnEntrar').html('Iniciar sesión');
                }
               
            }
        });
    })
    
    
    
    
}); //FIN DE ONREADY

