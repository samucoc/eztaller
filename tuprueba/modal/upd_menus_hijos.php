

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
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <select name="mod_m_ncorr" id="mod_m_ncorr" required type="text" class="form-control" placeholder="Menú">
                                <?php 
                                    $query_papa=mysqli_query($con,"select nombre, m_ncorr
                                                                        from menus
                                                                        where estado = '1'");
                                    while ($row_papa=mysqli_fetch_array($query_papa)) {
                                                ?>
                                    <option value="<?php echo $row_papa['m_ncorr']?>"><?php echo utf8_encode($row_papa['nombre'])?></option>
                                <?php }?>
                            </select>    
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <input name="mod_nombre"  id="mod_nombre" required type="text" class="form-control" placeholder="Nombre">
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <input name="mod_descripcion"  id="mod_descripcion" type="text" class="form-control" placeholder="Descripción" required>
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <input name="mod_icono"  id="mod_icono" required type="text" class="form-control" placeholder="Icono">
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <input name="mod_link"  id="mod_link" type="text" class="form-control" placeholder="Link" required>
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <select name="mod_estado"  id="mod_estado" required class="form-control" placeholder="estado">
                                <option value=1>OK</option>
                                <option value=0>Deshabilitado</option>
                            </select>
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <input name="mod_orden"  id="mod_orden" type="text" class="form-control" placeholder="Orden" required>
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