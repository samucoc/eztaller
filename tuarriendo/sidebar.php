        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu"><!-- sidebar menu -->
            <div class="menu_section">
                <ul class="nav side-menu">
                    <?php 
                        $id=$_SESSION['user_id'];
                        $query=mysqli_query($con,"select  nombre, link , icono
                                                    from menus
                                                    where m_ncorr in (select menu 
                                                                        from  perfiles_tienen_menus
                                                                        where perfil in (SELECT perfil 
                                                                                        from user 
                                                                                        where id=$id)
                                                                        )
                                                        and estado = '1'
                                                    order by orden");
                        while ($row=mysqli_fetch_array($query)) {
                    ?>    
                    <li >
                        <a href="<?php echo $row['link'] ?>"><i class="<?php echo $row['icono'] ?>"></i> <?php echo ($row['nombre']) ?></a>
                    </li>
                    <?php 
                        }
                    ?>
                </ul>
            </div>
        </div><!-- /sidebar menu -->
    </div>
</div> 
     
    <div class="top_nav"><!-- top navigation -->
        <div class="nav_menu">
            <nav>
                <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li class="">
                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="images/profiles/<?php echo $profile_pic;?>" alt=""><?php echo $name;?>
                            <span class=" fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <li><a href="dashboard.php"><i class="fa fa-user"></i> Mi cuenta</a></li>
                            <li><a href="action/logout.php"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div><!-- /top navigation -->    