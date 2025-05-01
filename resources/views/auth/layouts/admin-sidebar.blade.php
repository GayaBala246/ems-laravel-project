<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Main</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Dashboard
                    </a>
                </li>
                <li class="{{ Route::is('admin.employee.*') ? 'mm-active' : '' }}">
                    <a href="#" class="has-arrow">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Employees
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse {{ Route::is('admin.employee.*') ? 'mm-show' : '' }}">
                        <li>
                            <a href="{{ route('admin.employee.list') }}" class="{{ Route::is('admin.employee.list') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-rocket"></i>
                                List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.employee.add') }}" class="{{ Route::is('admin.employee.add') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-rocket"></i>
                                Add New
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Route::is('admin.shift.*') ? 'mm-active' : '' }}">
                    <a href="#" class="has-arrow">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Shifts
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse {{ Route::is('admin.shift.*') ? 'mm-show' : '' }}">
                        <li>
                            <a href="{{ route('admin.shift.list') }}" class="{{ Route::is('admin.shift.list') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-rocket"></i>
                                List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.shift.add') }}" class="{{ Route::is('admin.shift.add') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-rocket"></i>
                                Add New
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Route::is('admin.payroll.*') ? 'mm-active' : '' }}">
                    <a href="#" class="has-arrow">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Payrolls
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse {{ Route::is('admin.payroll.*') ? 'mm-show' : '' }}">
                        <li>
                            <a href="{{ route('admin.payroll.list') }}" class="{{ Route::is('admin.payroll.list') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-rocket"></i>
                                List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.payroll.add') }}" class="{{ Route::is('admin.payroll.add') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-rocket"></i>
                                Add New
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="app-sidebar__heading">Attendances</li>
                <li>
                    <a href="{{ route('admin.shift.today') }}" class="{{ Route::is('admin.shift.today') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Today Shifts
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.shift.pending') }}" class="{{ Route::is('admin.shift.pending') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Pending Shifts
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
