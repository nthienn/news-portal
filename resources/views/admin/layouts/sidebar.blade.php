<div class="navbar-bg">
</div>
<!-- Navbar -->
@include('admin.layouts.navbar')

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="{{ asset('admin/assets/img/stisla.svg') }}" alt="logo" width="50"
                class="shadow-light rounded-circle">
            <a href="{{ route('admin.dashboard') }}">{{ __('admin.Stisla') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <img src="{{ asset('admin/assets/img/stisla.svg') }}" alt="logo" width="50"
                class="shadow-light rounded-circle">
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('admin.Dashboard') }}</li>

            <li class="{{ setSidebarActive(['admin.dashboard']) }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fire"></i>
                    <span>{{ __('admin.Dashboard') }}</span>
                </a>
            </li>

            <li class="menu-header">{{ __('admin.Starter') }}</li>

            @if (canAccess('category index'))
                <li class="{{ setSidebarActive(['admin.category.*']) }}">
                    <a class="nav-link" href="{{ route('admin.category.index') }}">
                        <i class="fas fa-list"></i>
                        <span>{{ __('admin.Category') }}</span>
                    </a>
                </li>
            @endif

            @if (canAccess('news index'))
                <li class="dropdown {{ setSidebarActive(['admin.news.*', 'admin.pending-news.*']) }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-newspaper"></i>
                        <span>{{ __('admin.News') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.news.*']) }}">
                            <a class="nav-link" href="{{ route('admin.news.index') }}">
                                {{ __('admin.All News') }}
                            </a>
                        </li>
                        <li class="{{ setSidebarActive(['admin.pending-news.*']) }}">
                            <a class="nav-link" href="{{ route('admin.pending-news.show') }}">
                                {{ __('admin.Pending News') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (canAccess('about index') || canAccess('contact index'))
                <li class="dropdown {{ setSidebarActive(['admin.about.*', 'admin.contact.*']) }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-file-alt"></i>
                        <span>{{ __('admin.Pages') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        @if (canAccess('about index'))
                            <li class="{{ setSidebarActive(['admin.about.*']) }}">
                                <a class="nav-link" href="{{ route('admin.about.index') }}">
                                    {{ __('admin.About') }}
                                </a>
                            </li>
                        @endif
                        @if (canAccess('contact index'))
                            <li class="{{ setSidebarActive(['admin.contact.*']) }}">
                                <a class="nav-link" href="{{ route('admin.contact.index') }}">
                                    {{ __('admin.Contact') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (canAccess('home section index'))
                <li class="{{ setSidebarActive(['admin.home-section.*']) }}">
                    <a class="nav-link" href="{{ route('admin.home-section.index') }}">
                        <i class="fas fa-wrench"></i>
                        <span>{{ __('admin.Home Section') }}</span>
                    </a>
                </li>
            @endif

            @if (canAccess('advertise index'))
                <li class="{{ setSidebarActive(['admin.advertise.*']) }}">
                    <a class="nav-link" href="{{ route('admin.advertise.index') }}">
                        <i class="fas fa-ad"></i>
                        <span>{{ __('admin.Advertise') }}</span>
                    </a>
                </li>
            @endif

            @if (canAccess('message index'))
                <li class="{{ setSidebarActive(['admin.message.*']) }}">
                    <a class="nav-link" href="{{ route('admin.message.index') }}">
                        <i class="fas fa-envelope-open"></i>
                        <span>{{ __('admin.Message') }}</span>
                        @if ($unReadMessages > 0)
                            <i class="badge bg-danger text-white">{{ $unReadMessages }}</i>
                        @endif
                    </a>
                </li>
            @endif

            @if (canAccess('social media index'))
                <li class="{{ setSidebarActive(['admin.social-media.*']) }}">
                    <a class="nav-link" href="{{ route('admin.social-media.index') }}">
                        <i class="fas fa-hashtag"></i>
                        <span>{{ __('admin.Social Media') }}</span>
                    </a>
                </li>
            @endif

            @if (canAccess('subscriber index'))
                <li class="{{ setSidebarActive(['admin.subscriber.*']) }}">
                    <a class="nav-link" href="{{ route('admin.subscriber.index') }}">
                        <i class="fas fa-users"></i>
                        <span>{{ __('admin.Subscriber') }}</span>
                    </a>
                </li>
            @endif

            @if (canAccess('access management index'))
                <li class="dropdown {{ setSidebarActive(['admin.role.*', 'admin.role-user.*']) }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-user-shield"></i>
                        <span>{{ __('admin.Access Management') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.role.*']) }}">
                            <a class="nav-link" href="{{ route('admin.role.index') }}">
                                {{ __('admin.Role and Permission') }}
                            </a>
                        </li>
                        <li class="{{ setSidebarActive(['admin.role-user.*']) }}">
                            <a class="nav-link" href="{{ route('admin.role-user.index') }}">
                                {{ __('admin.Role User') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (canAccess('setting index'))
                <li class="{{ setSidebarActive(['admin.setting.*']) }}">
                    <a class="nav-link" href="{{ route('admin.setting.index') }}">
                        <i class="fas fa-cog"></i>
                        <span>{{ __('admin.Setting') }}</span>
                    </a>
                </li>
            @endif

            @if (canAccess('language index'))
                <li
                    class="dropdown {{ setSidebarActive(['admin.localization-admin.*', 'admin.localization-frontend.*', 'admin.language.*']) }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-language"></i>
                        <span>{{ __('admin.Localization') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.localization-admin.*']) }}">
                            <a class="nav-link" href="{{ route('admin.localization-admin.index') }}">
                                {{ __('admin.Admin ') }}
                            </a>
                        </li>
                        <li class="{{ setSidebarActive(['admin.localization-frontend.*']) }}">
                            <a class="nav-link" href="{{ route('admin.localization-frontend.index') }}">
                                {{ __('admin.Frontend ') }}
                            </a>
                        </li>
                        <li class="{{ setSidebarActive(['admin.language.*']) }}">
                            <a class="nav-link" href="{{ route('admin.language.index') }}">
                                <span>{{ __('admin.Language') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

        </ul>
    </aside>
</div>
