<div class="container-fluid">
    <div class="row">
        <div class="col-sm-1">

        </div>
        <div class="col-sm-10 text-center">
            <br>
            <form data-toggle="validator" role="form" id="formEditdUser">
                <input type="hidden" value="<?= $ROW_DATA_USUARIO[0]['ID_USUARIO'] ?>" name="RG_ID_USUARIO" id="RG_ID_USUARIO" > 
                <div class="panel panel-primary">
                    <div class="panel-heading header-primary">
                        <div class="panel-title text-left">
                            <span class="heading-primary"><i class="fas fa-edit"></i> Editar usuario</span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group text-left">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading header-black text-left"style="color:white">Perfíl</div>
                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="RG_NOMBRE_USUARIO" class="control-label text-left"  >Nombre(s)</label>
                                                <input type="text" name="RG_NOMBRE_USUARIO" required id="RG_NOMBRE_USUARIO" class="form-control" placeholder="Name" value="<?= $ROW_DATA_USUARIO[0]['NOMBRE_USUARIO'] ?>" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ\s]+">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>      
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label for="RG_APELLIDO_USUARIO" class="control-label text-left"  >Apellidos </label>
                                                <input type="text" name="RG_APELLIDO_USUARIO" required id="RG_APELLIDO_USUARIO" class="form-control" placeholder="Last name" value="<?= $ROW_DATA_USUARIO[0]['APELLIDO_USUARIO'] ?>" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ\s]+">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>  
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="RG_ID_AUTORIDAD" class="control-label text-left"  >Autoridad</label>
                                                <select name="RG_ID_AUTORIDAD" id="RG_ID_AUTORIDAD" class="form-control">
                                                    <?PHP
                                                    if (count($ROW_AUTORIDAD) > NULO):
                                                        foreach ($ROW_AUTORIDAD as $ROW):
                                                            $sel = '';
                                                            if ($ROW['ID_ROL'] == $ROW_DATA_USUARIO[0]['ID_ROL'])
                                                                $sel = 'selected';
                                                            ?>
                                                            <option value="<?= $ROW['ID_ROL'] ?>" <?= $sel ?>>
                                                            <?= $ROW['NOMBRE_ROL'] ?>
                                                            </option>
                                                            <?PHP
                                                        endforeach;
                                                    else:
                                                        ?>
                                                        <option value="-1">No existen registros</option>
                                                    <?php
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                                                          
                                        <div style="clear:both"></div>
                                    </div>
                                    <!--FIN DE COL-MD 6 -->
                                </div>   
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading header-black text-left" style="color:white">Datos de accesso</div>
                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="RG_USERNAME_USUARIO" class="control-label text-left"  >User</label>
                                                <input type="text" name="RG_USERNAME_USUARIO" required id="RG_USERNAME_USUARIO" class="form-control" placeholder="username" value="<?= $ROW_DATA_USUARIO[0]['USERNAME_USUARIO'] ?>" pattern="[0-9a-zA-z_-]{2,}">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="RG_PASSWD_USUARIO" class="control-label text-left"  >Contraseña</label>
                                                <input type="text" name="RG_PASSWD_USUARIO" id="RG_PASSWD_USUARIO" class="form-control" required placeholder="password" value="<?= $ROW_DATA_USUARIO[0]['PASSWD_USUARIO'] ?>">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                         
                            </div>   
                        </div>
                    </div>
                    <div class="panel-footer">
                    <div class="row">
                            <div class="col-lg-12">
                                <a href="<?= base_url() ?>Config/index" class="btn btn-cancel pull-left" >
                                    <i class="fas fa-chevron-double-left"></i> Regresar
                                </a>
                                <button type="submit" class="btn btn-info pull-right" id="okAddUser">
                                    <i class="fas fa-user-check"></i> Guardar cambios
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-1">
            <br>
        </div>
    </div>
</div>

<div class="modal fade" id="modUser" tabindex="-1" role="dialog" aria-labelledby="modUser" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Usuario actualizado</h4>
            </div>
            <div class="modal-body text-center" id="modBodyUser">

            </div>
            <div class="clear"></div>
            <div class="modal-footer">
                <div class="btn-group "> 
                    <button class="btn btn-primary" type="button"  id="btnOkAdvice"  data-dismiss="modal">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>  Entiendo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>