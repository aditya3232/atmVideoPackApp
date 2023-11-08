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
                    </h1>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                {{-- 

                - sidebarParentDashboard itu dari SidebarPolicy.php
                - isinya adalah function sidebarParentDashboard yang mengembalikan => return $user->role->hasPermission('sidebar parent dashboard');

                --}}
                @can('sidebarParentDashboard', App\Models\Sidebar::class)
                    <li class="{{ (request()->is('admin')) ? 'sidebar-item active' : 'sidebar-item' }}">
                        <a href="{{ route('admin.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @endcan

                @can('sidebarParentHumanDetection', App\Models\Sidebar::class)
                    <li class="{{ (request()->is('admin/humandetection')) ? 'sidebar-item active' : 'sidebar-item' }}">
                        <a href="{{ route('admin.humandetection.index') }}" class='sidebar-link'>
                            @include('mazer_template.layouts.icons.human-detection')
                            <span>Human Detection</span>
                        </a>
                    </li>
                @endcan

                @can('sidebarParentVandalDetection', App\Models\Sidebar::class)
                    <li class="{{ (request()->is('admin/vandaldetection')) ? 'sidebar-item active' : 'sidebar-item' }}">
                        <a href="{{ route('admin.vandaldetection.index') }}" class='sidebar-link'>
                            @include('mazer_template.layouts.icons.vandal-detection')
                            <span>Vandal Detection</span>
                        </a>
                    </li>
                @endcan

                @can('sidebarParentStreamingCctv', App\Models\Sidebar::class)
                    <li
                        class="{{ (request()->is('admin/streamingcctv')) || (request()->is('admin/streamingcctv')) ? 'sidebar-item active' : 'sidebar-item' }}">
                        <a href="{{ route('admin.streamingcctv.index') }}" class='sidebar-link'>
                            @include('mazer_template.layouts.icons.stream')
                            <span>Streaming Cctv</span>
                        </a>
                    </li>
                @endcan

                @can('sidebarParentDownloadPlayback', App\Models\Sidebar::class)
                    <li
                        class="{{ (request()->is('admin/downloadplayback')) || (request()->is('admin/downloadplayback')) ? 'sidebar-item active' : 'sidebar-item' }}">
                        <a href="{{ route('admin.downloadplayback.index') }}" class='sidebar-link'>
                            @include('mazer_template.layouts.icons.playback')
                            <span>Download Playback</span>
                        </a>
                    </li>
                @endcan

                @can('sidebarParentMasterDevice', App\Models\Sidebar::class)
                    <li
                        class="{{ (request()->is('admin/device')) || (request()->is('admin/device')) ? 'sidebar-item active' : 'sidebar-item' }}">
                        <a href="{{ route('admin.device.index') }}" class='sidebar-link'>
                            @include('mazer_template.layouts.icons.device')
                            <span>Master Device</span>
                        </a>
                    </li>
                @endcan

                @can('sidebarParentMasterLocation', App\Models\Sidebar::class)
                    <li class="{{ (request()->is('admin/location')) || (request()->is('admin/regionaloffice')) || (request()->is('admin/kcsupervisi')) || (request()->is('admin/branch')) ? 'sidebar-item active' : 'sidebar-item' }}
                    has-sub">
                        <a href="#" class='sidebar-link'>
                            @include('mazer_template.layouts.icons.location')
                            <span>Master Location</span>
                        </a>
                        <ul
                            class="{{ (request()->is('admin/location')) || (request()->is('admin/regionaloffice')) || (request()->is('admin/kcsupervisi')) || (request()->is('admin/branch'))  ? 'submenu active' : 'submenu' }}">
                            <li class="submenu-item {{ (request()->is('admin/location')) ? 'active' : '' }}">
                                <a href="{{ route('admin.location.index') }}">@include('mazer_template.layouts.icons.location') Location</a>
                            </li>
                            <li class="submenu-item {{ (request()->is('admin/regionaloffice')) ? 'active' : '' }}">
                                <a href="{{ route('admin.regionaloffice.index') }}">@include('mazer_template.layouts.icons.location') Regional Office</a>
                            </li>
                            <li class="submenu-item {{ (request()->is('admin/kcsupervisi')) ? 'active' : '' }}">
                                <a href="{{ route('admin.kcsupervisi.index') }}">@include('mazer_template.layouts.icons.location') Kc Supervisi</a>
                            </li>
                            <li class="submenu-item {{ (request()->is('admin/branch')) ? 'active' : '' }}">
                                <a href="{{ route('admin.branch.index') }}">@include('mazer_template.layouts.icons.location') Branch</a>
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
                            @can('sidebarChildSettingAdminPermission', App\Models\Sidebar::class)
                                <li class="{{ (request()->is('admin/permissions')) ? 'submenu-item active' : 'submenu-item' }}">
                                    <a href="{{ route('admin.permissions.index') }}"><i class="bi bi-person-lines-fill"></i> Permissions</a>
                                </li>
                            @endcan
                            <li class="submenu-item">
                                <a href="{{ route('telescope') }}" target="_blank">
                                    <i class="bi bi-file-earmark-ruled-fill"></i>
                                    <span>Logs</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('sidebarParentHelp', App\Models\Sidebar::class)
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
