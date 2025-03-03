<div class="container-fluid">
    <div class="row">
        <div class="col-sm-1 text-center"></div>
        <div class="col-sm-10 text-center">
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading header-primary">
                    <div class="panel-title text-left"><span class="heading-primary">Configuración de usuario</span>
                        <a href="<?= base_url() ?>config/form_config_add_user" class="btn pull-right btn-header" id="btnAddUser">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>Nuevo Usuario
                        </a>
                    </div>
                </div>

                <div class="panel-body">

                    <div style="clear:both"><br></div>
                    <div class="control-group text-left">
                        <div class="table-responsive">
                            <table id="dataUser" class="table table-bordered display" style="font-size: 14px;" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; width: 10%;">Acciones</th>
                                        <th style="width: 20%">Nombre Usuario</th>
                                        <th style="width: 20%">Apellido Usuario</th>
                                        <th style="width: 15%">Usuario</th>
                                        <th style="width: 15%">Autoridad</th>
                                        <th style="width: 15%">Último Login</th>
                                        <!--<th style="width: 15%">Rol</th>-->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td colspan="6"><br></td>
                                    </tr>
                                </tfoot>
                                <tbody style="font-size:12px;">
                                    <?php
                                    if (count($ROW_USERS)):
                                        foreach ($ROW_USERS as $ROW):
                                            ?>
                                            <tr>
                                                <td style="text-align: center">
                                                    <button id="btnEditUser" class="btn btn-defaultx btn-edit-user" data-original-title="Editar usuario" data-toggle="tooltip" data-id-user="<?= $ROW['ID_USUARIO'] ?>">
                                                        <i class="fa fa-edit fa-x" aria-hidden="true"></i>
                                                    </button>
                                                    <button id="btnDeleteUser" class="btn btn-defaultz btn-delete-user" data-original-title="Eliminar usuario" data-toggle="tooltip" data-id-user="<?= $ROW['ID_USUARIO'] ?>">
                                                        <i class="fa fa-trash fa-x" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td><?= mb_strtoupper($ROW['NOMBRE_USUARIO']) ?></td>
                                                <td><?= mb_strtoupper($ROW['APELLIDO_USUARIO']) ?></td>
                                                <td><?= mb_strtoupper($ROW['USERNAME_USUARIO']) ?></td>
                                                <td><?= mb_strtoupper($ROW['NOMBRE_ROL']) ?></td>
                                                <td><?= mb_strtoupper($ROW['ULTIMO_LOGIN_USUARIO']) ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-primary pull-left" href="<?= base_url() ?>config/index"><i class="fa fa-backward" aria-hidden="true"></i> Regresar a configuración</a>
                    <div style="clear:both"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-10 text-center"></div>
    </div>

</div>
<!--modal eliminar -->
<div class="modal fade" id="modDelUser" tabindex="-1" role="dialog" aria-labelledby="modDelUser" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" style="color:#FFF;" aria-label="Close"><span style="color:#FFF;" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Borrar usuario</h4>
            </div>
            <div class="modal-body text-center" id="modBodyDelUser">
            </div>
            <div class="clear"></div>
            <div class="modal-footer">
                <div class="btn-group ">
                    <button class="btn btn-default" type="button"  data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i> Cancelar
                    </button>
                    <button class="btn btn-primary" type="button"  id="btnDelRowUser">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>  Sí, borrar
                    </button>
                </div>       
            </div>
        </div>
    </div>
</div>