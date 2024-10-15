@extends('layout.app-layout')
@section('title-page', 'Users - ')
@section('title-content', 'Users')

@section('css')
<link rel="stylesheet" href="{{asset('assets/modules/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
<style>
    .clickable {
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<h2 class="section-title">Data Users</h2>
<div class="row">
    <div class="col-12">
    <div class="card">
        <div class="card-header">
        <h4>Data Users</h4>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="tabelUsers">
            <thead>                                 
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="modal-change-status" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change User Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-change-status">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="user-id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="user-status">
                            <option value="false" selected>Active</option>
                            <option value="true">Blocked</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('assets/modules/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/page/modules-datatables.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    var table = $('#tabelUsers').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'is_blocked', name: 'is_blocked', render: function(data, type, row) {
                var statusClass = data === false ? 'badge-success' : 'badge-danger';
                return '<span class="badge ' + statusClass + ' change-status clickable" data-id="' + row.id + '" data-status="' + data + '">' + 
                       (data === false ? 'Active' : 'Blocked') + '</span>';
            }},
        ]
    });

    $(document).on('click', '.change-status', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        $('#user-id').val(id);
        $('#user-status').val(status);
        $('#modal-change-status').modal('show');
    });

    $('#form-change-status').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var userId = $('#user-id').val();

        $.ajax({
            url: "{{ url('users') }}/" + userId + "/change-status",
            method: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-change-status').modal('hide');
                table.ajax.reload();
                Swal.fire('Success!', 'User status has been updated.', 'success');
            },
            error: function(xhr) {
                Swal.fire('Error!', 'An error occurred while updating user status.', 'error');
            }
        });
    });
});
</script>
@endsection
