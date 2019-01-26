<?php
    include_once "config/config.php";//Contiene funcion que conecta a la base de datos
    global $con;
    ?>    
    <div class="" role="main"><!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <h3>Detalle Inventario Total</h3>
                <div id="resultado_accion"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <input type="text" name="fecha1" id="fecha1" class="form-control pull-right" >
                        <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
                        <input type="text" name="fecha2" id="fecha2" class="form-control pull-right" >
                        <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <input id="codigo" required type="text" class="form-control" placeholder="Codigo"
                            onblur='buscarDescripcion()'/>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input id="descripcion" required type="text" class="form-control" placeholder="Descripcion" readonly="readonly" />
                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button id="save_line" type="button" class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                    <div class="ln_solid"></div>

                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <!-- ajax -->
                                    <div id="resultados"></div><!-- Carga los datos ajax -->
                                    <div class='outer_div'></div><!-- Carga los datos ajax -->
                                <!-- /ajax -->
                            </div>
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
    </div><!-- /page content -->

<script type="text/javascript" src="js/detalle_toma_inventario.js"></script>

