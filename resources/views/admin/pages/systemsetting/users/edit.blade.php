@extends('admin.admin_master')
@section('title')
    Edit-UserAccount
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update-user', $user->uuid) }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- User Details -->
                            <div class="col-sm-6">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Name</label>
                                    <input class="form-control" type="text" name="name"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Phone</label>
                                    <input class="form-control" type="text" name="phone_number"
                                        value="{{ old('phone_number', $user->phone_number) }}" required>
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
                                                    id="role_{{ $role->id }}" name="roles[]" value="{{ $role->id }}"
                                                    {{ $user->roles->contains($role) || (old('roles') && in_array($role->id, old('roles', []))) ? 'checked' : '' }}>
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
                                                            value="{{ $permission->id }}"
                                                            {{ $user->permissions->contains($permission) || (old('permissions') && in_array($permission->id, old('permissions', []))) ? 'checked' : '' }}>
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
    <!-- /Table -->

    <!-- Add User Modal -->



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
    <script>
        document.querySelectorAll('.role-checkbox').forEach(roleCheckbox => {
            roleCheckbox.addEventListener('change', function() {
                const roleId = this.value;
                const permissionsContainer = document.getElementById('permissions-' + roleId);
                if (this.checked) {
                    permissionsContainer.style.display = 'block';
                } else {
                    permissionsContainer.style.display = 'none';
                    permissionsContainer.querySelectorAll('input[type="checkbox"]').forEach(
                        permissionCheckbox => {
                            permissionCheckbox.checked = false;
                        });
                }
            });
        });
    </script>
@endsection
