
@extends('layouts.app')

@section('template_title')
    Edit Plan Permission 
@endsection

@section('style')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Permission</h3>
                        <div class="nk-block-des text-soft">
                            <p>Edit Permission Role</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <div class="drodown"><a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                        data-bs-toggle="dropdown"><em class="icon ni ni-minus"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li>
                                                <a href="../permissions-roles" id="createNewPost">
                                                    <span>Cancel</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner">
<form action="{{ url('edit-permission', optional($mber)->permission_id) }}" method="post">
{{ csrf_field() }}
            <div class="form-group">
                <label for="role_id">Role (Currently: {{ $mber->role_id }})</label>
<select class="form-control" id="roleDropdown" name="role_id">
    <option class="form-control" value="">Select Role</option>
</select>

<script>
    // Fetch permissions from the controller endpoint
    fetch('/dropdown-role')
        .then(response => response.json())
        .then(data => {
            const dropdown = document.getElementById('roleDropdown');
            data.forEach(role => {
                const option = document.createElement('option');
                option.value = role.id;
                option.textContent = role.name;
                dropdown.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching Role:', error));
</script>
            </div>
            <div class="form-group">
                <label for="permission_id">Permission (Currently: {{ $mber->permission_id }})</label>
<select class="form-control" id="permissionDropdown" name="permission_id">
    <option class="form-control" value="">Select Permission</option>
</select>

<script>
    // Fetch permissions from the controller endpoint
    fetch('/dropdown-permission')
        .then(response => response.json())
        .then(data => {
            const dropdown = document.getElementById('permissionDropdown');
            data.forEach(permission => {
                const option = document.createElement('option');
                option.value = permission.id;
                option.textContent = permission.name;
                dropdown.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching permissions:', error));
</script>
            </div>
            <!-- Add more form fields if needed -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>  
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

@endsection