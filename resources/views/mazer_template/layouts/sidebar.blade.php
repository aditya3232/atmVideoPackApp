@php
    use Illuminate\Support\Facades\Request;
    use Illuminate\Support\Facades\URL;

@endphp

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">

                    <h1 class="text-uppercase text-briview-login align-items-center justify-content-center">
                        <img src="/assets/images/logo/dm_logo.png" class="mr-4" alt="polresta-tidore-company" style="max-width: 90%; height: 100%;"><br>
                        {{-- <div class="d-flex flex-column align-items-start" style="font-size: 14px; "> --}}
                        {{-- <div class="" style="font-size: 20px; ">
                            <u>Gatewatch App</u>
                        </div> --}}
                    </h1>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                {{-- models harus ada walaupun dummy --}}
                @can('sidebarParentDashboard', App\Models\Sidebar::class)
                    <li class="{{ (request()->is('admin')) ? 'sidebar-item active' : 'sidebar-item' }}">
                        <a href="{{ route('admin.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @endcan

                @can('sidebarParentLogAcceptReject', App\Models\Sidebar::class)
                    <li
                        class="{{ (request()->is('admin/log/accepted')) || (request()->is('admin/log/rejected')) ? 'sidebar-item active' : 'sidebar-item' }}">
                        <a href="{{ route('admin.log.indexaccepted') }}" class='sidebar-link'>
                            <i class="bi bi-file-earmark-ruled-fill"></i>
                            <span>Log Cards</span>
                        </a>
                    </li>
                @endcan

                @can('sidebarParentSettingDoorLock', App\Models\Sidebar::class)
                    <li class="{{ (request()->is('admin/settinguser')) || (request()->is('admin/mcu')) || (request()->is('admin/card')) ? 'sidebar-item active' : 'sidebar-item' }}
                        has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-gear-fill"></i>
                            <span>Setting Door Lock</span>
                        </a>
                        <ul
                            class="{{ (request()->is('admin/settinguser')) || (request()->is('admin/mcu')) || (request()->is('admin/card')) ? 'submenu active' : 'submenu' }}">
                            <li class="submenu-item {{ (request()->is('admin/settinguser')) ? 'active' : '' }}">
                                <a href="{{ route('admin.settinguser.index') }}"><i class="bi bi-gear-fill"></i> Setting User</a>
                            </li>
                            <li class="submenu-item {{ (request()->is('admin/card')) ? 'active' : '' }}">
                                <a href="{{ route('admin.card.index') }}"><i class="bi bi-gear-fill"></i> Card</a>
                            </li>
                            <li class="submenu-item {{ (request()->is('admin/mcu')) ? 'active' : '' }}">
                                <a href="{{ route('admin.mcu.index') }}"><i class="bi bi-gear-fill"></i> Door Access</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('sidebarParentMasterData', App\Models\Sidebar::class)
                    <li class="{{ (request()->is('admin/usermcu')) || (request()->is('admin/office')) ? 'sidebar-item active' : 'sidebar-item' }}
                    has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-stack"></i>
                            <span>Master Data</span>
                        </a>
                        <ul
                            class="{{ (request()->is('admin/usermcu')) || (request()->is('admin/office')) ? 'submenu active' : 'submenu' }}">
                            <li class="submenu-item {{ (request()->is('admin/office')) ? 'active' : '' }}">
                                <a href="{{ route('admin.office.index') }}"><i class=" bi bi-stack"></i> Data Kantor</a>
                            </li>
                            <li class="submenu-item {{ (request()->is('admin/usermcu')) ? 'active' : '' }}">
                                <a href="{{ route('admin.usermcu.index') }}"><i class="bi bi-stack"></i> Data Users Door Access</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('sidebarParentSettingAdmin', App\Models\Sidebar::class)
                    <li class="{{ (request()->is('admin/users')) || (request()->is('admin/roles')) || (request()->is('admin/permissions')) || (request()->is('admin/telescope')) ? 'sidebar-item active' : 'sidebar-item' }}
                    has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Settings Admin</span>
                        </a>
                        <ul
                            class="{{ (request()->is('admin/users')) || (request()->is('admin/roles')) || (request()->is('admin/permissions')) || (request()->is('admin/telescope')) ? 'submenu active' : 'submenu' }}">
                            <li class="{{ (request()->is('admin/users')) ? 'submenu-item active' : 'submenu-item' }}">
                                <a href="{{ route('admin.users.index') }}"><i class="bi bi-people-fill"></i> Users</a>
                            </li>
                            <li class="{{ (request()->is('admin/roles')) ? 'submenu-item active' : 'submenu-item' }}">
                                <a href="{{ route('admin.roles.index') }}"><i class="bi bi-person-check-fill"></i> Roles</a>
                            </li>
                            @can('sidebarChildSettingAdminPermissions', App\Models\Sidebar::class)
                                <li class="{{ (request()->is('admin/permissions')) ? 'submenu-item active' : 'submenu-item' }}">
                                    <a href="{{ route('admin.permissions.index') }}"><i class="bi bi-person-lines-fill"></i> Permissions</a>
                                </li>
                            @endcan
                            <li class="{{ (request()->is('admin/telescope')) ? 'submenu-item active' : 'submenu-item' }}">
                                <a href="{{ route('telescope') }}" target="_blank">
                                    <i class="bi bi-file-earmark-ruled-fill"></i>
                                    <span>Logs</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('sidebarParentHelps', App\Models\Sidebar::class)
                    <li class="sidebar-item  has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-question-circle-fill"></i>
                            <span>Helps</span>
                        </a>
                        <ul class="submenu ">
                            <li class="submenu-item ">
                                <a href=""><i class="bi bi-question-circle-fill"></i> Helper 1</a>
                            </li>
                            <li class="submenu-item ">
                                <a href=""><i class="bi bi-question-circle-fill"></i> Helper 2</a>
                            </li>
                        </ul>
                    </li>
                @endcan



            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
