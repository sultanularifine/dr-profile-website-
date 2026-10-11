<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
        </div>
        <ul class="sidebar-menu">
            {{-- Dashboard --}}
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>

            {{-- Website Analytics --}}
            @can('analytics-index')
                <li class="nav-item {{ Request::routeIs('website.analytics') ? 'active' : '' }}">
                    <a href="{{ route('website.analytics') }}" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <span>Website Analytics</span>
                    </a>
                </li>
            @endcan


            {{-- User Management --}}
            @canany(['user-list', 'user-create', 'user-edit', 'user-delete', 'role-list', 'role-create', 'role-edit',
                'role-delete', 'manage-permissions'])
                <li
                    class="nav-item dropdown 
    {{ Request::routeIs('users.*') || Request::routeIs('roles.*') || Request::routeIs('manage_permissions') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fa-solid fa-user"></i>
                        <span>User Management</span>
                    </a>
                    <ul class="dropdown-menu">

                        {{-- Users Submenu --}}
                        @canany(['user-list', 'user-create'])
                            <li class="dropdown-header">Users</li>
                            @can('user-create')
                                <li class="{{ Request::routeIs('users.create') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('users.create') }}">Add User</a>
                                </li>
                            @endcan
                            <li class="{{ Request::routeIs('users.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('users.index') }}">User List</a>
                            </li>
                        @endcan

                        {{-- Roles Submenu --}}
                        @canany(['role-list', 'role-create'])
                            <li class="dropdown-header">Roles</li>
                            @can('role-create')
                                <li class="{{ Request::routeIs('roles.create') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('roles.create') }}">Add Role</a>
                                </li>
                            @endcan
                            <li class="{{ Request::routeIs('roles.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('roles.index') }}">Role List</a>
                            </li>
                        @endcan

                        {{-- Permissions Submenu --}}
                        @can('manage-permissions')
                            <li class="dropdown-header">Permissions</li>
                            <li class="{{ Request::routeIs('manage_permissions') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('manage_permissions') }}">Role Permissions</a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcan

            {{-- Blogs Menu --}}
            @canany(['blog-list', 'blog-create', 'blog-edit', 'blog-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('backend.blogs.*') ? 'active' : '' }}">

                    <a href="#" class="nav-link has-dropdown">
                        <i class="fa-solid fa-blog"></i>
                        <span>Blogs</span>
                    </a>

                    <ul class="dropdown-menu">

                        @can('blog-create')
                            <li class="{{ Request::routeIs('backend.blogs.create') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('backend.blogs.create') }}">
                                    Add Blog
                                </a>
                            </li>
                        @endcan

                        @can('blog-list')
                            <li class="{{ Request::routeIs('backend.blogs.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('backend.blogs.index') }}">
                                    Blog List
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcanany

            {{-- News / Content Management --}}
            @canany(['news-list', 'news-create', 'news-edit', 'news-delete'])
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-newspaper"></i><span>News
                            Management</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">Add News</a></li>
                        <li><a class="nav-link" href="#">All News</a></li>
                        <li><a class="nav-link" href="#">Pending News</a></li>
                        <li><a class="nav-link" href="#">Draft News</a></li>
                        <li><a class="nav-link" href="#">Breaking News</a></li>
                        <li><a class="nav-link" href="#">Featured / Slider News</a></li>
                    </ul>
                </li>
            @endcan

            {{-- Category Management --}}
            @canany(['category-list', 'category-create', 'category-edit', 'category-delete'])
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-sitemap"></i><span>Category
                            Management</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">Main Categories</a></li>
                        <li><a class="nav-link" href="#">Sub Categories</a></li>
                        <li><a class="nav-link" href="#">Region / District Category</a></li>
                        <li><a class="nav-link" href="#">Menu Management</a></li>
                    </ul>
                </li>
            @endcan

            {{-- Media Manager --}}
            @canany(['media-list', 'media-create', 'media-edit', 'media-delete'])
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-photo-video"></i><span>Media
                            Manager</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">Photo Gallery</a></li>
                        <li><a class="nav-link" href="#">Video Gallery</a></li>
                        <li><a class="nav-link" href="#">Upload Images</a></li>
                        <li><a class="nav-link" href="#">File Manager</a></li>
                    </ul>
                </li>
            @endcan

            {{-- Writer / Reporter --}}
            @canany(['reporter-list', 'reporter-create', 'reporter-edit', 'reporter-delete', 'reporter-assign'])
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-pen-nib"></i><span>Writer /
                            Reporter</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">Add Reporter</a></li>
                        <li><a class="nav-link" href="#">Reporter List</a></li>
                        <li><a class="nav-link" href="#">Assign News</a></li>
                        <li><a class="nav-link" href="#">Reporter Permissions</a></li>
                    </ul>
                </li>
            @endcan

            {{-- Advertisement --}}
            @canany(['ads-list', 'ads-create', 'ads-edit', 'ads-delete'])
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-ad"></i><span>Advertisement</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">Add Advertisement</a></li>
                        <li><a class="nav-link" href="#">Ad Positions</a></li>
                        <li><a class="nav-link" href="#">Ad Schedule</a></li>
                        <li><a class="nav-link" href="#">Ad Reports</a></li>
                    </ul>
                </li>
            @endcan

            {{-- Homepage Settings --}}
            @canany(['homepage-slider', 'homepage-breaking', 'homepage-featured', 'homepage-section-order'])
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-home"></i><span>Homepage
                            Settings</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">Slider Settings</a></li>
                        <li><a class="nav-link" href="#">Breaking News Settings</a></li>
                        <li><a class="nav-link" href="#">Featured Section Control</a></li>
                        <li><a class="nav-link" href="#">Section Order</a></li>
                    </ul>
                </li>
            @endcan

            {{-- Comments & Feedback --}}
            @canany(['comments-manage', 'contact-messages', 'user-feedback'])
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-comments"></i><span>Comments &
                            Feedback</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">Manage Comments</a></li>
                        <li><a class="nav-link" href="#">Contact Messages</a></li>
                        <li><a class="nav-link" href="#">User Feedback</a></li>
                    </ul>
                </li>
            @endcan

            {{-- Reports --}}
            @canany(['report-news', 'report-view-count', 'report-popular', 'report-daily-monthly'])
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-file-alt"></i><span>Reports</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">News Reports</a></li>
                        <li><a class="nav-link" href="#">View Count</a></li>
                        <li><a class="nav-link" href="#">Popular News</a></li>
                        <li><a class="nav-link" href="#">Daily / Monthly Reports</a></li>
                    </ul>
                </li>
            @endcan

            {{-- Archive --}}
            @canany(['archive-date-wise', 'archive-category-wise'])
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-archive"></i><span>Archive</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">Date-wise Archive</a></li>
                        <li><a class="nav-link" href="#">Category-wise Archive</a></li>
                    </ul>
                </li>
            @endcan

            {{-- Security --}}
            @canany(['security-login-logs', 'security-ip-block', 'security-backup'])
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-shield-alt"></i><span>Security</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">Login Logs</a></li>
                        <li><a class="nav-link" href="#">IP Block</a></li>
                        <li><a class="nav-link" href="#">Backup Database</a></li>
                    </ul>
                </li>
            @endcan

        </ul>

        {{-- Logout --}}
        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="{{ route('logout') }}" class="btn btn-primary btn-lg btn-block btn-icon-split"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i> Sign Out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>
</div>
