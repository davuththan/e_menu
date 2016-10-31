<header class="main-header">
  <!-- Logo -->
  <a href="javascript:void(0);" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img style="padding-top:5px;" width="60px" class="img-responsive" src="{{url('images/logo.png')}}"></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><center><img style="padding-top:5px;" width="90px" class="img-responsive" src="{{url('images/logo.png')}}"></center></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img width="20px" class="img-circle" src="{{url('images/upload/user')}}/{{Auth::user()->photo}}" alt="User Image">
            <span class="hidden-xs">{{Auth::user()->username}}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img class="img-circle" src="{{url('images/upload/user')}}/{{Auth::user()->photo}}" alt="User Image">
              <p>
                User : {{Auth::user()->username}}
                <small>Member since : {{Auth::user()->created_at}}</small>
              </p>
            </li>
            
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{url('images/upload/user')}}/{{Auth::user()->id}}" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="{{ url('/auth/logout') }}" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
        
      </ul>
    </div>
  </nav>
</header>

<?php
  //}
?>