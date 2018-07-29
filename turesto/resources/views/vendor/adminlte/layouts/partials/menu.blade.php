
@inject('menues','App\Http\Controllers\MenuController')
@inject('menues_hijos','App\Http\Controllers\MenuesHijosController')
@inject('menues_hijos_1','App\Http\Controllers\MenuesHijosController')
@php  $url = Request::path();@endphp

@foreach ($menues->menu() as $menu)
	@php $link = strtolower($menu->menu_descripcion);
		 $find = strrpos($url, $link);
		 $p = explode('/',$url);
	@endphp
	<li class="treeview @if ($p[0] != $link) no coinside  @else  active @endif ">
	    <a href="#"><i class='fa {{$menu->menu_icon}} aria-hidden="true"'></i> <span>{{ $menu->menu_descripcion }}</span> <i class="fa fa-angle-left pull-right"></i></a>
	    <ul class="treeview-menu">
	    	@foreach ($menues_hijos->submenu() as $submenu)
	        	@if ($submenu->menu_id == $menu->menu_ncorr)
		        	@if (  strpos($submenu->mhijo_descripcion,'>')  )
						<li><a href='{{ url("$submenu->mhijo_link")}}' ><i class="fa fa-angle-left pull-right"></i>{{$submenu->mhijo_descripcion}}</a>
							<ul class="treeview-menu" >
								@foreach ($menues_hijos_1->submenu_1() as $submenu_1)
									@if ($submenu_1->mhijo_sub_menu == $submenu->mhijo_id)
										<li ><a href='{{ url("$submenu_1->mhijo_link")}}' >{{  $submenu_1->mhijo_descripcion  }}</a></li>
									@endif
								@endforeach
							</ul>
			        	</li>
					@else
						<li><a href='{{ url("$submenu->mhijo_link")}}' ></i>{{$submenu->mhijo_descripcion}}</a>
		        	@endif
	        	@endif
	        @endforeach
	    </ul>
	</li>
@endforeach

