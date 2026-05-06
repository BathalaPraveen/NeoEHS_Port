<header id="header" class="header topbar-fixed d-flex align-items-center">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="{{ admin_url('home') }}" class="logo d-flex align-items-left ">

            <img src="{{ url('public/assets/theme/img/logo.png') }}" alt="">
        </a>
        <div class="toggle-icon ms-2 me-2" role="button" aria-label="Toggle sidebar">
            <i class="bx bx-first-page"></i>
        </div>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ admin_url('home') }}"
                        class="@if (View::yieldContent('menu') == 'home') active @endif">Home<br></a>
                </li>
                <li><a href="{{ admin_url('dashboard') }}"
                        class="@if (View::yieldContent('menu') == 'dashboard') active @endif">Dashboard</a></li>
                <li><a href="{{ admin_url('announcement') }}"
                        class="@if (View::yieldContent('menu') == 'announcement') active @endif">Announcement</a></li>
                <li><a href="{{ admin_url('hsebulletin') }}" class="@if (View::yieldContent('menu') == 'hsebulletin') active @endif">HSE
                        Bulletin</a></li>
                {{-- <li class="dropdown"><a href="#"
                            class="@if (View::yieldContent('menu') == 'userguide') active @endif"><span>User Guide</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ admin_url('home') }}" download>uauc_guide.pdf</a></li>
                            <li><a href="{{ admin_url('home') }}" download>ptw_guide.pdf</a></li>
                            <li><a href="{{ admin_url('home') }}" download>hiradc_guide.pdf</a></li>
                        </ul>
                    </li> --}}

                @if (CheckUserRole(ROLE_SUPERADMIN) ||
                        CheckUserRole(ROLE_ADMIN) ||
                        CheckUserRole(ROLE_IT_ADMIN) ||
                        CheckUserRole(ROLE_HSEUSER))
                    <li class="dropdown"><a href="#"
                            class="@if (View::yieldContent('menu') == 'settings') active @endif"><span>Settings</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ admin_url('settings/slider') }}">Slider</a></li>
                            <li><a href="{{ admin_url('settings/announcement/list') }}">Announcement</a></li>
                            @if (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_ADMIN) || CheckUserRole(ROLE_IT_ADMIN))
                                <li class="dropdown"><a href="#"
                                        class="@if (View::yieldContent('menu') == 'userguide') active @endif"><span>Administration</span>
                                        <i class="bi bi-chevron-right toggle-dropdown"></i></a>
                                    <ul>
                                        <li class="dropdown"><a href="#"><span>Location Master</span><i
                                                    class="bi bi-chevron-right toggle-dropdown"></i></a>
                                            <ul>
                                                <li><a href="{{ admin_url('location/list') }}">Location
                                                        Management</a>
                                                </li>
                                                <li><a href="{{ admin_url('specificlocation/list') }}">Specific
                                                        Location
                                                        Master</a></li>
                                            </ul>
                                        </li>

                                        <li class="dropdown"><a href="#"><span>Company Master</span><i
                                                    class="bi bi-chevron-right toggle-dropdown"></i></a>
                                            <ul>
                                                <li><a href="{{ admin_url('company/list') }}">Company Master</a>
                                                </li>
                                                <li><a href="{{ admin_url('division/list') }}">Division Master</a>
                                                </li>
                                                <li><a href="{{ admin_url('department/list') }}">Department
                                                        Master</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="dropdown"><a href="{{ admin_url('designation/list') }}">Designation
                                                Master</a>
                                        </li>

                                        <li class="dropdown"><a href="#"><span>Employee Master</span><i
                                                    class="bi bi-chevron-right toggle-dropdown"></i></a>
                                            <ul>
                                                <li><a href="{{ admin_url('employee/list') }}">List Employee</a>
                                                </li>
                                                <li><a href="{{ admin_url('employee/add') }}">Add Employee</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="dropdown"><a href="#"><span>Contractor Master</span><i
                                                    class="bi bi-chevron-right toggle-dropdown"></i></a>
                                            <ul>
                                                <li><a href="{{ admin_url('contractor/company/list') }}">Contractor
                                                        Company</a></li>
                                                <li><a href="{{ admin_url('contractor/list') }}">List
                                                        Contractor</a>
                                                </li>
                                                <li><a href="{{ admin_url('contractor/add') }}">Add Contractor</a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li class="dropdown"><a href="#"><span>User Master</span><i
                                                    class="bi bi-chevron-right toggle-dropdown"></i></a>
                                            <ul>
                                                <li><a href="{{ admin_url('user/role/list') }}">User Role</a></li>
                                                <li><a href="{{ admin_url('user/permission/list') }}">User
                                                        Permission</a>
                                                </li>
                                                <li><a href="{{ admin_url('userlog/list') }}">User Log</a></li>
                                                <li><a href="{{ admin_url('uploadlog/list') }}">Upload Log</a>
                                                </li>
                                                @if (CheckUserRole(ROLE_SUPERADMIN))
                                                    <li><a href="{{ admin_url('employee/change_details') }}">Change
                                                            Employee Details</a></li>
                                                @endif
                                            </ul>
                                        </li>

                                        <li class="dropdown"><a href="{{ admin_url('work_type/list') }}">Work
                                                Type
                                                Master</a>
                                        </li>
                                        <li class="dropdown"><a href="{{ admin_url('activity_type/list') }}">Activity
                                                type Master</a>
                                        </li>

                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <div class="top-menu ms-auto">
            <ul class="navbar-nav align-items-center">

                <li class="nav-item dropdown dropdown-large">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if ($unreadCount > 0)
                            <span class="alert-count">{{ $unreadCount }}</span>
                        @endif
                        <i class='bx bx-bell'></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="javascript:;">
                            <div class="msg-header">
                                <p class="msg-header-title">Notifications</p>
                                @if ($unreadCount > 0)
                                    <a class="msg-header-clear ms-auto" href="{{ admin_url('notification/readall') }}">
                                        <p>Marks all as read</p>
                                    </a>
                                @endif
                            </div>
                        </a>
                        <div class="header-notifications-list">
                            @if (count($notification_list) > 0)
                                @foreach ($notification_list as $notification)
                                    <a class="dropdown-item"
                                        href="{{ admin_url('notification/view/' . encryptId($notification['id'])) }}"
                                        @if ($notification['read_status'] == 0) style="background-color: #ccc" @endif>
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-primary text-primary">
                                                <img class="w-100 p-2" src="{{ $notification['icon'] }}"
                                                    alt="">
                                            </div>
                                            <div class="flex-grow-1" style="text-wrap: wrap;">
                                                <p class="msg-info ">{{ $notification['title'] }}
                                                    <span class="msg-time float-end">{{ $notification['time'] }}</span>
                                                </p>
                                                <p class="msg-info">{{ $notification['message'] }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="mt-5" style="text-align: center">
                                    <h6> We couldn't fint any notification</h6>
                                </div>

                            @endif

                        </div>
                        @if (count($notification_list) > 0)
                            <a href="{{ admin_url('notification/list') }}">
                                <div class="text-center msg-footer">View All Notifications</div>
                            </a>
                        @endif
                    </div>
                </li>

            </ul>
        </div>
        <div class="user-box position-relative">

            <a id="userDropdownBtn" class="d-flex align-items-center nav-link ms-2" href="javascript:void(0);">

                <img src="{{ url(profileImage(Auth::id())) }}" class="user-img" alt="user avatar"
                    style="width: 30px;">

                <div class="user-info ps-3">
                    <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                    <p class="designattion mb-0">
                        {{ Auth::user()?->user_designation_name }}
                    </p>
                </div>
            </a>

            <ul id="userDropdownMenu" class="dropdown-menu dropdown-menu-end">

                <li>
                    <a class="dropdown-item" href="{{ admin_url('profile') }}">
                        <i class="bx bx-user"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <li>
                    <div class="dropdown-divider mb-0"></div>
                </li>

                <li>
                    <a class="dropdown-item" href=""
                        onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">

                        <i class='bx bx-log-out-circle'></i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ admin_url('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>
    </div>
</header>
