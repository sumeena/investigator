<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
        <span class="app-brand-logo demo">
        <img src="/html/logo.png" class="dashboard-topbar-img">
        </span>
            <!-- <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span> -->
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin') || request()->is('investigator') || request()->is('company-admin') || request()->is('hm')  ? 'active' : '' }}">
            @if(request()->segment(1)=='admin')
                <a href="{{ route('admin.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            @endif
            @if(auth()->user()->is_investigator_profile_submitted == 1)
                @if(request()->segment(1) == 'investigator')
                    <a href="{{ route('investigator.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                @endif
            @endif

            @if(
    (auth()->user()->CompanyAdminProfile && auth()->user()->CompanyAdminProfile->is_company_profile_submitted)
    || (auth()->user()->companyAdmin && auth()->user()->companyAdmin->company
    && auth()->user()->companyAdmin->company->CompanyAdminProfile
    && auth()->user()->companyAdmin->company->CompanyAdminProfile->is_company_profile_submitted)
)
                @if(request()->segment(1) == 'company-admin')
                    <a href="{{ route('company-admin.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                @endif
            @endif


            @if(request()->segment(1) == 'hm')
                <a href="{{ route('hm.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            @endif
        </li>

        @if(auth()->user()->userRole && auth()->user()->userRole->role == 'admin')
            <li class="menu-item {{ request()->routeIs('admin.company-admins.index') ||  request()->routeIs('admin.company-admins.add') || request()->routeIs('admin.company-admins.edit') || request()->routeIs('admin.company-admins.view') ? 'active' : '' }}">
                <a href="{{ route('admin.company-admins.index') }}" class="menu-link">
                    <i class="bx bx-user me-2"></i>
                    <div data-i18n="Analytics">Company Admin</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.investigators.index') ||  request()->routeIs('admin.investigators.add') || request()->routeIs('admin.investigators.edit') || request()->routeIs('admin.investigators.view') || request()->routeIs('admin.investigators.reset-password') ? 'active' : '' }}">
                <a href="{{ route('admin.investigators.index') }}" class="menu-link">
                    <i class="bx bx-user me-2"></i>
                    <div data-i18n="Analytics">Investigator</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.hiring-managers.index') ||  request()->routeIs('admin.hiring-managers.add') || request()->routeIs('admin.hiring-managers.edit') || request()->routeIs('admin.hiring-managers.view') || request()->routeIs('admin.hiring-managers.reset-password') ? 'active' : '' }}">
                <a href="{{ route('admin.hiring-managers.index') }}" class="menu-link">
                    <i class="bx bx-user me-2"></i>
                    <div data-i18n="Analytics">Hiring Manager</div>
                </a>
            </li>
        @endif

        @if(auth()->user()->userRole && auth()->user()->userRole->role == 'company-admin')

            @if(
    (auth()->user()->CompanyAdminProfile && auth()->user()->CompanyAdminProfile->is_company_profile_submitted)
    || (auth()->user()->companyAdmin && auth()->user()->companyAdmin->company
    && auth()->user()->companyAdmin->company->CompanyAdminProfile
    && auth()->user()->companyAdmin->company->CompanyAdminProfile->is_company_profile_submitted)
)
                <li class="menu-item {{ request()->routeIs('company-admin.find_investigator') ? 'active' : '' }}">
                    <a href="{{ route('company-admin.find_investigator') }}" class="menu-link">
                        <i class="bx bx-user me-2"></i>
                        <div data-i18n="Analytics">Find Investigators</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('company-admin.view') ? 'active' : '' }}">
                    <a href="{{ route('company-admin.view') }}" class="menu-link">
                        <i class="bx bx-building me-2"></i>
                        <div data-i18n="Analytics">View Company profile</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('company-admin.company-users.index') ? 'active' : '' }}">
                    <a href="{{ route('company-admin.company-users.index') }}" class="menu-link">
                        <i class="bx bxs-user me-2"></i>
                        <div data-i18n="Analytics">Company Users</div>
                    </a>
                </li>
            @else
                <li class="menu-item {{ request()->routeIs('company-admin.profile') ? 'active' : '' }}">
                    <a href="{{ route('company-admin.profile') }}" class="menu-link">
                        <i class="bx bx-building me-2"></i>
                        <div data-i18n="Analytics">Company profile</div>
                    </a>
                </li>
            @endif

        @endif

        @if(auth()->user()->userRole && auth()->user()->userRole->role == 'investigator')
            @if(auth()->user()->is_investigator_profile_submitted == 1)
                <li class="menu-item {{ request()->routeIs('investigator.view-profile') ? 'active' : '' }}">
                    <a href="{{ route('investigator.view-profile') }}" class="menu-link">
                        <i class="bx bx-user me-2"></i>
                        <div data-i18n="Analytics">View Profile</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('investigator.company-admins.index') ? 'active' : '' }}">
                    <a href="{{ route('investigator.company-admins.index') }}" class="menu-link">
                        <i class="bx bx-user me-2"></i>
                        <div data-i18n="Analytics">Companies</div>
                    </a>
                </li>
            @else
                <li class="menu-item {{ request()->routeIs('investigator.profile') ? 'active' : '' }}">
                    <a href="{{ route('investigator.profile') }}" class="menu-link">
                        <i class="bx bx-user me-2"></i>
                        <div data-i18n="Analytics">Investigator Profile</div>
                    </a>
                </li>
            @endif


            <li class="menu-item {{ request()->routeIs('calendar') ? 'active' : '' }}">
                <a href="/investigator/calendar" class="menu-link">
                    <i class="bx bx-user me-2"></i>
                    <div data-i18n="Analytics">Calendar</div>
                </a>
            </li>

        @endif

        @if(auth()->user()->userRole && auth()->user()->userRole->role == 'hiring-manager')
            <li class="menu-item {{ request()->routeIs('hm.view') ? 'active' : '' }}">
                <a href="{{ route('hm.view') }}" class="menu-link">
                    <i class="bx bx-building me-2"></i>
                    <div data-i18n="Analytics">View Company profile</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('hm.find_investigator') ? 'active' : '' }}">
                <a href="{{ route('hm.find_investigator') }}" class="menu-link">
                    <i class="bx bx-user me-2"></i>
                    <div data-i18n="Analytics">Find Investigators</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('hm.company-users.index') ? 'active' : '' }}">
                <a href="{{ route('hm.company-users.index') }}" class="menu-link">
                    <i class="bx bx-user me-2"></i>
                    <div data-i18n="Analytics">Company Users</div>
                </a>
            </li>
        @endif

        <li class="menu-item">
            <a class="menu-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                <i class="bx bx-power-off me-2"></i>
                <div data-i18n="Analytics">Logout</div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</aside>
