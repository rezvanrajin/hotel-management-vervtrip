<div id="layoutSidenav_nav">

    {{-- <div class="user_profile">
        <img class="profile-image"
            src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('assets/img/no-img.jpg') }}"
            alt="">

        <div class="profile-title text-capitalize">{{ Auth::user()->name }}</div>
        <div class="profile-description">{{ Auth::user()->roles->name }}</div>
    </div> --}}

    <nav class="sb-sidenav accordion sb-sidenav-dark mt-5 bg_green" id="sidenavAccordion">
        <div class="sb-sidenav-menu">

            <div class="nav">

                {{-- admin  --}}
                @if (Helper::hasRight('dashboard.view'))
                    <a class="nav-link {{ Route::is('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}"
                        href="{{ route('admin.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Dashboard
                    </a>
                @endif

        
            @if (Helper::hasRight('management & hotel.view'))
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#setupHotel"
                    aria-expanded="@if (Route::is('hotel.room') ||
                            Route::is('hotel.room.create') ||
                            Route::is('hotel.room.edit') ||
                            Route::is('hotel.room.details')) true @else false @endif"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user-tie"></i></div> Manage Hotel & Bookings
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if (Route::is('hotel.room') ||
                        Route::is('hotel.room.create') ||
                        Route::is('hotel.room.edit') ||
                        Route::is('hotel.room.right') ||
                        Route::is('hotel.room.details')) show @endif" id="setupHotel"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav down">
                        @if (Helper::hasRight('hotel.view'))
                            <a class="nav-link {{ Route::is('hotel.room') || Route::is('hotel.room.create') || Route::is('hotel.room.edit') ? 'active' : '' }}"
                                href="{{ route('hotel.room') }}"><i class="fa-solid fa-angles-right ikon"></i> Room
                                Management</a>
                        @endif
                        @if (Helper::hasRight('booking.view'))
                            <a class="nav-link {{ Route::is('booking.room') ? 'active' : '' }}"
                                href="{{ route('booking.room') }}"><i class="fa-solid fa-angles-right ikon"></i>
                                Bookings Management</a>
                        @endif

                
                    </nav>
                </div>
            @endif

                @if (Helper::hasRight('setting.view'))
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#setupNav"
                    aria-expanded="@if (Route::is('admin.role') ||
                            Route::is('admin.role.create') ||
                            Route::is('admin.role.edit') ||
                            Route::is('admin.role.right') ||
                            Route::is('admin.user.details') ||
                            Route::is('admin.driver') ||
                            Route::is('admin.driver.details') ||
                            Route::is('admin.dispatcher') ||
                            Route::is('admin.dispatcher.details') ||
                            Route::is('admin.user')) true @else false @endif"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user-tie"></i></div> Administration
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if (Route::is('admin.role') ||
                        Route::is('admin.role.create') ||
                        Route::is('admin.role.edit') ||
                        Route::is('admin.role.right') ||
                        Route::is('admin.user.details') ||
                        Route::is('admin.driver') ||
                        Route::is('admin.driver.details') ||
                        Route::is('admin.dispatcher') ||
                        Route::is('admin.dispatcher.details') ||
                        Route::is('admin.user')) show @endif" id="setupNav"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav down">
                        @if (Helper::hasRight('role.view'))
                            <a class="nav-link {{ Route::is('admin.role') || Route::is('admin.role.create') || Route::is('admin.role.edit') ? 'active' : '' }}"
                                href="{{ route('admin.role') }}"><i class="fa-solid fa-angles-right ikon"></i> Role
                                Management</a>
                        @endif
                        @if (Helper::hasRight('right.view'))
                            <a class="nav-link {{ Route::is('admin.role.right') ? 'active' : '' }}"
                                href="{{ route('admin.role.right') }}"><i class="fa-solid fa-angles-right ikon"></i>
                                Right Management</a>
                        @endif
                        @if (Helper::hasRight('user.view'))
                            <a class="nav-link {{ Route::is('admin.user') || Route::is('admin.user.details') ? 'active' : '' }}"
                                href="{{ route('admin.user') }}"><i class="fa-solid fa-angles-right ikon"></i> User
                                Management
                            </a>
                        @endif
                    </nav>
                </div>
            @endif
                @if (Helper::hasRight('setting.view'))
                    <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse" data-bs-target="#settingNav"
                        aria-expanded="@if (Route::is('admin.setting.general') ||
                                Route::is('admin.setting.static.content') ||
                                Route::is('admin.setting.legal.content') ||
                                Route::is('admin.contact') ||
                                Route::is('admin.resource')) true @else false @endif"
                        aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div> Landing Page
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse @if (Route::is('admin.setting.general') ||
                            Route::is('admin.setting.static.content') ||
                            Route::is('admin.setting.legal.content') ||
                            Route::is('admin.contact') ||
                            Route::is('admin.resource')) show @endif" id="settingNav"
                        aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav down">
                            @if (Helper::hasRight('setting.general'))
                                <a class="nav-link {{ Route::is('admin.setting.general') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.general') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> General Setting </a>
                            @endif

                            @if (Helper::hasRight('setting.static-content'))
                                <a class="nav-link {{ Route::is('admin.setting.static.content') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.static.content') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> Static Content</a>
                            @endif

                            @if (Helper::hasRight('setting.legal-content'))
                                <a class="nav-link {{ Route::is('admin.setting.legal.content') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.legal.content') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> Legal Content</a>
                            @endif

                            @if (Helper::hasRight('setting.general'))
                                <a class="nav-link {{ Route::is('admin.setting.general.page') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.general.page') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> Landing Page Setting </a>
                            @endif

                           
                        </nav>
                    </div>
                @endif
            </div>
    </nav>
</div>
