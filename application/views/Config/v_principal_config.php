<style>
    .fa-x {
        font-size: 1.5em;
    }
</style>
<div class="container-fluid">
    <br>
    <div class="col-lg-1"></div>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10">
        <div class="panel with-nav-tabs panel-primary">
            <div class="panel-heading header-primary">
                <ul class="nav nav-tabs">
                    <li id="li_Users" <?= $user_active ?>><a href="#USUARIOS" data-toggle="tab"><i class="fa fa-users"></i> USUARIOS</a></li>
                    <li id="li_Tarifas" <?= $tar_active ?>><a href="#TARIFAS" data-toggle="tab"><i class="fa fa-dollar-sign"></i> TARIFAS</a></li>
                    <li id="li_Membresias" <?= $mem_active ?>><a href="#MEMBRESIAS" data-toggle="tab"><i class="fa fa-credit-card"></i> MEMBRESIAS</a></li>
                    <li id="li_Perfil" <?= $per_active ?>><a href="#PERFILES" data-toggle="tab"><i class="fa fa-user"></i> PERFILES</a></li>
                    <li id="li_Casas" <?= $cas_active ?>><a href="#CASAS" data-toggle="tab"><i class="fa fa-home"></i> CASAS</a></li>
                    <?php
                    $disabled = ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR) ? "" : "disabled";
                    if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                        ?>
                        <button class="btn pull-right btn-header <?= $tar_hidex ?>" id="btnNewTarifa">
                            <i class="fas fa-plus" aria-hidden="true"></i> Nueva tarifa
                        </button>
                        <a href="<?= base_url() ?>config/form_config_add_user" class="btn pull-right btn-header <?= $user_hidex ?>" id="btnAddUser">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Usuario
                        </a>
                        <button class="btn pull-right btn-header <?= $mem_hidex ?>" id="btnNewMembresia">
                            <i class="fas fa-plus" aria-hidden="true"></i> Nueva membresia
                        </button>
                        <button class="btn pull-right btn-header <?= $per_hidex ?>" id="btnNewPerfil">
                            <i class="fas fa-plus" aria-hidden="true"></i> Nuevo perfil
                        </button>
                        <button class="btn pull-right btn-header <?= $cas_hidex ?>" id="btnAddCasa">
                            <i class="fa fa-plus" aria-hidden="true"></i> Nueva Casa
                        </button>
                    <?php endif; ?>
                </ul>
                <!--  </div> -->
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade <?= $user_in_active ?>" id="USUARIOS">
                        <div class="panel-body p-none">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <table id="dataUser" class="table table-bordered display" style="font-size: 14px;" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 10%;">Acciones</th>
                                                <th style="width: 20%">Nombre Usuario</th>
                                                <th style="width: 20%">Apellido Usuario</th>
                                                <th style="width: 15%">Usuario</th>
                                                <th style="width: 15%">Autoridad</th>
                                                <th style="width: 15%">Último Login</th>
                                            </tr>
                                        </thead>

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
                    </div>
                    <div class="tab-pane fade <?= $tar_in_active ?>" id="TARIFAS">
                        <div class="panel-body p-none">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 table-tarifas">
                                    <table id="dataTarifa" class="table table-bordered text-left"
                                           style="font-size: 14px; border-radius:5px" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Acciones</th>
                                                <th class="text-center">Nombre</th>
                                                <th class="text-center">Porcentaje</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px; letter-spacing: 0.5px;" id="tbodyTarifa">
                                            <?php
                                            if (count($ROW_TARIFA)):
                                                foreach ($ROW_TARIFA as $ROW):
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: center; width: 25%;">
                                                            <button id="btnEditTarifa" class="btn btn-defaultx btn-edit-tarifa"
                                                                    data-original-title="Editar tarifa" data-toggle="tooltip"
                                                                    data-id-tarifa="<?= $ROW['ID_TARIFA'] ?>"
                                                                    data-name-tarifa="<?= $ROW['NOMBRE_TARIFA']; ?>"
                                                                    data-per-tarifa="<?= $ROW['PORCENTAJE_TARIFA']; ?>"
                                                                    data-con-tax="<?= $ROW['CONSULTA_TARIFA']; ?>"
                                                                    data-urg-tax="<?= $ROW['URGENCIA_TARIFA']; ?>">
                                                                <i class="fas fa-edit fa-x"></i>
                                                            </button>
                                                            <button id="btnDeleteTarifa" class="btn btn-defaultz btn-delete-tarifa"
                                                                    data-original-title="Eliminar tarifa" data-toggle="tooltip"
                                                                    data-id-tarifa="<?= $ROW['ID_TARIFA'] ?>">
                                                                <i class="fa fa-trash fa-x" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                        <td name="name"><?= mb_strtoupper($ROW['NOMBRE_TARIFA']) ?></td>
                                                        <td name="percentage">% <?= mb_strtoupper($ROW['PORCENTAJE_TARIFA']) ?></td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </tbody>
                                    </table>                       
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-6 form-tarifas" style="display:none">                           
                                    <div class="panel">
                                        <div class="panel-heading header-primary header-config">
                                            <div class="panel-title text-left"><span class="heading-primary">NUEVA TARIFA</span>
                                                <?php
                                                if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                                                    $disabled = '';
                                                else:
                                                    $disabled = 'disabled';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" id="addTarifa">
                                                <div class="form-group">
                                                    <label for="">NOMBRE</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                                                        <input type="text" name="RG_NOMBRE_TARIFA" class="form-control" placeholder="Escribe aquí.."
                                                                required>
                                                    </div>
                                                    <div class="add-name-error" style="color: red; margin-top: 5px;"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">PORCENTAJE</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-percentage"></i></span>
                                                        <input type="text" name="RG_PORCENTAJE_TARIFA" min="0" pattern="[0-9]+" class="form-control"
                                                               placeholder="Escribe aquí.." required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">CONSULTA</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-dollar-sign"></i></span>
                                                        <input type="text" name="RG_ADD_CONSULTA_TARIFA" min="0" pattern="[0-9]+" class="form-control"
                                                               placeholder="Escribe aquí.." required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">URGENCIA</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-dollar-sign"></i></span>
                                                        <input type="text" name="RG_ADD_URGENCIA_TARIFA" min="0" pattern="[0-9]+" class="form-control"
                                                               placeholder="Escribe aquí.." required>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="button" class="btn btnx btn-cancel">
                                                        <span class=".xbutton-label">cancelar</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-info">
                                                        <span class=".xbutton-label">registrar tarifa</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-6 formEdit-tarifas" style="display:none">                           
                                    <div class="panel">
                                        <div class="panel-heading header-primary header-config">
                                            <div class="panel-title text-left"><span class="heading-primary">EDITAR TARIFA</span>
                                                <?php
                                                if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                                                    $disabled = '';
                                                else:
                                                    $disabled = 'disabled';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" class="needs-validation" id="editTarifa">
                                                <input type="hidden" value="" name="RG_ID_TARIFA" id="RG_ID_TARIFA">
                                                <div class="form-group">
                                                    <label for="">NOMBRE</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                                                        <input type="text" name="RG_NOMBRE_TARIFA" class="form-control" 
                                                               placeholder="Escribe aquí.." required>
                                                        <!-- <div class="help-block with-errors"></div> -->
                                                    </div>
                                                    <div class="edit-name-error" style="color: red; margin-top: 5px;"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">PORCENTAJE</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon2"><i class="fas fa-percentage"></i></span>
                                                        <input type="text" name="RG_PORCENTAJE_TARIFA" class="form-control" placeholder="Escribe aquí.."
                                                               required>
                                                        <!-- <div class="help-block with-errors"></div> -->
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">CONSULTA</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon3"><i class="fas fa-dollar-sign"></i></span>
                                                        <input type="text" name="RG_CONSULTA_TARIFA" class="form-control" placeholder="Escribe aquí.."
                                                               required>
                                                        <!-- <div class="help-block with-errors"></div> -->
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">URGENCIA</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon4"><i class="fas fa-dollar-sign"></i></span>
                                                        <input type="text" name="RG_URGENCIA_TARIFA" class="form-control" placeholder="Escribe aquí.."
                                                               required>
                                                        <!-- <div class="help-block with-errors"></div> -->
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-cancel btn-cancel">
                                                        <span class=".xbutton-label">cancelar</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-info">
                                                        <span class=".xbutton-label">Guardar cambios</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade <?= $mem_in_active ?>" id="MEMBRESIAS">
                        <div class="panel-body p-none">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 table-membresias">
                                    <table id="dataMembresia" class="table table-bordered text-left"
                                           style="font-size: 14px; border-radius:5px" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Acciones</th>
                                                <th class="text-center">Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px; letter-spacing: 0.5px;" id="tbodyMembresia">

                                            <?php
                                            if (count($ROW_MEMBRESIA)):
                                                foreach ($ROW_MEMBRESIA as $ROW):
                                                    ?>
                                                    <tr>
                                                        <td style="width: 25%; text-align: center;">
                                                            <button id="btnEditMembresia" class="btn btn-defaultx btn-edit-membresia"
                                                                    data-original-title="Editar membresia" data-toggle="tooltip"
                                                                    data-id-membresia="<?= $ROW['ID_MEMBRESIA'] ?>"
                                                                    data-name-membresia="<?= $ROW['NOMBRE_MEMBRESIA']; ?>">
                                                                <i class="fas fa-edit fa-x"></i>
                                                            </button>
                                                            <button id="btnDeleteMembresia" class="btn btn-defaultz btn-delete-membresia"
                                                                    data-original-title="Eliminar membresia" data-toggle="tooltip"
                                                                    data-id-membresia="<?= $ROW['ID_MEMBRESIA'] ?>">
                                                                <i class="fa fa-trash fa-x" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                        <td name="name"><?= mb_strtoupper($ROW['NOMBRE_MEMBRESIA']) ?></td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </tbody>
                                    </table>                       
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-6 form-membresia" style="display:none">                           
                                    <div class="panel">
                                        <div class="panel-heading header-primary header-config">
                                            <div class="panel-title text-left"><span class="heading-primary">NUEVA MEMBRESIA</span>
                                                <?php
                                                if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                                                    $disabled = '';
                                                else:
                                                    $disabled = 'disabled';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" id="addMembresia">
                                                <div class="form-group">
                                                    <label for="">NOMBRE</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                                                        <input type="text" name="RG_NOMBRE_MEMBRESIA" class="form-control" placeholder="Escribe aquí.." required>
                                                    </div>
                                                    <div class="add-name-error" style="color: red; margin-top: 5px;"></div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-cancel btn-cancel-mem">
                                                        <span class=".xbutton-label">cancelar</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-info">
                                                        <span class=".xbutton-label">registrar membresia</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-6 formEdit-membresias" style="display:none">                           
                                    <div class="panel">
                                        <div class="panel-heading header-primary header-config">
                                            <div class="panel-title text-left"><span class="heading-primary">EDITAR MEMBRESIA</span>
                                                <?php
                                                if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                                                    $disabled = '';
                                                else:
                                                    $disabled = 'disabled';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" class="needs-validation" id="editMembresia">
                                                <input type="hidden" value="" name="RG_ID_MEMBRESIA" id="RG_ID_MEMBRESIA">
                                                <div class="form-group">
                                                    <label for="">NOMBRE</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                                                        <input type="text" name="RG_NOMBRE_MEMBRESIA" class="form-control"
                                                               placeholder="Escribe aquí.." required>
                                                    </div>
                                                    <div class="edit-name-error" style="color: red; margin-top: 5px;"></div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-cancel btn-cancel-mem">
                                                        <span class=".xbutton-label">cancelar</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-info">
                                                        <span class=".xbutton-label">Guardar cambios</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade <?= $per_in_active ?>" id="PERFILES">
                        <div class="panel-body p-none">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 table-perfiles">
                                    <table id="dataperfil" class="table table-bordered text-left"
                                           style="font-size: 14px; border-radius:5px" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Acciones</th>
                                                <th class="text-center">Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px; letter-spacing: 0.5px;" id="tbodyPerfil">
                                            <?php
                                            if (count($ROW_PERFIL)):
                                                foreach ($ROW_PERFIL as $ROW):
                                                    ?>
                                                    <tr>
                                                        <td style="width: 25%; text-align: center;">
                                                            <button id="btnEditPerfil" class="btn btn-defaultx btn-edit-perfil"
                                                                    data-original-title="Editar perfil" data-toggle="tooltip"
                                                                    data-id-perfil="<?= $ROW['ID_PERFIL'] ?>"
                                                                    data-name-perfil="<?= $ROW['NOMBRE_PERFIL']; ?>">
                                                                <i class="fas fa-edit fa-x"></i>
                                                            </button>
                                                            <button id="btnDeletePerfil" class="btn btn-defaultz btn-delete-perfil"
                                                                    data-original-title="Eliminar perfil" data-toggle="tooltip"
                                                                    data-id-perfil="<?= $ROW['ID_PERFIL'] ?>">
                                                                <i class="fa fa-trash fa-x" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                        <td name="name"><?= mb_strtoupper($ROW['NOMBRE_PERFIL']) ?></td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </tbody>
                                    </table>                       
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-6 form-perfil" style="display:none">                           
                                    <div class="panel">
                                        <div class="panel-heading header-primary header-config">
                                            <div class="panel-title text-left"><span class="heading-primary">NUEVO PERFIL</span>
                                                <?php
                                                if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                                                    $disabled = '';
                                                else:
                                                    $disabled = 'disabled';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" id="addPerfil">
                                                <div class="form-group">
                                                    <label for="">NOMBRE</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                                                        <input type="text" name="RG_NOMBRE_PERFIL" class="form-control" placeholder="Escribe aquí.." required>
                                                    </div>
                                                    <div class="add-name-error" style="color: red; margin-top: 5px;"></div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-cancel btn-cancel-per">
                                                        <span class=".xbutton-label">cancelar</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-info">
                                                        <span class=".xbutton-label">registrar perfil</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-6 formEdit-perfil" style="display:none">                           
                                    <div class="panel">
                                        <div class="panel-heading header-primary header-config">
                                            <div class="panel-title text-left"><span class="heading-primary">EDITAR PERFIL</span>
                                                <?php
                                                if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                                                    $disabled = '';
                                                else:
                                                    $disabled = 'disabled';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" class="needs-validation" id="editPerfil">
                                                <input type="hidden" value="" name="RG_ID_PERFIL" id="RG_ID_PERFIL">
                                                <div class="form-group">
                                                    <label for="">NOMBRE</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                                                        <input type="text" name="RG_NOMBRE_PERFIL" class="form-control" placeholder="Escribe aquí.." required>
                                                    </div>
                                                    <div class="edit-name-error" style="color: red; margin-top: 5px;"></div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-cancel btn-cancel-per">
                                                        <span class=".xbutton-label">cancelar</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-info">
                                                        <span class=".xbutton-label">Guardar cambios</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade <?= $cas_in_active ?>" id="CASAS">
                        <div class="panel-body p-none">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 table-house">
                                    <table id="datahouse" class="table table-bordered text-left"
                                           style="font-size: 14px; border-radius:5px" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Acciones</th>
                                                <th class="text-center">Nombre</th>
                                                <th class="text-center">Membresia</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px; letter-spacing: 0.5px;" id="tbodyPerfil">
                                            <?php
                                            if (count($ROW_CASAS)):
                                                foreach ($ROW_CASAS as $ROW):
                                                    ?>
                                                    <tr>
                                                        <td style="width: 25%; text-align: center;">
                                                            <button id="btnEditHouse" class="btn btn-defaultx btn-edit-house"
                                                                    data-original-title="Editar casa" data-toggle="tooltip"
                                                                    data-id-house="<?= $ROW['ID_CASA'] ?>"
                                                                    data-name-house="<?= $ROW['NOMBRE_CASA'] ?>"
                                                                    data-id-membresia="<?= $ROW['ID_MEMBRESIA'] ?>">
                                                                <i class="fas fa-edit fa-x"></i>
                                                            </button>
                                                            <button id="btnDeleteHouse" class="btn btn-defaultz btn-delete-house"
                                                                    data-original-title="Eliminar casa" data-toggle="tooltip"
                                                                    data-id-house="<?= $ROW['ID_CASA'] ?>">
                                                                <i class="fa fa-trash fa-x" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                        <td name="name"><?= mb_strtoupper($ROW['NOMBRE_CASA']) ?></td>
                                                        <td name="id_membresia"><?= mb_strtoupper($ROW['NOMBRE_MEMBRESIA']) ?></td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </tbody>
                                    </table>                       
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-6 form-house" style="display:none">                           
                                    <div class="panel">
                                        <div class="panel-heading header-primary header-config">
                                            <div class="panel-title text-left"><span class="heading-primary">NUEVA CASA</span>
                                                <?php
                                                if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                                                    $disabled = '';
                                                else:
                                                    $disabled = 'disabled';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" id="addHouse">
                                                <div class="form-group">
                                                    <label for="">NOMBRE</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                                                        <input type="text" name="RG_NOMBRE_CASA" class="form-control" placeholder="Escribe aquí.." required>
                                                    </div>
                                                    <div class="add-name-error" style="color: red; margin-top: 5px;"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="RG_ID_MEMBRESIA" class="control-label text-left"  >Membresia</label>
                                                    <select required name="RG_ID_MEMBRESIA" id="RG_ID_MEMBRESIA" class="form-control">
                                                        <option value="-1">Elegir una opción</option>
                                                        <?php
                                                        if (count($ROW_MEMBRESIA) > NULO):
                                                            foreach ($ROW_MEMBRESIA as $ROW):
                                                                ?>
                                                                <option value="<?= $ROW['ID_MEMBRESIA'] ?>">
                                                                    <?= $ROW['NOMBRE_MEMBRESIA'] ?>
                                                                </option>
                                                                <?php
                                                            endforeach;
                                                        else:
                                                            ?>
                                                            <option value="-1">No existen registros</option>
                                                        <?php
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-cancel btn-cancel-add-house">
                                                        <span class=".xbutton-label">cancelar</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-info">
                                                        <span class=".xbutton-label">registrar casa</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-6 formEdit-house" style="display:none">                           
                                    <div class="panel">
                                        <div class="panel-heading header-primary header-config">
                                            <div class="panel-title text-left"><span class="heading-primary">EDITAR CASA</span>
                                                <?php
                                                if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                                                    $disabled = '';
                                                else:
                                                    $disabled = 'disabled';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" class="needs-validation" id="editHouse">
                                                <input type="hidden" value="" name="RG_ID_CASA" id="RG_ID_CASA">
                                                <div class="form-group">
                                                    <label for="">NOMBRE</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                                                        <input type="text" name="RG_NOMBRE_CASA" class="form-control" placeholder="Escribe aquí.." required>
                                                    </div>
                                                    <div class="edit-name-error" style="color: red; margin-top: 5px;"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="RG_ID_MEMBRESIA_E" class="control-label text-left"  >Membresia</label>
                                                    <select required name="RG_ID_MEMBRESIA_E" id="RG_ID_MEMBRESIA_E" class="form-control">
                                                        <option value="-1">Elegir una opción</option>
                                                        <?php
                                                        if (count($ROW_MEMBRESIA) > NULO):
                                                            foreach ($ROW_MEMBRESIA as $ROW):
                                                                ?>
                                                                <option value="<?= $ROW['ID_MEMBRESIA'] ?>">
                                                                    <?= $ROW['NOMBRE_MEMBRESIA'] ?>
                                                                </option>
                                                                <?php
                                                            endforeach;
                                                        else:
                                                            ?>
                                                            <option value="-1">No existen registros</option>
                                                        <?php
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-cancel btn-cancel-per">
                                                        <span class=".xbutton-label">cancelar</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-info">
                                                        <span class=".xbutton-label">Guardar cambios</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-1"></div>
</div>