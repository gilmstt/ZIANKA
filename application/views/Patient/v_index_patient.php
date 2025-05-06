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
                                        <th width="10%" class="text-center active">No. Expediente</th>
                                        <th width="15%" class="text-center active">Acciones</th>
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