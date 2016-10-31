<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{url('lib/AdminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            
            @foreach($menuList as $index => $mainMenu)
            	@if ($index == 0)
            		@foreach($mainMenu as $menu)
		            	
		            	<li class="treeview">
				              <a href="#">
				                <i class="fa {{$menu->icon}}"></i> 
				                <span>{{$menu->menu_name}}</span> 
				                <i class="fa fa-angle-left pull-right"></i>
				              </a>
				              <ul class="treeview-menu">
				              @foreach($menuList as $index => $mainMenu)
					              @foreach($mainMenu as $subIndex => $subMenu)
						              	@if ($subMenu->parent_id == $menu->id)
						              		<li><a href="{{$subMenu->url}}"><i class="fa fa-circle-o"></i> {{$subMenu->menu_name}} </a></li>
						              	@endif
					              @endforeach
				              @endforeach
				              </ul>
				       </li> 
				       
            		@endforeach
            	@endif
            @endforeach
             
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>