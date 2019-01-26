
    <div> <!-- Modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg-add"><i class="fa fa-plus-circle"></i> Agregar Menús Hijos</button>
    </div>
    <div class="modal fade bs-example-modal-lg-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Agregar Menús Hijos</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left input_mask" id="add_user" name="add_user">
                        <div id="result_user"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <select name="p_ncorr" required type="text" class="form-control" placeholder="Perfiles">
                                <?php 
                                    $query=mysqli_query($con,"select nombre, p_ncorr
                                                                        from perfiles");
                                    while ($row=mysqli_fetch_array($query)) {
                                                ?>
                                    <option value="<?php echo $row['p_ncorr']?>"><?php echo utf8_encode($row['nombre'])?></option>
                                <?php }?>
                            </select>    
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <select name="m_ncorr" required type="text" class="form-control" placeholder="Menús">
                                <?php 
                                    $query=mysqli_query($con,"select nombre, m_ncorr
                                                                        from menus
                                                                        where estado = '1'");
                                    while ($row=mysqli_fetch_array($query)) {
                                                ?>
                                    <option value="<?php echo $row['m_ncorr']?>"><?php echo utf8_encode($row['nombre'])?></option>
                                <?php }?>
                            </select>    
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <select name="mh_ncorr" required type="text" class="form-control" placeholder="Menús">
                                <?php 
                                    $query=mysqli_query($con,"select nombre, mh_ncorr
                                                                        from menus_hijos
                                                                        where estado = '1'");
                                    while ($row=mysqli_fetch_array($query)) {
                                                ?>
                                    <option value="<?php echo $row['mh_ncorr']?>"><?php echo utf8_encode($row['nombre'])?></option>
                                <?php }?>
                            </select>    
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                              <button id="save_data" type="submit" class="btn btn-success">Guardar</button>
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