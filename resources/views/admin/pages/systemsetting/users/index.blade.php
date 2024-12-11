@extends('admin.admin_master')
@section('title')
    Users
@endsection
@section('admin')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Users</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ul>
            </div>
            @include('admin.pages.systemsetting.users.part.message')
            <div class="col-auto float-end ms-auto">
                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_user"><i
                        class="fa-solid fa-plus"></i> Add User</a>
                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_role"><i
                        class="fa-solid fa-plus"></i> Add Role</a>
                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_role_permission"><i
                        class="fa-solid fa-plus"></i> Add Role with Permissions</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="users" class="table table-striped custom-table datatable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Code</th>
                            <th>Phone</th>
                            <th>Created Date</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- /Table -->

    <!-- Add User Modal -->
    <div id="add_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create User Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store-user') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- User Details -->
                            <div class="col-sm-6">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Name</label>
                                    <input class="form-control" type="text" name="name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Phone</label>
                                    <input class="form-control" type="text" name="phone_number" required>
                                </div>
                            </div>

                            <!-- Role Selection and Permissions -->
                            <div class="col-sm-12">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Roles <span class="text-danger">*</span></label>
                                    <div>
                                        @foreach ($roles as $role)
                                            <div class="form-check">
                                                <input class="form-check-input role-checkbox" type="checkbox"
                                                    id="role_{{ $role->id }}" name="roles[]"
                                                    value="{{ $role->id }}">
                                                <label class="form-check-label" for="role_{{ $role->id }}">
                                                    {{ $role->name }}
                                                </label>
                                            </div>
                                            <!-- Display Permissions for each Role -->
                                            <div class="permissions-for-role" id="permissions-{{ $role->id }}"
                                                style="margin-left: 20px;">
                                                @foreach ($role->permissions as $permission)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="permissions[{{ $role->id }}][]"
                                                            value="{{ $permission->id }}">
                                                        <label class="form-check-label">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- /Add User Modal -->

    <!-- Add Role Modal -->
    <div id="add_role" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store-role') }}" method="POST">
                        @csrf
                        <div class="input-block mb-3">
                            <label class="col-form-label">Role Name</label>
                            <input class="form-control" type="text" name="name">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Role Modal -->

    <!-- Add Role with Permissions Modal -->
    <!-- Add Role with Permissions Modal -->
    <div id="add_role_permission" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Permissions to Role(s)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store-role-permission') }}" method="POST">
                        @csrf

                        <!-- Select Role(s) with Checkboxes -->
                        <div class="input-block mb-3">
                            <label class="col-form-label">Select Role(s)</label><br>
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="role_ids[]"
                                        value="{{ $role->id }}" id="role_{{ $role->id }}">
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Input for Permissions -->
                        <div class="input-block mb-3">
                            <label class="col-form-label">Enter Permissions (comma separated)</label>
                            <input class="form-control" type="text" name="permissions_input"
                                placeholder="e.g., create-post, delete-post, edit-post">
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- /Add Role with Permissions Modal -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#users').DataTable({
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
                    url: "{{ route('api-view-user') }}",
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
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'roles',
                        name: 'roles'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
    <script>
        document.querySelectorAll('.role-checkbox').forEach(roleCheckbox => {
            roleCheckbox.addEventListener('change', function() {
                const roleId = this.value;
                const permissionsContainer = document.getElementById('permissions-' + roleId);
                if (this.checked) {
                    permissionsContainer.style.display = 'block';
                } else {
                    permissionsContainer.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let rolesWithPermissions = @json($rolesWithPermissions);
            $('.role-checkbox').change(function() {
                let selectedRoles = $('.role-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                let permissions = [];
                selectedRoles.forEach(roleId => {
                    permissions = permissions.concat(rolesWithPermissions[roleId] || []);
                });

                // Remove duplicates
                permissions = [...new Set(permissions)];

                // Update the permissions container
                let html = '';
                permissions.forEach(permission => {
                    html += `<div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               id="permission_${permission.id}" name="permissions[]"
                               value="${permission.id}">
                        <label class="form-check-label" for="permission_${permission.id}">
                            ${permission.name}
                        </label>
                    </div>`;
                });
                $('#permissions-container').html(html);
            });
        });
    </script>
@endsection
