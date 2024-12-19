@extends('admin.admin_master')

@section('title')
    Dashboard
@endsection

@section('admin')
    <style>
        /* Base card styling */
        .card.dash-widget {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px; /* Space between cards */
            display: flex; /* Flexbox for equal height */
            flex-direction: column; /* Stack children vertically */
        }

        /* Ensure the card body fills the card */
        .card-body {
            flex-grow: 1; /* Allow the body to grow */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center content vertically */
            align-items: center; /* Center content horizontally */
        }

        /* Hover effect: scale and shadow */
        .card.dash-widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            border-color: #007bff;
        }

        /* Icon color */
        .dash-widget-icon {
            color: #4CAF50; /* Change to a nice green color */
            font-size: 36px; /* Adjust icon size */
        }

        /* Icon color change on hover */
        .card.dash-widget:hover .dash-widget-icon {
            color: #007bff; /* Change color on hover */
        }

        /* Heading font sizes */
        .dash-widget-info h3 {
            font-size: 1.5rem; /* Adjusted font size */
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .dash-widget-icon {
                font-size: 24px; /* Adjust icon size for smaller screens */
            }
            .dash-widget-info h3 {
                font-size: 1.2rem; /* Smaller font size for smaller screens */
            }
        }

        /* Chart Container */
        .chart-container {
            margin-top: 20px;
            max-width: 500px; /* Set a maximum width */
            margin-left: auto; /* Center align */
            margin-right: auto; /* Center align */
        }

        #windroseChart {
            width: 100% !important; /* Responsive width */
            height: auto !important; /* Maintain aspect ratio */
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
        @foreach ([
            ['icon' => 'fa-user', 'value' => $total_mem, 'label' => 'Total Members'],
            ['icon' => 'fa-user', 'value' => $total_mem_male, 'label' => 'Total Males'],
            ['icon' => 'fa-user', 'value' => $total_mem_female, 'label' => 'Total Females'],
            ['icon' => 'fa-user', 'value' => $total_users, 'label' => 'Users'],
        ] as $widget)
            <div class="col-md-6 col-lg-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa-solid {{ $widget['icon'] }}"></i></span>
                        <div class="dash-widget-info">
                            <span>{{ $widget['label'] }}</span>
                            <h4>{{ $widget['value'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        @foreach ([
            ['route' => 'members-tithe-table', 'icon' => 'fa-money-bill-wave', 'totals' => $totals['tithe'], 'label' => 'Tithe'],
            ['route' => 'church-offering', 'icon' => 'fa-hand-holding-heart', 'totals' => $totals['offering'], 'label' => 'Offering'],
            ['route' => 'children-service-offering', 'icon' => 'fa-child', 'totals' => $totals['children_offering'], 'label' => 'Children'],
            ['route' => 'church-expenditure', 'icon' => 'fa-coins', 'totals' => $totals['expenditure'], 'label' => 'Expenditure'],
        ] as $widget)
            <div class="col-md-6 col-lg-3">
                <div class="card dash-widget">
                    <a href="{{ route($widget['route']) }}">
                        <div class="card-body" style="color:black">
                            <span class="dash-widget-icon"><i class="fa-solid {{ $widget['icon'] }}"></i></span>
                            @foreach (['week', 'month', 'year'] as $period)
                                <div class="dash-widget-info">
                                    <span>{{ $period === 'week' ? 'Weekly' : ($period === 'month' ? 'Monthly' : 'Yearly') }} {{ $widget['label'] }}</span>
                                    <h6>GHS {{ number_format($widget['totals'][$period], 2) }}</h6>
                                </div>
                            @endforeach
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row chart-container">
        <div class="col-12">
            <canvas id="windroseChart" width="400" height="400"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('windroseChart').getContext('2d');
        const windroseChart = new Chart(ctx, {
            type: 'polarArea',
            data: {
                labels: ['Weekly Tithe', 'Monthly Tithe', 'Yearly Tithe',
                         'Weekly Offering', 'Monthly Offering', 'Yearly Offering',
                         'Weekly Children Offering', 'Monthly Children Offering', 'Yearly Children Offering'],
                datasets: [{
                    label: 'Financial Contributions',
                    data: [
                        {{ $totals['tithe']['week'] }},
                        {{ $totals['tithe']['month'] }},
                        {{ $totals['tithe']['year'] }},
                        {{ $totals['offering']['week'] }},
                        {{ $totals['offering']['month'] }},
                        {{ $totals['offering']['year'] }},
                        {{ $totals['children_offering']['week'] }},
                        {{ $totals['children_offering']['month'] }},
                        {{ $totals['children_offering']['year'] }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
