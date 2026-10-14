@extends('backend.layouts.app')
@section('title', 'Manage Role Permissions')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manage Role Permissions</h1>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Select Role --}}
                    <div class="form-group col-md-12">
                        <label><b>Select Role</b></label>
                        <select id="roleSelect" class="form-control roleSelect">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Permissions Form --}}
                    <label><b>Assign Permissions</b></label>
                    <form id="permissionForm" method="POST" style="display:none;" class="form-group col-md-12">
                        @csrf
                        
                        {{-- Select All / Deselect All Button --}}
                        <div class="mb-2" id="selectAllContainer" style="display:none;">
                            <button type="button" id="selectAllBtn" class="btn btn-sm btn-secondary">Select All</button>
                        </div>

                        <div id="permissionsContainer" class="row"></div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update Permissions</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    var getPermissionsUrl = "{{ route('get_permissions', ':role') }}";
    var updatePermissionsUrl = "{{ route('update_permissions', ':role') }}";

    // On role selection
    $('#roleSelect').on('change', function() {
        var roleId = $(this).val();

        if (!roleId) {
            $('#permissionsContainer').html('');
            $('#permissionForm').hide();
            $('#selectAllContainer').hide();
            $('#protectedRoleNotice').remove();
            $('#permissionForm button[type=submit]').prop('disabled', false);
            $('#selectAllBtn').prop('disabled', false);
            return;
        }

        $('#permissionsContainer').html('<p>Loading permissions...</p>');

        $.ajax({
            url: getPermissionsUrl.replace(':role', roleId),
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#permissionsContainer').html('');
                $('#permissionForm').show();
                $('#protectedRoleNotice').remove();
                if (data.protected) {
                    $('<div id="protectedRoleNotice" class="alert alert-warning" role="alert"></div>')
                        .text('Super Admin permissions are locked to prevent accidental loss of administrator access.')
                        .insertBefore('#permissionForm');
                }

                if (!data.permissions || data.permissions.length === 0) {
                    $('#permissionsContainer').text('No permissions available.');
                    $('#selectAllContainer').hide();
                    $('#permissionForm button[type=submit]').prop('disabled', true);
                    return;
                }

                // Show select all button
                $('#selectAllContainer').show();

                $('#permissionForm').attr('action', updatePermissionsUrl.replace(':role', roleId));
                $('#permissionForm button[type=submit]').prop('disabled', Boolean(data.protected));
                $('#selectAllBtn').prop('disabled', Boolean(data.protected));

                // Render checkboxes
                $.each(data.permissions, function(index, permission) {
                    var isChecked = data.role_permissions.includes(permission.id);
                    var $wrapper = $('<div>', { class: 'col-md-6 mb-2' });
                    var $check = $('<input>', {
                        class: 'form-check-input permission-checkbox', type: 'checkbox',
                        name: 'permission[]', value: permission.id, id: 'perm_' + permission.id,
                        checked: isChecked, disabled: Boolean(data.protected)
                    });
                    var $label = $('<label>', { class: 'form-check-label', for: 'perm_' + permission.id }).text(permission.name);
                    $wrapper.append($('<div>', { class: 'form-check' }).append($check, $label));
                    $('#permissionsContainer').append($wrapper);
                });

                // Update button text based on current selection
                updateSelectAllBtnText();
            },
            error: function(err) {
                console.error('AJAX error:', err);
                alert('Failed to load permissions. Try again.');
                $('#permissionsContainer').html('');
                $('#permissionForm').hide();
                $('#selectAllContainer').hide();
            }
        });
    });

    // Select / Deselect all functionality
    $(document).on('click', '#selectAllBtn', function() {
        var allChecked = $('.permission-checkbox:checked').length === $('.permission-checkbox').length;
        $('.permission-checkbox').prop('checked', !allChecked);
        updateSelectAllBtnText();
    });

    // Update button text dynamically when any checkbox is manually clicked
    $(document).on('change', '.permission-checkbox', function() {
        updateSelectAllBtnText();
    });

    function updateSelectAllBtnText() {
        if ($('.permission-checkbox').length === 0) {
            $('#selectAllContainer').hide();
            $('#protectedRoleNotice').remove();
            $('#permissionForm button[type=submit]').prop('disabled', false);
            $('#selectAllBtn').prop('disabled', false);
            return;
        }
        var allChecked = $('.permission-checkbox:checked').length === $('.permission-checkbox').length;
        $('#selectAllBtn').text(allChecked ? 'Deselect All' : 'Select All');
    }

});
</script>
@endpush
