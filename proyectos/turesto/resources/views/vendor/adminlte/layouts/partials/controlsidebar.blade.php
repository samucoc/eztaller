<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-activity-tab" data-toggle="tab"><i class="fa fa-check"></i></a></li>
        <li><a href="#control-sidebar-birthday-tab" data-toggle="tab"><i class="fa fa-birthday-cake"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-activity-tab">
            <h3 class="control-sidebar-heading">{{ trans('adminlte_lang::message.recentactivity') }}</h3>
            <ul class='control-sidebar-menu'>
                <li>

                </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">{{ trans('adminlte_lang::message.progress') }}</h3>
            <ul class='control-sidebar-menu'>
                <li>
                    <a href='javascript::;'>
                        <h4 class="control-sidebar-subheading">
                            {{ trans('adminlte_lang::message.customtemplate') }}
                            <span class="label label-danger pull-right">70%</span>
                        </h4>
                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
            </ul><!-- /.control-sidebar-menu -->

        </div><!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">{{ trans('adminlte_lang::message.statstab') }}</div><!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-birthday-tab">
                <h3 class="control-sidebar-heading">{{ trans('adminlte_lang::message.Cumpleanoshoy') }}</h3>
                <ul class='control-sidebar-menu' id="lista-cumpleanos-hoy">
                <li>
                    <a href='javascript::;'>
                        <i class="menu-icon fa fa-ban bg-red"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">{{ trans('adminlte_lang::message.sincumpleanos') }}</h4>
                            
                        </div>
                    </a>
                </li>
            </ul><!-- /.control-sidebar-menu -->



                <h3 class="control-sidebar-heading">{{ trans('adminlte_lang::message.Cumpleanosmes') }}</h3>
                <div>
                    <ul class='control-sidebar-menu' id="lista-cumpleanos">
                    </ul><!-- /.control-sidebar-menu --> 
                    
                </div>
           
               
         
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar

<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>

@section('mi-script')
<script type="text/javascript">

   
</script>
@endsection