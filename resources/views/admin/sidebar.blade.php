<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a class="active" href="{{ route('dashboard') }}">Dashboard</a></li>

                    </ul>
                </li>

                <li class="menu-title">
                    <span>Staffs and Members</span>
                </li>
                <li class="submenu">
                    <a href="#" class="noti-dot"><i class="la la-user"></i> <span>Membership</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('membership-table') }}">All Members</a></li>
                        <li><a class="{{ Route::is('mech-membership') ? 'active' : '' }}"
                                href="{{ route('mech-membership') }}">Mech Member</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="la la-pie-chart"></i> <span> Reports </span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a class="{{ Route::is('account-balance') ? 'active' : '' }}"
                                href="{{ route('account-balance') }}">Account Balance</a></li>
                        <li><a class="{{ Route::is('church-expenditure') ? 'active' : '' }}"
                                href="{{ route('church-expenditure') }}">Expenditure</a></li>
                        <li><a class="{{ Route::is('members-tithe-table') ? 'active' : '' }}"
                                href="{{ route('members-tithe-table') }}">Tithes</a></li>
                        <li><a class="{{ Route::is('church-offering') ? 'active' : '' }}"
                                href="{{ route('church-offering') }}">Church Offering</a></li>
                        <li><a class="{{ Route::is('children-service-offering') ? 'active' : '' }}"
                                href="{{ route('children-service-offering') }}">Children Service Offering</a></li>

                    </ul>
                </li>

                @role('Superadmin')
                    <li class="submenu">
                        <a href="#"><i class="la la-pie-chart"></i> <span>System Setting</span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('districts') }}">Districts</a></li>
                            <li><a class="{{ Route::is('index-user') ? 'active' : '' }}"
                                    href="{{ route('index-user') }}">User Account</a></li>
                                   
                            <li><a class="{{ Route::is('user-login-times') ? 'active' : '' }}"
                                    href="{{ route('user-login-times') }}">User Login Times</a></li>
                            <li><a class="{{ Route::is('audit-trail') ? 'active' : '' }}"
                                    href="{{ route('audit-trail') }}">Audit Trail</a></li>
                            <li><a class="{{ Route::is('create-roles') ? 'active' : '' }}"
                                    href="{{ route('create-roles') }}">Roles</a></li>
                        </ul>
                    </li>
                @endrole
            </ul>

        </div>
    </div>
</div>
