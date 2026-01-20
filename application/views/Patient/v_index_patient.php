<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-lg-1 text-center"></div>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10 text-center">
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading header-primary">
                    <div class="panel-title text-left">
                        <span class="heading-primary"><i class="fas fa-users"></i> Pacientes</span>
                        <a href="<?= base_url() ?>patient/form_add_patient" class="btn pull-right btn-header" id="btnAddPatient">
                            <i class="fas fa-plus"></i> Nuevo paciente
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <!--  <div style="clear:both"><br></div> -->
                    <div class="control-group text-left">
                        <div class="table-">
                            <table id="dataPatients" class="table table-bordered table-striped text-center"
                                style="font-size: 14px; border-radius:5px" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center active">No. Expediente</th>
                                        <th width="20%" class="text-center active">Acciones</th>
                                        <th width="20%" class="text-center active">Nombre</th>
                                        <th width="20%" class="text-center active">Domicilio</th>
                                        <th width="5%" class="text-center active">Edad</th>
                                        <!--<th width="10%" class="text-center active">Sexo</th>-->
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div><br></div>
        </div>
        <div class="col-lg-1 text-center"></div>
    </div>
</div>
<div class="modal fade" id="modAddFiles" tabindex="-1" role="dialog" aria-labelledby="modAddFiles" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-headx header-primary" id="modalHeaderAdvice">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>

                <span class="modal-title" id="myModalLabel"><i class="fas fa-paperclip"></i> ADJUNTAR ARCHIVOS</span>
            </div>
            <div class="modal-body text-center" id="modBodyAddFiles" style="text-align: center">
                <div class="col-sm-12 text-left">
                    <div class="alert alert-warning"> Puedes adjuntar archivos como imagenes, excel, word, PDF. Deben ser
                        menores a 40 MB.</div>
                </div>
                <div class="col-sm-12 text-left">
                    <table class="table table-responsive" style="width: 98%; font-size: 12px;">
                        <thead>
                            <tr>
                                <th width="10%" class="text-center active">#</th>
                                <th width="60%" class="text-center active">Archivo</th>
                                <th width="20%" class="text-center active">Tipo</th>
                                <th width="10%" class="text-center active">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyTableFilesClient"></tbody>
                    </table>
                    <div id="divMensajesFiles">

                    </div>
                    <br>
                </div>
                <div class="col-sm-12">
                    <form method="post" enctype="multipart/form-data" id="formFilesPatient">
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <span class="input-group-append">
                                <span class="input-group-text fileinput-exists" data-dismiss="fileinput">
                                    <i class="fas fa-file-minus"></i> Quitar
                                </span>

                                <span class="input-group-text btn-file">
                                    <span class="fileinput-new"><i class="fad fa-hand-pointer"></i> Seleccionar archivo</span>
                                    <span class="fileinput-exists"><i class="fad fa-sync-alt"></i> Cambiar</span>
                                    <input type="file" name="userfile" id="userfile" multiple>
                                </span>
                            </span>
                            <div class="form-control" data-trigger="fileinput">
                                <span class="fileinput-filename"></span>
                            </div>
                        </div>
                </div>
            </div>
            <div style="clear:both"><br></div>
            <div class="modal-footer">

                <button class="btn btn-default" type="button" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i> Cerrar
                </button>
                <div class="col-sm-4 float-left text-left p-left0">
                    <button type="submit" class="btn btn-info"> <i class="fa fa-upload"
                            aria-hidden="true"></i> Subir archivo
                    </button>
                    <input type="hidden" name="ID_PACIENTE" id="ID_PACIENTE">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Selección Tipo de Consentimiento -->
<div class="modal fade" id="modalSeleccionTipoConsentimiento" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-headx header-primary">
                <span class="modal-title" id="myModalLabel"><i class="fas fa-paperclip"></i>Seleccionar tipo de consentimiento</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formImprimirConsentimiento">
                    <input type="hidden" id="id_paciente_modal" name="id_paciente">

                    <div class="form-group">
                        <label for="tipo_consentimiento">Tipo de consentimiento:</label>
                        <select class="form-control" id="tipo_consentimiento" name="tipo_consentimiento" required>
                            <option value="">Cargando opciones...</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="procedimientos_consentimiento">Motivo(s) o indicación(es) del procedimiento (puede seleccionar varios):</label>
                        <select class="form-control" id="procedimientos_consentimiento" name="procedimientos_consentimiento[]" multiple>
                            <option value="ENVEJECIMIENTO_CUTANEO">Envejecimiento cutáneo</option>
                            <option value="RITIDES">Rítides</option>
                            <option value="BRUXISMO">Bruxismo</option>
                            <option value="ADIPOSIDAD_LOCALIZADA">Adiposidad Localizada</option>
                            <option value="ESTRIAS">Estrías</option>
                            <option value="VARICES">Várices</option>
                            <option value="HIPERPIGMENTACION">Hiperpigmentación</option>
                            <option value="ALOPECIA">Alopecia</option>
                            <option value="VERRUGAS">Verrugas</option>
                            <option value="FLACIDEZ_CUTANEA">Flacidez cutánea</option>
                            <option value="ACNE">Acné</option>
                            <option value="CELULITIS">Celulitis</option>
                            <option value="CICATRICES">Cicatrices</option>
                            <option value="ROSACEA">Rosácea</option>
                            <option value="HIPERHIDROSIS">Hiperhidrósis</option>
                            <option value="OTROS">Otros (especificar abajo)</option>
                        </select>
                        <small class="form-text text-muted">Mantén presionada Ctrl (o Cmd en Mac) para seleccionar varios.</small>
                    </div>

                    <!-- Campo que aparece solo si se selecciona "Otros" -->
                    <div class="form-group" id="otros_container" style="display:none;">
                        <label for="otros_especificar">Especifique otros motivos/indicaciones:</label>
                        <textarea class="form-control" id="otros_especificar" name="otros_especificar" rows="2" placeholder="Escriba aquí..."></textarea>
                    </div>

                    <!--Select de médico -->
                    <div class="form-group">
                        <label for="medico_consentimiento">Médico que atenderá:</label>
                        <select class="form-control" id="medico_consentimiento" name="medico_consentimiento" required>
                            <option value="">Cargando médicos...</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnImprimirSeleccionado">Imprimir</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        let idPacienteActual = null;

        // Mostrar/ocultar "Otros" cuando se seleccione/deseleccione
        $('#procedimientos_consentimiento').on('change', function() {
            const opciones = $(this).val() || [];
            if (opciones.includes('OTROS')) {
                $('#otros_container').show();
                $('#otros_especificar').prop('required', true);
            } else {
                $('#otros_container').hide();
                $('#otros_especificar').prop('required', false).val('');
            }
        });

        // Cuando se abre el modal (al hacer clic en cualquier botón de imprimir)
        $('#modalSeleccionTipoConsentimiento').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget); // Botón que abrió el modal
            idPacienteActual = button.data('id-paciente');

            // Poner el ID del paciente en el input hidden
            $('#id_paciente_modal').val(idPacienteActual);

            // Cargar los tipos de consentimiento vía AJAX
            $.ajax({
                url: raiz_url + 'patient/cargar_tipos_consentimiento',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const select = $('#tipo_consentimiento');
                    select.empty();
                    select.append('<option value="">Seleccione un tipo...</option>');

                    if (data.length > 0) {
                        $.each(data, function(index, item) {
                            select.append(`<option value="${item.id}">${item.nombre_tipo_consulta}</option>`);
                        });
                    } else {
                        select.append('<option value="">No hay tipos disponibles</option>');
                    }
                },
                error: function() {
                    $('#tipo_consentimiento').html('<option value="">Error al cargar</option>');
                }
            });

            // NUEVO: Cargar médicos
            $.ajax({
                url: raiz_url + 'patient/cargar_medicos', // ← tu nuevo método
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const selectMedico = $('#medico_consentimiento');
                    selectMedico.empty();
                    selectMedico.append('<option value="">Seleccione el médico...</option>');

                    if (data && data.length > 0) {
                        $.each(data, function(index, item) {
                            // Seleccionar por defecto al médico logueado
                            const selected = (item.id == <?= json_encode($this->session->userdata('CAREYES_ID_USUARIO')) ?>) ? ' selected' : '';
                            selectMedico.append(`<option value="${item.id}"${selected}>${item.nombre}</option>`);
                        });
                    } else {
                        selectMedico.append('<option value="">No hay médicos disponibles</option>');
                    }
                },
                error: function() {
                    $('#medico_consentimiento').html('<option value="">Error al cargar médicos</option>');
                }
            });

        });

        $('#btnImprimirSeleccionado').on('click', function() {
            const idTipo = $('#tipo_consentimiento').val();
            const indicaciones = $('#procedimientos_consentimiento').val() || [];
            const otros = $('#otros_especificar').val().trim();
            const idMedico = $('#medico_consentimiento').val() || [];
            const idPaciente = $('#id_paciente_modal').val();

            if (!idTipo) {
                alert('Seleccione un tipo de consentimiento');
                return;
            }

            if (indicaciones.includes('OTROS') && !otros) {
                alert('Especifique los "Otros" motivos/indicaciones');
                return;
            }


            if (!idMedico) {
                alert('Seleccione el médico que atenderá');
                return;
            }

            if (!idPaciente) {
                alert('Error: No se detectó ID de paciente');
                return;
            }

            // Convertir array a string con guión (separador seguro)
            const indicacionesIds = indicaciones.join('-');
            // Construir URL con los 3 parámetros
            let url = `${raiz_url}Consult/previewConsentimiento/${idPaciente}/${idTipo}/${idMedico}/${indicacionesIds}`;
            if (otros) {
               url += '?otros=' + encodeURIComponent(otros);
            }

            console.log('Imprimiendo consentimiento con médico:', url); // para depurar

            window.open(url, '_blank');

            $('#modalSeleccionTipoConsentimiento').modal('hide');
        });
    });
</script>