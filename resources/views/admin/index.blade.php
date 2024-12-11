@extends('admin.admin_master')
@section('title')
    Dashbaord
@endsection
@section('admin')
    <style>
        /* Base card styling */
        .card.dash-widget {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        /* Hover effect: scale and shadow */
        .card.dash-widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            border-color: #007bff;
            /* Optional: Highlight border color on hover */
        }

        /* Icon color change on hover */
        .card.dash-widget:hover .dash-widget-icon i {
            color: #007bff;
        }
    </style>

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Welcome Admin!</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa-solid fa-user"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{ $total_mem }}</h3>
                        <span>Total Members</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa-solid fa-user"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{ $total_mem_male }}</h3>
                        <span>TOTAL MALES</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa-solid fa-user"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{ $total_mem_female }}</h3>
                        <span>TOTAL FEMALES</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa-solid fa-user"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{ $total_users }}</h3>
                        <span>Users</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Weekly, Monthly, Yearly Tithe -->
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <a href="{{ route('members-tithe-table') }}">
                    <div class="card-body" style="color:black">
                        <span class="dash-widget-icon"><i class="fa-solid fa-money-bill-wave"></i></span>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['tithe']['week'], 2) }}</h3>
                            <span>Tithe (Weekly)</span>
                        </div>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['tithe']['month'], 2) }}</h3>
                            <span>Tithe (Monthly)</span>
                        </div>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['tithe']['year'], 2) }}</h3>
                            <span>Tithe (Yearly)</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Weekly, Monthly, Yearly Offering -->
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <a href="{{ route('church-offering') }}">
                    <div class="card-body" style="color:black">
                        <span class="dash-widget-icon"><i class="fa-solid fa-hand-holding-heart"></i></span>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['offering']['week'], 2) }}</h3>
                            <span>Offering (Weekly)</span>
                        </div>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['offering']['month'], 2) }}</h3>
                            <span>Offering (Monthly)</span>
                        </div>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['offering']['year'], 2) }}</h3>
                            <span>Offering (Yearly)</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Weekly, Monthly, Yearly Children Offering -->
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <a href="{{ route('children-service-offering') }}">
                    <div class="card-body" style="color:black">
                        <span class="dash-widget-icon"><i class="fa-solid fa-child"></i></span>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['children_offering']['week'], 2) }}</h3>
                            <span>Children Offering (Weekly)</span>
                        </div>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['children_offering']['month'], 2) }}</h3>
                            <span>Children Offering (Monthly)</span>
                        </div>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['children_offering']['year'], 2) }}</h3>
                            <span>Children Offering (Yearly)</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Weekly, Monthly, Yearly Expenditure -->
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <a href="{{ route('church-expenditure') }}">
                    <div class="card-body" style="color:black">
                        <span class="dash-widget-icon"><i class="fa-solid fa-coins"></i></span>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['expenditure']['week'], 2) }}</h3>
                            <span>Expenditure (Weekly)</span>
                        </div>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['expenditure']['month'], 2) }}</h3>
                            <span>Expenditure (Monthly)</span>
                        </div>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($totals['expenditure']['year'], 2) }}</h3>
                            <span>Expenditure (Yearly)</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <a href="{{ route('account-balance') }}">
                    <div class="card-body" style="color:black">
                        <span class="dash-widget-icon"><i class="fa-solid fa-wallet"></i></span>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($account_balance, 2) }}</h3>
                            <span>Account Balance</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <a href="{{ route('church-expenditure') }}">
                    <div class="card-body" style="color:black">
                        <span class="dash-widget-icon"><i class="fa-solid fa-coins"></i></span>
                        <div class="dash-widget-info">
                            <h3>GHS {{ number_format($total_expenditure, 2) }}</h3>
                            <span>Total Expenditure</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
