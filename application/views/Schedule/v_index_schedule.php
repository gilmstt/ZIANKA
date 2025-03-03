<script>
    $(document).ready(function () {
        /* initialize the calendar
         -----------------------------------------------------------------*/
        var hoy = new Date();
        var dd = addZero(hoy.getDate());
        var mm = addZero(hoy.getMonth() + 1);
        var yyyy = hoy.getFullYear();
        hoy = yyyy + '-' + mm + '-' + dd;
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            lang: 'es',
            selectable: true,
            selectHelper: true,
            defaultDate: hoy,
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function () {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            //CUANDO SE RECIBE DEL CONTENEDOR..
            eventReceive: function (event) {

            },
            events: {
                url: raiz_url + "schedule/ajax_render_calendar_from_db"
            },
            eventClick: function (event) {
                //console.log(event.id);
                get_ruth_record_by_event(event);
            },

        });

        //BUSCAR PACIENTES
        $.ajax({
            type: "POST",
            url: raiz_url + 'schedule/ajax_obtener_apellidos_paternos_pac',
            dataType: 'json',
            success: function (respuesta) {
                var apellidos_paternos = new Array();
                $.each(respuesta, function (x, paciente) {
                    if (paciente.APELLIDO_PATERNO_PACIENTE.length > 0)
                        apellidos_paternos.push(paciente.APELLIDO_PATERNO_PACIENTE);
                });
                $("#RG_APELLIDO_PATERNO_PACIENTE").autocomplete({
                    source: apellidos_paternos,
                    select: function (event, ui) {
                        var apellido_paterno = ui.item.value;
                        $.ajax({
                            type: "POST",
                            url: raiz_url + 'schedule/ajax_obtener_apellidos_maternos_pac',
                            dataType: 'json',
                            data: 'apellido_paterno=' + apellido_paterno,
                            success: function (respuesta) {
                                var apellidos_maternos = new Array();
                                $.each(respuesta, function (x, paciente) {
                                    if (paciente.APELLIDO_MATERNO_PACIENTE.length > 0)
                                        apellidos_maternos.push(paciente.APELLIDO_MATERNO_PACIENTE);
                                });
                                $("#RG_APELLIDO_MATERNO_PACIENTE").autocomplete({
                                    source: apellidos_maternos,
                                    select: function (event, ui) {
                                        var apellido_materno = ui.item.value;
                                        $.ajax({
                                            type: "POST",
                                            url: raiz_url + 'schedule/ajax_obtener_nombres_pac',
                                            dataType: 'json',
                                            data: 'apellido_paterno=' + apellido_paterno + '&apellido_materno=' + apellido_materno,
                                            success: function (respuesta) {
                                                var nombres = new Array();
                                                $.each(respuesta, function (x, paciente) {
                                                    if (paciente.NOMBRE_PACIENTE.length > 0)
                                                        nombres.push(paciente.NOMBRE_PACIENTE);
                                                });
                                                $("#RG_NOMBRE_PACIENTE").autocomplete({
                                                    source: nombres,
                                                    select: function (event, ui) {
                                                        var nombre = ui.item.value;
                                                        $.ajax({
                                                            type: "POST",
                                                            url: raiz_url + 'schedule/ajax_obtener_paciente',
                                                            dataType: 'json',
                                                            data: 'apellido_paterno=' + apellido_paterno + '&apellido_materno=' + apellido_materno + '&nombre=' + nombre,
                                                            success: function (respuesta) {
                                                                show_patient(respuesta);
                                                            }
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                        //BUSCAR NOMBRES SOLO POR APELLIDO PATERNO
                        if ($('#RG_APELLIDO_MATERNO_PACIENTE').val() == "") {
                            $.ajax({
                                type: "POST",
                                url: raiz_url + 'schedule/ajax_obtener_nombres_pac_by_app',
                                dataType: 'json',
                                data: 'apellido_paterno=' + apellido_paterno,
                                success: function (respuesta) {
                                    var nombres2 = new Array();
                                    $.each(respuesta, function (x, paciente) {
                                        if (paciente.NOMBRE_PACIENTE.length > 0)
                                            nombres2.push(paciente.NOMBRE_PACIENTE);
                                    });
                                    $("#RG_NOMBRE_PACIENTE").autocomplete({
                                        source: nombres2,
                                        select: function (event, ui) {
                                            var nombre = ui.item.value;
                                            $.ajax({
                                                type: "POST",
                                                url: raiz_url + 'schedule/ajax_obtener_paciente_by_nom_app',
                                                dataType: 'json',
                                                data: 'apellido_paterno=' + apellido_paterno + '&nombre=' + nombre,
                                                success: function (respuesta) {
                                                    show_patient(respuesta);
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    }
                });
            }
        });

        //BUSCAR MEDICOS
        $.ajax({
            type: "POST",
            url: raiz_url + 'schedule/ajax_obtener_apellidos_med',
            dataType: 'json',
            success: function (respuesta) {
                var apellidos = new Array();
                $.each(respuesta, function (x, medico) {
                    if (medico.APELLIDO_USUARIO.length > 0)
                        apellidos.push(medico.APELLIDO_USUARIO);
                });
                $("#RG_APELLIDO_USUARIO").autocomplete({
                    source: apellidos,
                    select: function (event, ui) {
                        var apellido = ui.item.value;
                        $.ajax({
                            type: "POST",
                            url: raiz_url + 'schedule/ajax_obtener_nombres_med',
                            dataType: 'json',
                            data: 'apellido=' + apellido,
                            success: function (respuesta) {
                                var nombres = new Array();
                                $.each(respuesta, function (x, medico) {
                                    if (medico.NOMBRE_USUARIO.length > 0)
                                        nombres.push(medico.NOMBRE_USUARIO);
                                });
                                $("#RG_NOMBRE_USUARIO").autocomplete({
                                    source: nombres,
                                    select: function (event, ui) {
                                        var nombre = ui.item.value;
                                        $.ajax({
                                            type: "POST",
                                            url: raiz_url + 'schedule/ajax_obtener_medico',
                                            dataType: 'json',
                                            data: 'apellido=' + apellido + '&nombre=' + nombre,
                                            success: function (respuesta) {
                                                $('#ID_USUARIO').val(respuesta[0].ID_USUARIO);
                                                $('#NOMBRE_COMPLETO_MEDICO_F').html(respuesta[0].NOMBRE_USUARIO + " " + respuesta[0].APELLIDO_USUARIO);
                                                $('#SEARCH_MEDIC_DIV').hide();
                                                $('#FOUND_MEDIC_DIV').show();
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });

        //Calcular horas
        var hora_inicio = $('#RG_HORA_INICIO_CITA').val();
        $('#RG_HORA_FINAL_CITA').val(sumar_30min(hora_inicio));
    });

</script>

<div class="container-fluid">
    <div class=" row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <br>
            <button type="button" class="btn pull-right btn-header" id="btnAddSchedule">
                <i class="fas fa-plus" prescription-bottle aria-hidden="true"></i> Nueva cita
            </button>
            <div style="clear:both"><br></div>
            <div id="calendar" style=" max-height: 900px; overflow-y:hidden"></div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>

<div class="modal fade" id="modAddSchedule" tabindex="-1" role="dialog" aria-labelledby="modAddSchedule"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-headx">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="modal-title"><i class="fas fa-file-signature"></i> Agregar cita</h4>
            </div>
            <form data-toggle="validator" role="form" id="formRecordSchedule">
                <div class="modal-body modal-bodyx" style="font-size:15px;">
                    <label class="label label-primary">Paciente</label><br>
                    <input type="hidden" id="ID_PACIENTE" name="ID_PACIENTE" value="">
                    <div id="SEARCH_PATIENT_DIV">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="RG_APELLIDO_PATERNO_PACIENTE" class="control-label text-left mt-10">Apellido
                                    paterno</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user-edit"></i></span>

                                    <input required type="text" id="RG_APELLIDO_PATERNO_PACIENTE"
                                           name="RG_APELLIDO_PATERNO_PACIENTE" onkeyUp="this.value = this.value.toUpperCase()"
                                           class="form-control" placeholder="Ingresa apellido paterno">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="RG_APELLIDO_MATERNO_PACIENTE" class="control-label text-left mt-10">Apellido
                                    materno</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user-edit"></i></span>
                                    <input type="text" id="RG_APELLIDO_MATERNO_PACIENTE" name="RG_APELLIDO_MATERNO_PACIENTE"
                                           onkeyUp="this.value = this.value.toUpperCase()" class="form-control"
                                           placeholder="Ingresa apellido materno">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="RG_NOMBRE_PACIENTE" class="control-label text-left mt-10">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user-edit"></i></span>
                                    <input required type="text" id="RG_NOMBRE_PACIENTE" name="RG_NOMBRE_PACIENTE"
                                           onkeyUp="this.value = this.value.toUpperCase()" class="form-control"
                                           placeholder="Ingresa nombre(s)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="FOUND_PATIENT_DIV">
                        <div class="col-md-12">
                            <div class="form-group"
                                 style="background-color: #ddf3fd; padding: 16px; color: #6f6b6b; letter-spacing: 1px; border-radius: 5px;">
                                <label class="label-control" id="NOMBRE_COMPLETO_PACIENTE_F"></label>
                                <button type="button" class="btn btn-primary pull-right" style="margin-top: -4px;"
                                        id="btnDelPatientSched">
                                    <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <label class="label label-primary">Médico</label><br>
                    <input type="hidden" id="ID_USUARIO" name="ID_USUARIO">
                    <div id="SEARCH_MEDIC_DIV">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="RG_APELLIDO_USUARIO" class="control-label text-left mt-10">Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user-md"></i></span>
                                    <input required type="text" id="RG_APELLIDO_USUARIO" name="RG_APELLIDO_USUARIO"
                                           onkeyUp="this.value = this.value.toUpperCase()" class="form-control"
                                           placeholder="Ingresa apellido(s)">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="RG_NOMBRE_USUARIO" class="control-label text-left mt-10">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fad fa-user-md"></i></span>
                                    <input type="text" id="RG_NOMBRE_USUARIO" name="RG_NOMBRE_USUARIO"
                                           onkeyUp="this.value = this.value.toUpperCase()" class="form-control"
                                           placeholder="Ingresa nombre(s)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="FOUND_MEDIC_DIV">
                        <div class="col-md-12">
                            <div class="form-group"
                                 style="background-color: #ddf3fd; padding: 16px; color: #6f6b6b; letter-spacing: 1px; border-radius: 5px;">
                                <label class="label-control" id="NOMBRE_COMPLETO_MEDICO_F"></label>
                                <button type="button" class="btn btn-primary pull-right" style="margin-top: -4px;"
                                        id="btnDelMedicSched">
                                    <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <label class="label label-primary">Datos cita</label><br>
                    <div class="col-md-4 text-left">
                        <div class="form-group">
                            <label for="RG_FECHA_CITA" class="control-label text-left mt-10">Fecha</label>
                            <div class='input-group'>
                                <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                <input type="text" data-type="datepicker" name="RG_FECHA_CITA" required id="RG_FECHA_CITA" class="form-control" placeholder="Desde" readonly value="<?= date('d/m/Y'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="RG_HORA_INICIO_CITA" class="mt-10">Hora inicio</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                                <input type="time" required class="form-control" value="<?= date("H:i"); ?>" id="RG_HORA_INICIO_CITA" name="RG_HORA_INICIO_CITA">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="RG_HORA_FINAL_CITA" class="mt-10">Hora final</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                                <input type="time" required class="form-control" value="" id="RG_HORA_FINAL_CITA" name="RG_HORA_FINAL_CITA">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="RG_MOTIVO_CITA" class="control-label text-left">Motivo</label>
                            <textarea id="RG_MOTIVO_CITA" name="RG_MOTIVO_CITA" rows="10" onkeyUp="this.value = this.value.toUpperCase()" class="form-control" placeholder="Motivo"></textarea>
                        </div>
                    </div>
                    <div style="clear:both"><br></div>
                </div>
                <div class="modal-footer">
                    <div class="pull-left">
                        <div id="message" class="messageSched" style="text-align: left;"></div>
                    </div>
                    <div class="pull-left">
                        <div id="message2" class="messageSched2" style="text-align: center;"></div>
                    </div>
                    <div class="pull-left">
                        <div id="message3" class="messageSched3" style="text-align: center;"></div>
                    </div>
                    <div class="pull-left">
                        <div id="message4" class="messageSched4" style="text-align: center;"></div>
                    </div>
                    <!-- <div class="btn-group pull-right">
                            <button type="button" class="btn" id="btnCancel" data-dismiss="modal">
                                    <i class="fa fa-times"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnAddScheduleCalendar">
                                    <i class="fa fa-cloud-upload"></i> Guardar
                            </button>
                    </div> -->
                    <button type="submit" id="btnAddScheduleCalendar" class="btn btn-info">
                        <!-- <i class="fa fa-check"></i> -->Guardar
                    </button>
                    <button type="button"id="btnCancel" class="btn btn-cancel" data-dismiss="modal">
                        <!-- <i class="fa fa-times"></i> -->Cancelar
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modDataEditSchedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-headx" style="background:#333"id="headerDataEditSchedule">
                <div class="float-right">
                    <label class="label-control border-bottom name-yellow" id="FECHA_CITA_P"></label>
                </div>
                <span class="modal-title" id="myModalLabel" ><i class="fas fa-file-spreadsheet"></i> Información de la cita</span>
            </div>
            <div class="modal-body" style="font-size:15px;">
                <div class="form-group">
                    <label class="label label-black text-center">Paciente</label>
                    <label class="label-control border-bottom ml-10" id="NOMBRE_COMPLETO_PACIENTE"></label>
                </div>
                <div class="form-group">
                    <label class="label label-black text-center">  Médico </label>
                    <label class="label-control border-bottom ml-10" id="NOMBRE_MEDICO"></label>
                </div>    
                <div class="row ml-0">                                     
                    <div class="form-group">
                       
                        <div class="col-lg-2 col-sm-2 col-md-2 mb-10 p-none">
                            <label class="label label-black">  Motivo </label>
                        </div>
                        <div class="col-lg-10 col-sm-10 col-md-10 p-left0">
                            <label class="label-control" id="MOTIVO_CITA_P"></label>                           
                        </div>
                   
                    </div>                   
                </div>                   
            </div>
            <div class="modal-footer">
                <input type="hidden" id="ID_CITA" nombre="ID_CITA" value="">
                    <div class="float-left cita-footer">
                        <label class="color-success upcase">Comienza:</label>
                        <label  id="HORA_I"></label>
                    </div>
                    <div class="float-left cita-footer">
                        <label class="color-danger upcase">  |  Termina:</label>
                        <label  id="HORA_F"></label>
                    </div>
                    <button type="button" class="btn btn-danger" id="btnDelScheduleToCalendar">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-info" id="btnCancel" data-dismiss="modal">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
                
            </div>            
        </div>
    </div>
</div>
<div class="modal fade" id="modDelSchedule" tabindex="-1" role="dialog" aria-labelledby="modAdvice" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <div class="modal-title" id="modalTitleAdvice">Eliminar cita</div>
            </div>
            <div class="modal-body text-center" id="modBodyDelSchedule"></div>
            <div style="clear:both"><br></div>
            <div class="modal-footer">
                <div class="btn-group ">
                    <button type="button" class="btn btn-danger" id="btnDelRowSchedule">
                        <i class="fa fa-trash" aria-hidden="true"></i> Borrar
                    </button>
                    <button class="btn btn-primary" type="button" id="btnOkAdvice" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAdvSched" tabindex="-1" role="dialog" aria-labelledby="modAdvice" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderDataRuth">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <div class="modal-title" id="modalTitleAdvice">Calendario de citas</div>
            </div>
            <div class="modal-body" id="modalBodyAdvSched">
            </div>
            <div style="clear:both"><br></div>
            <div class="modal-footer">
                <div class="btn-group ">
                    <button class="btn btn-primary" type="button" id="btnOkAdvice" data-dismiss="modal">
                        <i class="fa fa-check-circle" aria-hidden="true"></i> Entiendo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>