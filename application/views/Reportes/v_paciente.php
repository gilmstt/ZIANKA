<!-- Barra de navegacion -->
<script>
    $.ajax({
        type: "POST",
        url: raiz_url + 'report/ajax_obtener_paciente_app',
        dataType: 'json',
        success: function (respuesta) {
            var apellido_pat_pac = new Array();
            $.each(respuesta, function (x, paciente) {
                apellido_pat_pac.push(paciente.APELLIDO_PATERNO_PACIENTE);
            });
            $("#SEARCH_APP_PAC").autocomplete({
                source: apellido_pat_pac,
                select: function (event, ui) {
                    var apellido_pat_pac = ui.item.value;
                    $.ajax({
                        type: "POST",
                        url: raiz_url + 'report/ajax_obtener_paciente_apm',
                        dataType: 'json',
                        data: 'apellido_paterno=' + apellido_pat_pac,
                        success: function (respuesta) {
                            var apellidos_mat_pac = new Array();
                            $.each(respuesta, function (x, paciente) {
                                apellidos_mat_pac.push(paciente.APELLIDO_MATERNO_PACIENTE);
                            });
                            /*	Obtiene los nombres de los pacientes cuyos apellidos coincidan
                             *	con la busqueda hasta el momento, autocompleta los resultados.
                             */
                            $("#SEARCH_APM_PAC").autocomplete({
                                source: apellidos_mat_pac,
                                select: function (event, ui) {
                                    var apellido_materno_paciente = ui.item.value;
                                    $.ajax({
                                        type: "POST",
                                        url: raiz_url + 'report/ajax_obtener_paciente_nombre',
                                        dataType: 'json',
                                        data: 'apellido_paterno=' + apellido_pat_pac + '&apellido_materno=' + apellido_materno_paciente,
                                        success: function (respuesta) {
                                            var nombres_pac = new Array();
                                            $.each(respuesta, function (x, paciente) {
                                                nombres_pac.push(paciente.NOMBRE_PACIENTE);
                                            });
                                            /* Autocompleta los nombres obtenidos
                                             */
                                            $("#SEARCH_NOMBRE_PAC").autocomplete({
                                                source: nombres_pac,
                                                select: function (event, ui) {
                                                    $("#SEARCH_NOMBRE_MEDICO").val(ui.item.value);
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
        }
    });


</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3 "><br>
            <?php $this->view('Reportes/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9"><br>
            <div class="panel panel-primary">
                <div class="panel-heading header-primary">
                    <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-file-invoice"></i>
                            CONSULTAS PACIENTE</span>
                    </div>
                </div>
                <div class="panel-body">
                    <form id="formSearchPaciente" method="POST">
                        <div class="row">							

                            <div id="opcion_paciente">

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="SEARCH_APP" class="control-label text-left">Apellido paterno</label>
                                        <input type="text" name="SEARCH_APP_PAC" id="SEARCH_APP_PAC"
                                               class="form-control" placeholder="Paterno">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="SEARCH_APM" class="control-label text-left">Apellido materno</label>
                                        <input type="text" name="SEARCH_APM_PAC" id="SEARCH_APM_PAC"
                                               class="form-control" placeholder="Materno">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="SEARCH_CLIENT" class="control-label text-left">Nombre(s)</label>
                                        <input type="text" name="SEARCH_NOMBRE_PAC" id="SEARCH_NOMBRE_PAC"
                                               class="form-control" placeholder="Nombre(s)">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                            </div><br>
                            <div id="opcion_buscar" class="col-lg-3">
                                <div class="form-group">
                                    <label for="btnSearch" class="control-label text-left">&nbsp;</label>
                                    <button id="Buscar" class="btn btn-info" type="submit">
                                        <i class="fa fa-search"></i> Cargar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div  class="col-lg-1">
                                <div class="form-group hidden " id="Historia">
                                    <label for="btnHist" class="control-label text-left">&nbsp;</label>
                                    <button id="btn_ver_historial" class="btn btn-info" type="submit">
                                        <i class="fa fa-file-pdf"></i> Ver historial
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <input type="hidden" name="id_paciente" id="id_paciente" >
                </div>
                <hr>
                <div class="control-group text-left">
                    <div class="table-reportes">
                        <!-- Tabla de consultas -->
                        <table id="tablaReportes" class="table table-bordered text-center"
                               style="font-size: 14px; border-radius:5px" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Ver</th>
                                    <th class="text-center">Paciente</th>
                                    <th class="text-center">Médico</th>
                                    <th class="text-center">Tar/Mem</th>
                                    <th class="text-center">Motivo</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Hora</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_reportes" style="font-size: 14px; letter-spacing: 0.5px;">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade in" id="ReporteByPatient">
  <div class="modal-dialog modal-dialogx modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header modal-headx">
      <span class="modal-title" id="myModalLabel">Reporte de ese <span style="color:#ffb53e">día</span></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-modal-body">
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="">Fecha Ingreso</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                        <input readonly="" type="text" name="RG_FECHA_FICHA" id="FECHA_INGRESO" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="help-block with-errors"></div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="">Hora ingreso</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                        <input readonly="" type="time" class="form-control " name="RG_HR_FICHA" id="HORA_INGRESO">
                    </div>
                </div>
                <div class="help-block with-errors"></div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="">Fecha egreso</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                        <input type="text" class="form-control hasDatepicker" data-type="datepicker" placeholder="aaaa-mm-dd" readonly="" name="RG_FECHA_EGRESO" id="FECHA_EGRESO">
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="">Hora egreso</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                        <input type="time" class="form-control require" readonly="" name="RG_HORA_EGRESO" id="HORA_EGRESO">
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="">Motivo consulta :</label>
                    <textarea readonly="" class="form-control require" name="RG_MOTIVO_CONSULTA" id="MOTIVO" rows="5" placeholder="Escribe aquí.."></textarea>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>