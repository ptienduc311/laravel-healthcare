<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="{{asset('admin/img/profile_small.jpg')}}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                            </span> <span class="text-white text-xs block">{{ Auth::user()->roles?->pluck('name')->join(', ') }} <b
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

            @canany(['post_category.index', 'post_category.add', 'post_category.edit', 'post_category.destroy'])
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
            @endcanany

            @canany(['post.index', 'post.add', 'post.edit', 'post.destroy'])
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
            @endcanany

            @canany(['medical-specialty.index', 'medical-specialty.add', 'medical-specialty.edit', 'medical-specialty.destroy', 'medical-specialty.info-page'])
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
            @endcanany

            @canany(['doctor.index', 'doctor.add', 'doctor.edit', 'doctor.destroy'])
            <li class="{{ request()->is('admin/doctor*') ? 'active' : '' }}">
                <a href="{{ url('admin/doctor') }}">
                    <i class="fa fa-user-md"></i> <span class="nav-label">Bác sĩ</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->is('admin/doctor/info-doctor*') ? 'active' : '' }}">
                        <a href="{{ url('admin/doctor/info-doctor') }}">Thông tin bác sĩ</a>
                    </li>
                    <li class="{{ request()->is('admin/doctor') ? 'active' : '' }}">
                        <a href="{{ url('admin/doctor') }}">Danh sách bác sĩ</a>
                    </li>
                    <li class="{{ request()->is('admin/doctor/add') ? 'active' : '' }}">
                        <a href="{{ url('admin/doctor/add') }}">Thêm bác sĩ</a>
                    </li>
                </ul>
            </li>
            @endcanany

            @canany(['appointment.index', 'appointment.add', 'appointment.edit', 'appointment.destroy'])
            <li class="{{ request()->is('admin/appointment*') ? 'active' : '' }}">
                <a href="{{ url('admin/appointment') }}">
                    <i class="fa fa-user-md"></i> <span class="nav-label">Lịch khám</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->is('admin/appointment') ? 'active' : '' }}">
                        <a href="{{ url('admin/appointment') }}">Danh sách lịch khám</a>
                    </li>
                    <li class="{{ request()->is('admin/appointment/add*') ? 'active' : '' }}">
                        <a href="{{ url('admin/appointment/add') }}">Thêm lịch khám</a>
                    </li>
                </ul>
            </li>
            @endcanany

            @canany(['book.index', 'book.show'])
            <li class="{{ request()->is('admin/book*') ? 'active' : '' }}">
                <a href="{{ url('admin/book') }}">
                    <i class="fa fa-calendar"></i> <span class="nav-label">Lịch hẹn</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->is('admin/book') ? 'active' : '' }}">
                        <a href="{{ url('admin/book') }}">Danh sách lịch hẹn</a>
                    </li>
                    {{-- <li class="{{ request()->is('admin/book/add') ? 'active' : '' }}">
                        <a href="{{ url('admin/book/add') }}">Thêm lịch hẹn</a>
                    </li> --}}
                </ul>
            </li>
            @endcanany

            @canany(['permission.index', 'permission.add', 'permission.edit', 'permission.destroy'])
            <li class="{{ request()->is('admin/permission*') ? 'active' : '' }}">
                <a href="{{ url('admin/permission') }}">
                    <i class="fa fa-sitemap"></i> <span class="nav-label">Phân quyền</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    {{-- <li class="{{ request()->is('admin/permission') ? 'active' : '' }}">
                        <a href="{{ url('admin/permission') }}">Danh sách quyền</a>
                    </li> --}}
                    <li class="{{ request()->is('admin/permission/add') ? 'active' : '' }}">
                        <a href="{{ url('admin/permission/add') }}">Thêm quyền</a>
                    </li>
                </ul>
            </li>
            @endcanany

            @canany(['role.index', 'role.add', 'role.edit', 'role.destroy'])
            <li class="{{ request()->is('admin/role') ? 'active' : '' }}">
                <a href="{{ url('admin/role') }}">
                    <i class="fa fa-sitemap"></i> <span class="nav-label">Vai trò</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->is('admin/role') ? 'active' : '' }}">
                        <a href="{{ url('admin/role') }}">Danh sách vai trò</a>
                    </li>
                    <li class="{{ request()->is('admin/role/add') ? 'active' : '' }}">
                        <a href="{{ url('admin/role/add') }}">Thêm vai trò</a>
                    </li>
                </ul>
            </li>
            @endcanany

            @canany(['user.index', 'user.add', 'user.edit', 'user.destroy'])
            <li class="{{ request()->is('admin/user') ? 'active' : '' }}">
                <a href="{{ url('admin/user') }}">
                    <i class="fa fa-users"></i> <span class="nav-label">Người dùng</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->is('admin/user') ? 'active' : '' }}">
                        <a href="{{ url('admin/user') }}">Danh sách người dùng</a>
                    </li>
                    {{-- <li class="{{ request()->is('admin/user/add') ? 'active' : '' }}">
                        <a href="{{ url('admin/user/add') }}">Thêm người dùng</a>
                    </li> --}}
                </ul>
            </li>
            @endcanany

            @canany(['site.edit'])
            <li class="{{ request()->is('admin/site') ? 'active' : '' }}">
                <a href="{{ url('admin/site') }}">
                    <i class="fa fa-cubes"></i> <span class="nav-label">Site</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->is('admin/site') ? 'active' : '' }}">
                        <a href="{{ url('admin/site') }}">Thiết lập site</a>
                    </li>
                </ul>
            </li>
            @endcanany

        </ul>
    </div>
</nav>