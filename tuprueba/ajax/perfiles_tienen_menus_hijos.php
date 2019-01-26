<?php

    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if (isset($_GET['id'])){
        $id_expence=intval($_GET['id']);
        $query=mysqli_query($con, "SELECT * from perfiles_tienen_menus_hijos where ptm_ncorr='".$id_expence."'");
        $count=mysqli_num_rows($query);
            if ($delete1=mysqli_query($con,"DELETE FROM perfiles_tienen_menus_hijos WHERE ptm_ncorr='".$id_expence."'")){
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> Datos eliminados exitosamente.
            </div>
            <?php 
        }else {
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
            </div>
<?php
        } //end else
    } //end if
?>

<?php
    if($action == 'ajax'){
        // escaping, additionally removing everything that could be (html/javascript-) code
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $aColumns = array('ptm','perfil', 'menu_hijo');//Columnas de busqueda
        $sTable = "perfiles_tienen_menus_hijos";
        $sWhere = "";
        if ( isset($q) && $q!='undefined' && $_GET['q'] != "" )
        {
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".isset($q) ? $q : ''."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        }
        $sWhere.=" order by ptm_ncorr";
        
        include 'pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 10; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query   = mysqli_query($con, "SELECT coalesce(count(*),0) AS numrows FROM $sTable $sWhere");
        $row= mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $total_pages = ceil($numrows/$per_page);
        $reload = './perfiles_tienen_menus_hijos.php';
        //main query to fetch the data
        $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        if ($numrows>0){
            
            ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                        <th class="column-title">Id </th>
                        <th class="column-title">Perfil </th>
                        <th class="column-title">Menú</th>
                        <th class="column-title">Menú Hijo</th>
                        <th class="column-title no-link last"><span class="nobr"></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        while ($r=mysqli_fetch_array($query)) {
                            $id=$r['ptm_ncorr'];
                            $query_perfil=mysqli_query($con,"select nombre
                                                        from perfiles
                                                        where p_ncorr = '".$r['perfil']."'");
                            $str_perfil = 'NA';
                            while ($row=mysqli_fetch_array($query_perfil)) {
                                $str_perfil=$row['nombre'];
                            }
                            $p_ncorr=$r['perfil'];
                            
                            $query_menu=mysqli_query($con,"select nombre
                                                        from menus
                                                        where m_ncorr = '".$r['menu']."'");
                            $str_menu = 'NA';
                            while ($row=mysqli_fetch_array($query_menu)) {
                                $str_menu=$row['nombre'];
                            }
                            $m_ncorr=$r['menu'];
                           

                            $query_menu=mysqli_query($con,"select nombre
                                                        from menus_hijos
                                                        where mh_ncorr = '".$r['menu_hijo']."'");
                            $str_menu_h = 'NA';
                            while ($row=mysqli_fetch_array($query_menu)) {
                                $str_menu_h=$row['nombre'];
                            }
                            $mh_ncorr=$r['menu_hijo'];
                            
                ?>
                    <input type="hidden" value="<?php echo $p_ncorr;?>" id="p_ncorr<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $mh_ncorr;?>" id="mh_ncorr<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $m_ncorr;?>" id="m_ncorr<?php echo $id;?>">

                    <tr class="even pointer">
                        <td><?php echo utf8_encode($id);?></td>
                        <td><?php echo utf8_encode($str_perfil);?></td>
                        <td><?php echo utf8_encode($str_menu);?></td>
                        <td><?php echo utf8_encode($str_menu_h);?></td>
                        <td ><span class="pull-right">
                        <a href="#" class='btn btn-default' title='Editar Perfil' onclick="obtener_datos('<?php echo $id;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-upd"><i class="glyphicon glyphicon-edit"></i></a> 
                        <a href="#" class='btn btn-default' title='Borrar Perfil' onclick="eliminar('<?php echo $id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
                    </tr>
                <?php
                    } //end while
                ?>
                <tr>
                    <td colspan=6><span class="pull-right">
                        <?php echo paginate($reload, $page, $total_pages, $adjacents);?>
                    </span></td>
                </tr>
              </table>
            </div>
            <?php
        }else{
           ?> 
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> No hay datos para mostrar
            </div>
        <?php    
        }
    }
?>