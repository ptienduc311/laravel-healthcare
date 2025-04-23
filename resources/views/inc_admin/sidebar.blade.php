<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="{{asset('admin/img/profile_small.jpg')}}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David
                                    Williams</strong>
                            </span> <span class="text-muted text-xs block">Art Director <b
                                    class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    Admin+
                </div>
            </li>
            <li class="{{ request()->is('admin/post/cat*') ? 'active' : '' }}">
                <a href="{{ url('admin/post/cat') }}">
                    <i class="fa fa-th-large"></i> <span class="nav-label">Danh mục bài viết</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->is('admin/post/cat') ? 'active' : '' }}">
                        <a href="{{ url('admin/post/cat') }}">Danh sách danh mục</a>
                    </li>
                    <li class="{{ request()->is('admin/post/cat/add') ? 'active' : '' }}">
                        <a href="{{ url('admin/post/cat/add') }}">Thêm danh mục</a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->is('admin/post*') && !request()->is('admin/post/cat*') ? 'active' : '' }}">
                <a href="{{ url('admin/post') }}">
                    <i class="fa fa-th-large"></i> <span class="nav-label">Bài viết</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->is('admin/post') ? 'active' : '' }}">
                        <a href="{{ url('admin/post') }}">Danh sách bài viết</a>
                    </li>
                    <li class="{{ request()->is('admin/post/add') ? 'active' : '' }}">
                        <a href="{{ url('admin/post/add') }}">Thêm bài viết</a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->is('admin/medical-specialty*') ? 'active' : '' }}">
                <a href="{{ url('admin/medical-specialty') }}">
                    <i class="fa fa-th-large"></i> <span class="nav-label">Chuyên khoa</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->is('admin/medical-specialty') ? 'active' : '' }}">
                        <a href="{{ url('admin/medical-specialty') }}">Danh sách chuyên khoa</a>
                    </li>
                    <li class="{{ request()->is('admin/medical-specialty/add') ? 'active' : '' }}">
                        <a href="{{ url('admin/medical-specialty/add') }}">Thêm chuyên khoa</a>
                    </li>
                    <li class="{{ request()->is('admin/medical-specialty/info-page') ? 'active' : '' }}">
                        <a href="{{ url('admin/medical-specialty/info-page') }}">Trang chuyên khoa</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>