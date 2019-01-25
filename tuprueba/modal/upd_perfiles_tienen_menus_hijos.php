

    <div class="modal fade bs-example-modal-lg-upd" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Editar Menús Hijos</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left input_mask" id="upd_user" name="upd_user">
                        <div id="result_user"></div>
                        <input type="hidden" id="mod_id" name="mod_id">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <select name="mod_p_ncorr" id="mod_p_ncorr" required type="text" class="form-control" placeholder="Perfiles">
                                <?php 
                                    $query_papa=mysqli_query($con,"select nombre, p_ncorr
                                                                        from perfiles");
                                    while ($row_papa=mysqli_fetch_array($query_papa)) {
                                                ?>
                                    <option value="<?php echo $row_papa['p_ncorr']?>"><?php echo utf8_encode($row_papa['nombre'])?></option>
                                <?php }?>
                            </select>    
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <select name="mod_mh_ncorr" id="mod_mh_ncorr" required type="text" class="form-control" placeholder="Menús Hijos">
                                <?php 
                                    $query_papa=mysqli_query($con,"select nombre, mh_ncorr
                                                                        from menus_hijos
                                                                        where estado = '1'");
                                    while ($row_papa=mysqli_fetch_array($query_papa)) {
                                                ?>
                                    <option value="<?php echo $row_papa['mh_ncorr']?>"><?php echo utf8_encode($row_papa['nombre'])?></option>
                                <?php }?>
                            </select>    
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                              <button id="upd_data" type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> <!-- /Modal -->