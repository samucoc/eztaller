<?php
    $title ="Mantenedores | ";
    include "head.php";
    include "sidebar.php";
?>
        
    <div class="right_col" role="main"><!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <ul class="nav nav-pills text-center menu-box-level2" role="tablist" id="tabs--slide">
                                        <?php 
                                            $id=$_SESSION['user_id'];
                                            $query=mysqli_query($con,"select  nombre, link , icono
                                                                        from menus_hijos
                                                                        where mh_ncorr in (select menu_hijo
                                                                                            from  perfiles_tienen_menus_hijos
                                                                                            where perfil in (select perfil from user where id= $id)
                                                                                and menu in (select m_ncorr 
                                                                                            from menus 
                                                                                            where link = 'mantenedores_main.php')
                                                                                            )
                                                                            and estado = '1'");
                                            if ($query){
                                                while ($row=mysqli_fetch_array($query)) {
                                        ?>    
                                        <li >
                                            <a href="#" class="configuration" data-link="<?php echo $row['link'] ?>"><i class="<?php echo $row['icono'] ?>"></i> <?php echo ($row['nombre']) ?></a>
                                        </li>
                                        <?php 
                                                }
                                            }                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default bg-white">
                            <div class="panel-body">
                                <div class="tab-content tab-content-slide tab-content-slide-fix">
                                    <div class="tab-pane fade in active" id="vistaMantenedores"></div>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /page content -->


<?php include "footer.php" ?>

<script>
    $(document).on('click', '.configuration', function () {
        var link = $(this).data('link')
        $('#vistaMantenedores').load(link);
    });

</script>