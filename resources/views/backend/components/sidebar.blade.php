<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">{{ config('app.name', 'Doctor Website') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">D</a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Workspace</li>
            <li class="nav-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
            </li>

            @hasanyrole('Super Admin|Doctor|Receptionist|Admin')
                <li class="menu-header">Clinic</li>
                <li class="nav-item {{ Request::routeIs('admin.appointments.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.appointments.index') }}" class="nav-link"><i class="fas fa-calendar-check"></i><span>Appointments</span></a>
                </li>
                @hasanyrole('Super Admin|Doctor|Admin')
                <li class="nav-item {{ Request::routeIs('admin.payments.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.payments.index') }}" class="nav-link"><i class="fas fa-wallet"></i><span>Payment Management</span></a>
                </li>
                @endhasanyrole
            @endhasanyrole

            @hasanyrole('Super Admin|Doctor')
                <li class="nav-item {{ Request::routeIs('admin.doctor-profile.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.doctor-profile.edit') }}" class="nav-link"><i class="fas fa-user-md"></i><span>Doctor Profile</span></a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.chambers.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.chambers.index') }}" class="nav-link"><i class="fas fa-hospital"></i><span>Chambers & Schedule</span></a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.prescriptions.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.prescriptions.index') }}" class="nav-link"><i class="fas fa-file-medical"></i><span>Prescriptions</span></a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.medical-documents.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.medical-documents.index') }}" class="nav-link"><i class="fas fa-file-image"></i><span>Patient Reports & Photos</span></a>
                </li>
            @endhasanyrole

            @php
                $managedPages = collect(config('page_content_defaults', []))->pluck('page')->filter()->unique()->values();
                $pageLabels = [
                    'home' => 'Home', 'about' => 'About', 'services' => 'Services',
                    'blog' => 'Blog', 'blog-view' => 'Blog Details', 'testimonials' => 'Testimonials',
                    'faq' => 'FAQ', 'contact' => 'Contact', 'appointment' => 'Appointment',
                    'shared_header' => 'Header', 'shared_footer' => 'Footer',
                ];
            @endphp

            @hasanyrole('Super Admin|Doctor')
                <li class="menu-header">Website Management</li>
                <li class="nav-item dropdown {{ Request::routeIs('admin.pages.*') || Request::routeIs('admin.page-content.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-file-alt"></i><span>Pages & Sections</span></a>
                    <ul class="dropdown-menu">
                        @foreach($managedPages as $managedPage)
                            <li class="{{ request()->route('page') === $managedPage ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.pages.edit', $managedPage) }}">{{ $pageLabels[$managedPage] ?? ucfirst(str_replace(['-', '_'], ' ', $managedPage)) }}</a>
                            </li>
                        @endforeach
                        <li class="{{ Request::routeIs('admin.page-content.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.page-content.index') }}">All Content Fields</a>
                        </li>
                    </ul>
                </li>
            @endhasanyrole

            @hasrole('Super Admin')
                <li class="menu-header">System Settings</li>
                <li class="nav-item {{ Request::routeIs('admin.site-settings.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.site-settings.edit') }}" class="nav-link"><i class="fas fa-sliders-h"></i><span>Website Settings</span></a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.payment-settings.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.payment-settings.edit') }}" class="nav-link"><i class="fas fa-credit-card"></i><span>Payment Settings</span></a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.seo.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.seo.index') }}" class="nav-link"><i class="fas fa-search"></i><span>SEO Management</span></a>
                </li>
            @endhasrole

            @canany(['blog-list', 'blog-create', 'blog-edit', 'blog-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('backend.blogs.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-blog"></i><span>Blog Management</span></a>
                    <ul class="dropdown-menu">
                        @can('blog-create')
                            <li class="{{ Request::routeIs('backend.blogs.create') ? 'active' : '' }}"><a class="nav-link" href="{{ route('backend.blogs.create') }}">Add Blog Post</a></li>
                        @endcan
                        @can('blog-list')
                            <li class="{{ Request::routeIs('backend.blogs.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('backend.blogs.index') }}">All Blog Posts</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany(['user-list', 'user-create', 'role-list', 'role-create'])
                <li class="menu-header">Access Control</li>
                <li class="nav-item dropdown {{ Request::routeIs('users.*') || Request::routeIs('roles.*') || Request::routeIs('manage_permissions') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-users-cog"></i><span>Users & Permissions</span></a>
                    <ul class="dropdown-menu">
                        @can('user-create')
                            <li class="{{ Request::routeIs('users.create') ? 'active' : '' }}"><a class="nav-link" href="{{ route('users.create') }}">Add User</a></li>
                        @endcan
                        @can('user-list')
                            <li class="{{ Request::routeIs('users.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('users.index') }}">User List</a></li>
                        @endcan
                        @can('role-create')
                            <li class="{{ Request::routeIs('roles.create') ? 'active' : '' }}"><a class="nav-link" href="{{ route('roles.create') }}">Add Role</a></li>
                        @endcan
                        @can('role-list')
                            <li class="{{ Request::routeIs('roles.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('roles.index') }}">Role List</a></li>
                        @endcan
                        @hasrole('Super Admin')
                            <li class="{{ Request::routeIs('manage_permissions') ? 'active' : '' }}"><a class="nav-link" href="{{ route('manage_permissions') }}">Role Permissions</a></li>
                        @endhasrole
                    </ul>
                </li>
            @endcanany

            <li class="menu-header">My Account</li>
            <li class="nav-item {{ Request::routeIs('profile.show') ? 'active' : '' }}">
                <a href="{{ route('profile.show') }}" class="nav-link"><i class="far fa-user-circle"></i><span>My Profile</span></a>
            </li>
            <li class="nav-item {{ Request::routeIs('settings.index') ? 'active' : '' }}">
                <a href="{{ route('settings.index') }}" class="nav-link"><i class="fas fa-cog"></i><span>Account Settings</span></a>
            </li>
        </ul>

        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-lg btn-block mb-2">
                <i class="fas fa-globe mr-1"></i> View Website
            </a>
            <a href="{{ route('logout') }}" class="btn btn-primary btn-lg btn-block btn-icon-split"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </aside>
</div>
