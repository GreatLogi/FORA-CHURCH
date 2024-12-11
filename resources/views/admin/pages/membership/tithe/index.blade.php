@extends('admin.admin_master')
@section('title')
    Tithe Payment
@endsection

@section('admin')
    <style>
        .action-popup {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 150px;
        }

        .action-popup ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .action-popup ul li {
            padding: 5px 0;
        }

        .action-popup ul li a {
            text-decoration: none;
            color: #333;
        }

        .action-popup ul li a:hover {
            color: #007bff;
        }

        .action-icon {
            cursor: pointer;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Tithes</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tithes</li>
                </ul>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ route('membership-table') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add
                        Tithe</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="membership" class="datatable table table-stripped mb-0">
                            <thead>
                                <tr>
                                    <th>No#</th>
                                    <th>Member</th>
                                    <th>Amount</th>
                                    <th>Remarks</th>
                                    <th>Taken By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script>
        function showActionPopup(event, uuid) {
            event.preventDefault();
            // Hide any other open pop-ups
            document.querySelectorAll('.action-popup').forEach(popup => {
                popup.style.display = 'none';
            });
            // Show the relevant pop-up
            const popup = document.getElementById(`action-popup-${uuid}`);
            if (popup) {
                popup.style.display = popup.style.display === 'none' ? 'block' : 'none';
            }
        }
        // Close the popup when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.action-icon') && !event.target.closest('.action-popup')) {
                document.querySelectorAll('.action-popup').forEach(popup => {
                    popup.style.display = 'none';
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#membership').DataTable({
                dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                buttons: [
                    'colvis',
                    {
                        extend: 'copy',
                        text: 'Copy to clipboard'
                    },
                    'excel',
                ],
                scrollY: 960,
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [15, 25, 50, 100, 200, -1],
                    [15, 25, 50, 100, 200, 'All'],
                ],
                ajax: {
                    url: "{{ route('api-members-tithes') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        var formData = $('#filter-form').serializeArray();
                        $.each(formData, function(index, item) {
                            d[item.name] = item.value;
                        });
                    },
                },

                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },

                    {
                        data: 'member_name',
                        name: 'member_name'
                    },

                    {
                        data: 'formatted_amount',
                        name: 'formatted_amount'
                    },
                    {
                        data: 'remarks',
                        name: 'remarks'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endsection
