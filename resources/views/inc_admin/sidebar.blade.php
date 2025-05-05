<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="{{asset('admin/img/profile_small.jpg')}}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                            </span> <span class="text-muted text-xs block">{{ Auth::user()->roles?->pluck('name')->join(', ') }} <b
                                    class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="/admin/profile">Hồ sơ</a></li>
                        <li class="divider"></li>
                        <li><a href="javscript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
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
                    <i class="fa fa-newspaper-o"></i> <span class="nav-label">Bài viết</span>
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
                    <i class="fa fa-stethoscope"></i> <span class="nav-label">Chuyên khoa</span>
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
            <li class="{{ (request()->is('admin/doctor*') || request()->is('admin/appointment*')) ? 'active' : '' }}">
                <a href="{{ url('admin/doctor') }}">
                    <i class="fa fa-user-md"></i> <span class="nav-label">Bác sĩ</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->is('admin/doctor') ? 'active' : '' }}">
                        <a href="{{ url('admin/doctor') }}">Danh sách bác sĩ</a>
                    </li>
                    <li class="{{ request()->is('admin/doctor/add') ? 'active' : '' }}">
                        <a href="{{ url('admin/doctor/add') }}">Thêm bác sĩ</a>
                    </li>
                    <li class="{{ request()->is('admin/appointment') ? 'active' : '' }}">
                        <a href="{{ url('admin/appointment') }}">Lịch khám</a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->is('admin/site') ? 'active' : '' }}">
                <a href="{{ url('admin/site') }}">
                    <i class="fa fa-sitemap"></i> <span class="nav-label">Site</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->is('admin/site') ? 'active' : '' }}">
                        <a href="{{ url('admin/site') }}">Thiết lập site</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>