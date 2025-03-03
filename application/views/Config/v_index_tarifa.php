<style>
.fa-x {
   font-size: 1.5em;
}
</style>
<div class="container-fluid">
   <div class="row">
      <div class="col-lg-3 space"></div>
      <div class="col-sm-12 col-lg-6 table-tarifas">
         <br>
         <div class="panel panel-primary ">
            <div class="panel-heading header-primary">
               <div class="panel-title text-left"><span class="heading-primary">TARIFAS</span>
                  <?php
                    if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                        $disabled = '';
                    else:
                        $disabled = 'disabled';
                    endif;?>
                  <?php  if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):?>

                  <a href="" class="btn pull-right btn-header" id="btnNewTarifa">
                     <i class="fas fa-plus" prescription-bottle aria-hidden="true"></i> Nueva tarifa
                  </a>
                  <?php endif;?>

               </div>
            </div>
            <div class="panel-body">
               <!--  <div style="clear:both"><br></div> -->
               <div class="control-group text-left">
                  <div class="table-">
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
                              <td style="width: 25%;">

                                 <button id="btnEditTarifa" class="btn btn-defaultx btn-edit-tarifa"
                                    data-original-title="Editar tarifa" data-toggle="tooltip"
                                    data-id-tarifa="<?= $ROW['ID_TARIFA'] ?>"
                                    data-name-tarifa="<?= $ROW['NOMBRE_TARIFA'];?>"
                                    data-per-tarifa="<?= $ROW['PORCENTAJE_TARIFA'];?>">
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
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3 space"></div>
      
      
      <div class="col-lg-6 col-sm-12 form-tarifas" style="display:none">
         <br>
         <div class="panel">
            <div class="panel-heading header-primary">
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
                  <div class="text-center">
                     <button type="button" class="xbutton btnx btn-cancel" tabindex="0">
                        <span class=".xbutton-label">cancelar</span>
                     </button>
                     <button type="submit" class="xbutton btnx" tabindex="0">
                        <span class=".xbutton-label">registrar tarifa</span>
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>

      <div class="col-lg-6 col-sm-12 formEdit-tarifas" style="display:none">
         <br>
         <div class="panel">
            <div class="panel-heading header-primary">
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
                  <div class="text-center">
                     <button type="button" class="xbutton btnx btn-cancel" tabindex="0">
                        <span class=".xbutton-label">cancelar</span>
                     </button>
                     <button type="submit" class="xbutton btnx" tabindex="0" aria-hidden="true">
                        <span class=".xbutton-label">Guardar cambios</span>
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- modal agregado -->
<div class="modal fade" id="recordTarifa" tabindex="-1" role="dialog" aria-labelledby="recordTarifa" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header header-primary" id="modalHeaderAdvice">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalTitleAdvice">Usuario dado de alta</h4>
         </div>
         <div class="modal-body text-center" id="recordBodyTarifa">

         </div>
         <div class="clear"></div>
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

<!--modal eliminar -->
<div class="modal fade" id="modDelTarifa" tabindex="-1" role="dialog" aria-labelledby="modDelTarifa" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header header-primary" id="modalHeaderAdvice">
            <button type="button" class="close" data-dismiss="modal" style="color:#FFF;" aria-label="Close"><span
                  style="color:#FFF;" aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalTitleAdvice">Borrar usuario</h4>
         </div>
         <div class="modal-body text-center" id="modBodyDelTarifa">
         </div>
         <div class="clear"></div>
         <div class="modal-footer">
            <div class="btn-group ">
               <button class="btn btn-default" type="button" data-dismiss="modal">
                  <i class="fa fa-times" aria-hidden="true"></i> Cancelar
               </button>
               <button class="btn btn-primary" type="button" id="btnDelRowTarifa">
                  <i class="fa fa-check-circle" aria-hidden="true"></i> Sí, borrar
               </button>
            </div>
         </div>
      </div>
   </div>
</div>