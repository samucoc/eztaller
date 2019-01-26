<?php

    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if (isset($_GET['id'])){
        $id_expence=intval($_GET['id']);
        $query=mysqli_query($con, "SELECT * from menus_hijos where mh_ncorr='".$id_expence."'");
        $count=mysqli_num_rows($query);
            if ($delete1=mysqli_query($con,"DELETE FROM menus_hijos WHERE mh_ncorr='".$id_expence."'")){
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
        $aColumns = array('mh_ncorr','m_ncorr', ' menus_hijos.nombre', ' menus_hijos.descripcion',' menus_hijos.icono', ' menus_hijos.link',' menus_hijos.estado', ' menus_hijos.orden');//Columnas de busqueda
        $sTable = "menus_hijos";
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
        $sWhere.=" order by m_ncorr, orden";
        
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
        $reload = './menus_hijos.php';
        //main query to fetch the data
        $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        if ($numrows>0){
            
            ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                        <th class="column-title">Menú Padre </th>
                        <th class="column-title">Nombre </th>
                        <th class="column-title">Descripción</th>
                        <th class="column-title">Icono </th>
                        <th class="column-title">Link</th>
                        <th class="column-title">Estado </th>
                        <th class="column-title">Orden</th>
                        <th class="column-title no-link last"><span class="nobr"></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        while ($r=mysqli_fetch_array($query)) {
                            $query_papa=mysqli_query($con,"select nombre
                                                        from menus
                                                        where m_ncorr = '".$r['m_ncorr']."'");
                            $papa = 'NA';
                            while ($row=mysqli_fetch_array($query_papa)) {
                                $papa=$row['nombre'];
                            }
                            $id = $r['mh_ncorr'];
                            $m_ncorr = $r['m_ncorr'];
                            $nombre=$r['nombre'];
                            $nombre=$r['nombre'];
                            $descripcion=$r['descripcion'];
                            $icono=$r['icono'];
                            $link=$r['link'];
                            $estado=$r['estado']=='1'? 'Habilitado' : 'Deshabilitado';
                            $orden=$r['orden'];
                            
                ?>
                    <input type="hidden" value="<?php echo $m_ncorr;?>" id="m_ncorr<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $nombre;?>" id="nombre<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $descripcion;?>" id="descripcion<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $icono;?>" id="icono<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $link;?>" id="link<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $r['estado'];?>" id="estado<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $orden;?>" id="orden<?php echo $id;?>">

                    <tr class="even pointer">
                        <td><?php echo utf8_encode($papa);?></td>
                        <td><?php echo utf8_encode($nombre);?></td>
                        <td><?php echo utf8_encode($descripcion);?></td>
                        <td><?php echo utf8_encode($icono);?></td>
                        <td><?php echo utf8_encode($link);?></td>
                        <td><?php echo utf8_encode($estado);?></td>
                        <td><?php echo utf8_encode($orden);?></td>
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