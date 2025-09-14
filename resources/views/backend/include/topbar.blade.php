<nav class="sb-topnav navbar navbar-expand navbar-dark">
    <a class="navbar-brand text-center ps-3" target="_blank" href="">
        {{-- <img src="{{ Helper::getSettings('site_logo') ? asset('uploads/settings/' . Helper::getSettings('site_logo')) : asset('assets/img/no-img.jpg') }}"
            width="70px" alt="Logo"> --}}
    </a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>
    <div class="ms-4">
        <h2>Hotel Paradise Management System</h2>
    </div>
    <ul class="ms-auto me-0 me-md-3 my-2 my-md-0 me-lg-4 gap-3">
        <li class="">
            <div class="ok">
                <div class="admin-profile">
                                        <!-- Primary -->
<a href="{{ route('home') }}" class="btn btn-primary">
    <i class="fas fa-home me-2"></i>Home
</a>
                    <div class="dropdown mx-3">
                        
                        <a href="#" class="" id="navbarBellDropdown" role="button" aria-expanded="false">
                            <i class="fa-regular fa-bell"></i>
                        </a>

                        {{-- <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fa fa-user"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile.setting') }}">
                                    <i class="fa-solid fa-gear"></i> Change Password
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                                </a>
                            </li>
                        </ul> --}}
                    </div>
                    <div class="dropdown">
                        <a href="#" class="topimage" id="navbarDropdown" role="button" aria-expanded="false">
                            <img class="profile-img"
                                src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('assets/img/no-img.jpg') }}"
                                alt="profile image">
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fa fa-user"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile.setting') }}">
                                    <i class="fa-solid fa-gear"></i> Change Password
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>


<style>
    /* Style for the dropdown within the .admin-profile parent */
    .admin-profile .dropdown {
        position: relative;
    }

    .admin-profile .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
    }

    .admin-profile .dropdown:hover .dropdown-menu {
        display: block;
    }
</style>
