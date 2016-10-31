<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
  
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{url('images/upload/user')}}/{{Auth::user()->photo}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- search form -->
     <!--  <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </form> -->

    <?php  $request_uri= $_SERVER['REQUEST_URI'];?>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>

      <?php
        $Group_ID = Auth::user()->group_id;
        $menu = DB::table('group_role')
                    ->join('group_role_detail', 'group_role_detail.group_role_id', '=', 'group_role.id')
                    ->join('menu', 'menu.menu_code', '=', 'group_role_detail.menu_code')
                    ->where('group_role.group_id','=',$Group_ID)
                    //->where('group_role_detail.parent_menu_id', '=', 0)
                    ->where('menu.parent_id', '=', 0)
                    ->orderBy('menu.order_level','ASC')
                    ->select('group_role_detail.*','group_role.id as grouRole_id','menu.icon as menuIcon','menu.default as mdefault','menu.url as menuUrl','menu.menu_name as menuname', 'group_role_detail.menu_code as groupMenuCode','group_role_detail.menu_id as groupMenu_id')
                    ->get();

          //foreach ($menu as $menus)
          foreach ($menu as $key => $value) 
          {
            $menuname = $value->menuname;
            $groupMenu_id = $value->groupMenu_id;
            $grouRole_id = $value->grouRole_id;
            $menuUrl = $value->menuUrl;
            $menuIcon = $value->menuIcon;
        ?>
              <li class="<?php if((strpos($request_uri,"$menuUrl")!==false)){echo 'active';}?> treeview">
                <a href="">
                  <i class="fa fa-wa {{$menuIcon}}"></i>
                  <span>{{$menuname}}</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
        <?php
              // $sub_menu = DB::table('group_role_detail')
              //         ->where('group_role_detail.group_role_id','=',$grouRole_id)
              //         ->where('parent_menu_id','=',$groupMenu_id)
              //         ->join('menu', 'menu.id', '=', 'group_role_detail.menu_id')
              //         ->select('group_role_detail.*','menu.default as sdefault','menu.url as smenu_url','menu.menu_name as smenu_name')
              //         ->get();

              $sub_menu = DB::table('menu')
                            ->where('group_role_detail.group_role_id','=',$grouRole_id)
                            //->where('group_role_detail.parent_menu_id','=',$groupMenu_id)
                            ->where('menu.parent_id','=',$groupMenu_id)
                            ->where('menu.parent_id','>',0)
                            ->join('group_role_detail','group_role_detail.menu_id','=','menu.id')
                            ->orderBy('menu.order_level','ASC')
                            //->join('menu', 'menu.id', '=', 'group_role_detail.menu_id')
                            ->select('menu.*','menu.default as sdefault','menu.url as smenu_url','menu.menu_name as smenu_name')
                            ->get();

              foreach ($sub_menu as $key => $value) {
                // $smenu_url = $value->smenu_url;
                // $smenu_title = $value->smenu_name;
                // $sdefault_id = $value->sdefault;  
        ?>
                <li <?php if((strpos($request_uri,$value->url)!==false)){echo 'class="active"';}?>>
                  <a href="{{url($value->url)}}">
                      <i class="fa fa-circle-o"></i>{{$value->menu_name}}
                  </a>
                </li>
        <?php
              }
              echo"</ul>";
              echo"</li>";  
          }
        ?>
        
        <!-- Label -->
        <!-- <li class="header">ACCOUNTANT</li>
        <li><a href="#"><i class="fa fa-book"></i> <span>Run Night Audit</span></a></li> -->
        <!-- <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
