<nav
    class="layout-navbar container-xxl"
    id="layout-navbar"
>
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center " id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Notification -->
            @if(auth()->user()->userRole->role == 'investigator')
                <li class="nav-item" style="margin-right:20px; font-size: 20px;">
                    <a class="nav-link" href="{{ route('investigator.notifications.index') }}">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-primary" rel='{{auth()->user()->userRole->role}}' style="font-size: 12px;">{{ getNotificationsCount() }}</span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->userRole->role == 'company-admin')
                <li class="nav-item" style="margin-right:20px; font-size: 20px;">
                    <a class="nav-link" href="/company-admin/notification">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-primary" rel='{{auth()->user()->userRole->role}}' style="font-size: 12px;">{{ getNotificationsCount() }}</span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->userRole->role == 'hiring-manager')
                <li class="nav-item" style="margin-right:20px; font-size: 20px;">
                    <a class="nav-link" href="/hm/notification">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-primary" rel='{{auth()->user()->userRole->role}}' style="font-size: 12px;">{{ getNotificationsCount() }}</span>
                    </a>
                </li>
            @endif

            <!-- User -->
            <li class="nav-item" style="margin-right:20px">
                <a class="nav-link" href="javascript:void(0);">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <span
                                    class="fw-semibold d-block">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
                            <small class="text-muted">
                                @switch(auth()->user()->userRole)
                                    @case(auth()->user()->userRole->role == 'admin')
                                        <span>Admin</span>
                                        @break
                                    @case(auth()->user()->userRole->role == 'company-admin')
                                        <span>Company Admin</span>
                                        @break
                                    @case(auth()->user()->userRole->role == 'investigator')
                                        <span>Investigator</span>
                                        @break
                                    @case(auth()->user()->userRole->role == 'hiring-manager')
                                        <span>Hiring Manager</span>
                                        @break
                                    @default
                                        <span>Wrong Role!</span>
                                @endswitch
                            </small>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="/html/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle"/>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        @switch(auth()->user()->userRole)
                            @case(auth()->user()->userRole->role == 'admin')
                                <a class="dropdown-item" href="{{ route('admin.my-profile') }}">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                                @break
                            @case(auth()->user()->userRole->role == 'company-admin')
                                <a class="dropdown-item" href="{{ route('company-admin.my-profile') }}">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                                @break
                            @case(auth()->user()->userRole->role == 'investigator')
                                <a class="dropdown-item" href="{{ route('investigator.my-profile') }}">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                                @break
                            @case(auth()->user()->userRole->role == 'hiring-manager')
                                <a class="dropdown-item {{ request()->routeIs('hm.my-profile') ? 'active' : '' }}"
                                   href="{{ route('hm.my-profile') }}">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                                @break
                            @default
                                <span>Wrong Role!</span>
                        @endswitch
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
