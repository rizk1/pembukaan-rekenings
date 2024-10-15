@extends('layout.app-layout')
@section('title-page', 'Pekerjaan - ')
@section('title-content', 'Pekerjaan')

@section('css')
<link rel="stylesheet" href="{{asset('assets/modules/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection

@section('content')
<h2 class="section-title">Data Pekerjaan</h2>
<div class="row">
    <div class="col-12">
    <div class="card">
        <div class="card-header">
        <h4>Data Pekerjaan</h4>
        <div class="card-header-action">
            <button class="btn btn-primary btn-add-pekerjaan">Tambah Pekerjaan</button>
        </div>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="tabelPekerjaan">
            <thead>                                 
                <tr>
                    <th>No</th>
                    <th>Nama Pekerjaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            </table>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="modal-pekerjaan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Pekerjaan Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-pekerjaan">
                @csrf
                <input type="hidden" name="id" id="pekerjaan-id">
                <div class="modal-body">
                    <div id="validation-errors" class="alert alert-danger" style="display: none;"></div>
                    <div class="form-group">
                        <label>Nama Pekerjaan</label>
                        <input type="text" name="nama_pekerjaan" class="form-control" id="pekerjaan-nama" required>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
    var table = $('#tabelPekerjaan').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('pekerjaan.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_pekerjaan', name: 'nama_pekerjaan'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Add Pekerjaan
    $('.btn-add-pekerjaan').click(function() {
        resetModalForm();
        $('#modal-pekerjaan').modal('show');
    });

    // Edit Pekerjaan
    $(document).on('click', '.edit-pekerjaan', function() {
        var id = $(this).data('id');
        $.get("{{ url('pekerjaan') }}/" + id + "/edit", function(data) {
            resetModalForm();
            $('#modal-title').text('Edit Pekerjaan');
            $('#pekerjaan-id').val(data.id);
            $('#pekerjaan-nama').val(data.nama_pekerjaan);
            $('#modal-pekerjaan').modal('show');
        });
    });

    $('#form-pekerjaan').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var pekerjaanId = $('#pekerjaan-id').val();
        var url = pekerjaanId ? "{{ url('pekerjaan') }}/" + pekerjaanId : "{{ route('pekerjaan.store') }}";
        var method = pekerjaanId ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                $('#modal-pekerjaan').modal('hide');
                table.ajax.reload();
                Swal.fire('Berhasil!', 'Data pekerjaan telah ' + (pekerjaanId ? 'diperbarui.' : 'ditambahkan.'), 'success');
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<ul>';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#validation-errors').html(errorHtml).show();
                } else {
                    Swal.fire('Error!', 'Terjadi kesalahan saat memproses data pekerjaan.', 'error');
                }
            }
        });
    });

    // Delete Pekerjaan
    $(document).on('click', '.delete-pekerjaan', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Pekerjaan',
            text: 'Apakah Anda yakin ingin menghapus pekerjaan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('pekerjaan') }}/" + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire('Berhasil!', 'Pekerjaan telah dihapus.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus pekerjaan.', 'error');
                    }
                });
            }
        });
    });

    function resetModalForm() {
        $('#form-pekerjaan')[0].reset();
        $('#pekerjaan-id').val('');
        $('#modal-title').text('Tambah Pekerjaan Baru');
        $('#validation-errors').html('').hide();
    }
});
</script>
@endsection

