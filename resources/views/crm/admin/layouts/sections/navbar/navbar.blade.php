<!--navigation-->
<div class="primary-menu">
    <nav class="navbar navbar-expand-lg align-items-center">
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header border-bottom">
                <div class="d-flex align-items-center">
                    <div class="">
                        <img src="{{ asset('assets/img/cloud-crm-logo.png'.Config::get('app.assets_version')) }}" class="logo-icon" alt="logo icon" style="width:180px">
                    </div>
                    <!-- <div class="">
                        <h4 class="logo-text">CloudCRM</h4>
                    </div> -->
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav align-items-center flex-grow-1">
                    <li class="nav-item {{ Request::routeIs('crm.dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('crm.dashboard') }}">
                            <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                            <div class="menu-title d-flex align-items-center">Dashboard</div>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                            data-bs-toggle="dropdown">
                            <div class="parent-icon"><i class='bx bx-user'></i>
                            </div>
                            <div class="menu-title d-flex align-items-center">Admin Users</div>
                            <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('crm.adminusers.index') }}"><i
                                        class='bx bx-list-ul'></i>Admin User List</a></li>
                            <li><a class="dropdown-item" href="{{ route('crm.roles.index') }}"><i
                                        class='bx bx-briefcase'></i>Roles and Privileges</a></li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Request::routeIs('crm.companies.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('crm.companies.index') }}">
                            <div class="parent-icon"><i class='bx bx-buildings'></i></div>
                            <div class="menu-title d-flex align-items-center">Companies</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<!--end navigation-->
<style>
    .nav-item.active>.nav-link {
        background-color: #4682b4;
        /* Blue background or any color you prefer */
        color: white;
        /* Text color when active */
    }
</style>