$(document).ready(function () {
    $('#btnAddSchedule').on('click', function () {
        $('#modAddSchedule').modal('toggle');
    });

    $('#FOUND_PATIENT_DIV').hide();
    $('#FOUND_MEDIC_DIV').hide();

    $('#btnDelPatientSched').on('click', function () {
        //console.log($('#ID_PACIENTE').val());
        if ($('#ID_PACIENTE').val() != "") {
            $('#ID_PACIENTE').val("");
            $('#NOMBRE_COMPLETO_PACIENTE_F').html("");
            $('#RG_APELLIDO_PATERNO_PACIENTE').val("");
            $('#RG_APELLIDO_MATERNO_PACIENTE').val("");
            $('#RG_NOMBRE_PACIENTE').val("");
            $('#SEARCH_PATIENT_DIV').show();
            $('#FOUND_PATIENT_DIV').hide();
        }
    });

    $('#btnDelMedicSched').on('click', function () {
        //(console.log($('#ID_USUARIO').val());
        if ($('#ID_USUARIO').val() != "") {
            $('#ID_USUARIO').val("");
            $('#NOMBRE_COMPLETO_MEDICO_F').html("");
            $('#RG_APELLIDO_USUARIO').val("");
            $('#RG_NOMBRE_USUARIO').val("");
            $('#SEARCH_MEDIC_DIV').show();
            $('#FOUND_MEDIC_DIV').hide();
        }
    });

    $('#RG_HORA_INICIO_CITA').on('change', function () {
        $('#RG_HORA_FINAL_CITA').val(sumar_30min($('#RG_HORA_INICIO_CITA').val()));
    });
    
   
   
    //Eliminar cita 
    $('#btnDelScheduleToCalendar').on('click', function () {
        var ID_CITA = $('#ID_CITA').val();
        if (ID_CITA > 0) {
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No se puede revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: raiz_url + "schedule/ajax_disable_schedule",
                        type: 'POST',
                        data: 'ID_CITA=' + ID_CITA,
                    })
                    .done( function(data){                     
                        if (parseInt(data) > 0) {
                            $('#modDataEditSchedule').modal('toggle');
                            Swal.fire({
                                title: 'Cita eliminada!',
                                icon: 'success',
                                showConfirmButton : false,
                                timer:1500,
                                onClose: function(){
                                    window.location.reload();
                                },
                             })
                        } else {
                            Swal.fire({
                                title: 'Error al eliminar!',
                                icon: 'error',
                                showConfirmButton : false,
                                timer:1500,                               
                             })
                        }
                    
                    });
                                                    
                }
            })
        }
    });

    $('#message').hide();
    $('#message2').hide();
    $('#message3').hide();
    $('#message4').hide();

    $('#formRecordSchedule').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            // everything looks good!
            e.preventDefault();
            $('#message').html("");
            if (!$('#RG_APELLIDO_PATERNO_PACIENTE').val() || !$('#RG_NOMBRE_PACIENTE').val() || !$('#RG_APELLIDO_USUARIO').val() || !$('#RG_NOMBRE_USUARIO').val() || !$('#RG_HORA_INICIO_CITA').val() || !$('#RG_HORA_FINAL_CITA').val()) {
                if (!$('#RG_APELLIDO_PATERNO_PACIENTE').val()) {
                    $('#RG_APELLIDO_PATERNO_PACIENTE').closest('.form-group').removeClass('has-success').addClass('has-error');
                    //$('#message').append('Ingresa un apellido paterno para paciente<br>');
                }
                if (!$('#RG_NOMBRE_PACIENTE').val()) {
                    $('#RG_NOMBRE_PACIENTE').closest('.form-group').removeClass('has-success').addClass('has-error');
                    //$('#message').append('Ingresa un nombre para paciente<br>');
                }
                if (!$('#RG_APELLIDO_USUARIO').val()) {
                    $('#RG_APELLIDO_USUARIO').closest('.form-group').removeClass('has-success').addClass('has-error');
                    //$('#message').append('Ingresa un apellido para médico<br>');
                }
                if (!$('#RG_NOMBRE_USUARIO').val()) {
                    $('#RG_NOMBRE_USUARIO').closest('.form-group').removeClass('has-success').addClass('has-error');
                    //$('#message').append('Ingresa un nombre para médico<br>');
                }
                if (!$('#RG_HORA_INICIO_CITA').val()) {
                    $('#RG_HORA_INICIO_CITA').closest('.form-group').removeClass('has-success').addClass('has-error');
                    //$('#message').append('Ingresa una hora de inicio<br>');
                }
                if (!$('#RG_HORA_FINAL_CITA').val()) {
                    $('#RG_HORA_FINAL_CITA').closest('.form-group').removeClass('has-success').addClass('has-error');
                    
                }
                $('#message').append('<i class="fa fa-exclamation-triangle"></i> Los campos en <b>ROJO</b> son obligatorios<br>');
                $('#message').show();
                $('#message').fadeOut(4000);
            } else {
                if (!$('#ID_PACIENTE').val() || !$('#ID_USUARIO').val()) {
                    if (!$('#ID_USUARIO').val()) {
                        $('#message').html('<i class="fa fa-exclamation-triangle"></i> Debe elegir un médico válido<br>');
                    }
                    if (!$('#ID_PACIENTE').val()) {
                        $('#message').html('<i class="fa fa-exclamation-triangle"></i> Debe elegir un paciente válido<br>');
                    }
                    $('#message').show();
                    $('#message').fadeOut(4000);
                } else {
                    $('#message2').show();
                    $('#message2').html('<img src="' + raiz_url + 'assets/img/loader.gif" alt="loading" height="42px" width="42px"> ');
                    $.ajax({
                        url: raiz_url + "schedule/ajax_add_schedule",
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function (data) {
                            if (data > 0) {
                                $('#message2').hide();
                                $('#message3').html('<b>! La cita se agregó correctamente ¡</b> ');
                                $('#message3').show();
                                $('#modAddSchedule').fadeOut(3000);
                                window.location.reload();
                            } else {
                                $('#message2').hide();
                                $('#message4').html('<i class="fa fa-times"></i> Hubo un error al realizar la operación...');
                                $('#message4').show();
                            }
                        },
                        error: function(e){
                            $('#message2').hide();
                            $('#message4').html('<i class="fa fa-times"></i> Hubo un error al realizar la operación...');
                            $('#message4').show();
                        }
                    });
                    //MANDAR AJAXX... 
                    $('#modCustomer').on('hidden.bs.modal', function () {
                        window.location.href = raiz_url + "polizas/index";
                    });
                }
            }
        }
    });

})

function get_ruth_record_by_event(event) {
    $.ajax({
        url: raiz_url + "schedule/ajax_get_data_event_schedule_by_id",
        type: 'POST',
        data: 'ID_CITA=' + event.id,
        success: function (data) {
            //console.log(data);
            if (data.length > 0) {

                let options = { weekday: 'short', year: 'numeric', month: 'long', day: 'numeric' };
                var fecha   = new Date(data[0].FECHA_CITA+'T00:00:00');
                
                var HrInicio=  data[0].HORA_INICIO_CITA.substr(0, 2);
                var formatHrInicio = (HrInicio <= 11) ? " am" : " pm";
                
                var HrFinal =  data[0].HORA_FINAL_CITA.substr(0, 2);
                var formatHrFinal = (HrFinal <= 11) ? " am" : " pm";
                var formatFecha = fecha.toLocaleDateString("es-MX",options);

                $('#NOMBRE_COMPLETO_PACIENTE').html(data[0].APELLIDO_PATERNO_PACIENTE + " " + data[0].APELLIDO_MATERNO_PACIENTE + " " + data[0].NOMBRE_PACIENTE);
                $('#NOMBRE_MEDICO').html(data[0].APELLIDO_USUARIO + " " + data[0].NOMBRE_USUARIO);
                $('#FECHA_CITA_P').html(formatFecha);
                $('#HORA_I').html(data[0].HORA_INICIO_CITA.substr(0, 5)+formatHrInicio);
                $('#HORA_F').html(data[0].HORA_FINAL_CITA.substr(0, 5)+formatHrFinal);
                $('#MOTIVO_CITA_P').html(data[0].MOTIVO_CITA);
                //$("#headerDataEditSchedule").css('background-color',data[0].COLOR_USUARIO);
                $('#modDataEditSchedule').modal('toggle');

                $('#ID_CITA').val(event.id);

            } else {
                $('#modalAdvSched').modal('toggle');
                $('#modalBodyAdvSched').modal('<p>Hubo un error al cargar la información de la cita</p>');
            }


        }, error: function (data) {
            $('#modalAdvRuth').modal('toggle');
            $('#modalBodyAdvRuth').modal('<p>Hubo un error al cargar la información de la cita</p>');
        }
    });
}

function addZero(i) {
    if (i < 10) {
        i = '0' + i;
    }
    return i;
}

function sumar_30min($hora) {
    horas = $hora.substr(0, 2);
    minutos = $hora.substr(3, 2);
    var hora_fin = 0;    
    var minutos_new = parseInt(minutos) + parseInt(30);
    if (minutos_new >= 60) {
        hora_fin = addZero(parseInt(horas) + parseInt(1));
        if (hora_fin >= 24)
            hora_fin = "00";
        minutos_new = addZero(parseInt(minutos_new) - parseInt(60));
    } else {
        hora_fin = addZero(horas);
    }

    //var locale = (hora_fin <= 11 ? " AM" : " PM");

    return hora_fin + ":" + minutos_new;// + locale;
}

function rgb2hex(orig) {
    var rgb = orig.replace(/\s/g, '').match(/^rgba?\((\d+),(\d+),(\d+)/i);
    return (rgb && rgb.length === 4) ? "#" +
            ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
            ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
            ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : orig;
}

function show_patient(respuesta) {
    $('#ID_PACIENTE').val(respuesta[0].ID_PACIENTE);
    $('#NOMBRE_COMPLETO_PACIENTE_F').html(respuesta[0].NOMBRE_PACIENTE + " " + respuesta[0].APELLIDO_PATERNO_PACIENTE + " " + respuesta[0].APELLIDO_MATERNO_PACIENTE);
    $('#SEARCH_PATIENT_DIV').hide();
    $('#FOUND_PATIENT_DIV').show();
}