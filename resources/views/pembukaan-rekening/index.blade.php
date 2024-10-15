@extends('layout.app-layout')
@section('title-page', 'Pembukaan Rekening - ')
@section('title-content', 'Pembukaan Rekening')

@section('css')
<link rel="stylesheet" href="{{asset('assets/modules/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection

@section('content')
<h2 class="section-title">Data Pembukaan Rekening</h2>
<div class="row">
    <div class="col-12">
    <div class="card">
        <div class="card-header">
        <h4>Data Pembukaan Rekening</h4>
        <div class="card-header-action">
            @if(auth()->user()->role == 'CS')
            <button class="btn btn-primary btn-add-rekening">Tambah Pembukaan Rekening</button>
            @endif
        </div>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="tabelPembukaanRekening">
            <thead>                                 
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Pekerjaan</th>
                    <th>Nominal Setor</th>
                    <th>Status</th>
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
<div class="modal fade" id="modal-rekening" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Pembukaan Rekening Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-rekening">
                @csrf
                <input type="hidden" name="id" id="rekening-id">
                <div class="modal-body">
                    <div id="validation-errors" class="alert alert-danger" style="display: none;"></div>
                    <div class="form-group">
                        <label>Nama sesuai KTP</label>
                        <input type="text" name="nama" class="form-control" id="rekening-nama" required>
                        <small class="form-text text-muted">Hanya huruf, tanpa angka, simbol, atau gelar (Profesor, Haji)</small>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" id="rekening-tempat-lahir" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" id="rekening-tanggal-lahir" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" id="rekening-jenis-kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <select name="pekerjaan_id" class="form-control" id="rekening-pekerjaan" required>
                            <option value="">Pilih Pekerjaan</option>
                            @foreach ($pekerjaans as $pekerjaan)
                                <option value="{{ $pekerjaan->id }}">{{ $pekerjaan->nama_pekerjaan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <select name="provinsi" class="form-control" id="rekening-provinsi" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kabupaten/Kota</label>
                        <select name="kabupaten_kota" class="form-control" id="rekening-kabupaten" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <select name="kecamatan" class="form-control" id="rekening-kecamatan" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelurahan</label>
                        <select name="kelurahan" class="form-control" id="rekening-kelurahan" required>
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Jalan</label>
                        <input type="text" name="nama_jalan" class="form-control" id="rekening-nama-jalan" required>
                    </div>
                    <div class="form-group">
                        <label>RT</label>
                        <input type="text" name="rt" class="form-control" id="rekening-rt" required>
                    </div>
                    <div class="form-group">
                        <label>RW</label>
                        <input type="text" name="rw" class="form-control" id="rekening-rw" required>
                    </div>
                    <div class="form-group">
                        <label>Nominal Setor</label>
                        <input type="number" name="nominal_setor" class="form-control" id="rekening-nominal-setor" required>
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

<div class="modal fade" id="modal-approval" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approval Pembukaan Rekening</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menyetujui pembukaan rekening ini?</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirm-approval">Setujui</button>
            </div>
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
    let columns = [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama', name: 'nama'},
            {data: 'tempat_lahir', name: 'tempat_lahir'},
            {data: 'tanggal_lahir', name: 'tanggal_lahir'},
            {data: 'jenis_kelamin', name: 'jenis_kelamin'},
            {data: 'pekerjaan.nama_pekerjaan', name: 'pekerjaan.nama_pekerjaan'},
            {data: 'nominal_setor', name: 'nominal_setor', render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')},
            {data: 'status', name: 'status', render: function(data, type, row) {
                return data == 'Disetujui' ? `<span class="badge badge-success">${data}</span>` : `<span class="badge badge-warning">${data}</span>`;
            }},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]

    var table = $('#tabelPembukaanRekening').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('pembukaan-rekening.index') }}",
        columns: columns
    });

    // Add Pembukaan Rekening
    $('.btn-add-rekening').click(function() {
        resetModalForm();
        $('#modal-rekening').modal('show');
    });

    // Edit
    async function loadOptions(url, selectElement) {
        try {
            const response = await $.get(url);
            let options = '<option value="">Pilih</option>';
            $.each(response, function(index, item) {
                options += `<option value="${item.id}">${item.name}</option>`;
            });
            selectElement.html(options);
        } catch (error) {
            console.error('Error loading options:', error);
        }
    }

    // Edit
    $(document).on('click', '.edit-rekening', async function() {
        const id = $(this).data('id');
        try {
            const data = await $.get("{{ url('pembukaan-rekening') }}/" + id + "/edit");
            
            resetModalForm();
            $('#modal-title').text('Edit Pembukaan Rekening');
            $('#rekening-id').val(data.id);
            $('#rekening-nama').val(data.nama);
            $('#rekening-tempat-lahir').val(data.tempat_lahir);
            $('#rekening-tanggal-lahir').val(data.tanggal_lahir);
            $('#rekening-jenis-kelamin').val(data.jenis_kelamin);
            $('#rekening-pekerjaan').val(data.pekerjaan_id);
            $('#rekening-nama-jalan').val(data.nama_jalan);
            $('#rekening-rt').val(data.rt);
            $('#rekening-rw').val(data.rw);
            $('#rekening-nominal-setor').val(data.nominal_setor);

            await loadOptions("{{ route('api.provinsi') }}", $('#rekening-provinsi'));
            $('#rekening-provinsi').val(data.provinsi).trigger('change');

            await loadOptions("{{ url('api/location/kota') }}/" + data.provinsi, $('#rekening-kabupaten'));
            $('#rekening-kabupaten').val(data.kabupaten_kota).trigger('change');

            await loadOptions("{{ url('api/location/kecamatan') }}/" + data.kabupaten_kota, $('#rekening-kecamatan'));
            $('#rekening-kecamatan').val(data.kecamatan).trigger('change');

            await loadOptions("{{ url('api/location/kelurahan') }}/" + data.kecamatan, $('#rekening-kelurahan'));
            $('#rekening-kelurahan').val(data.kelurahan);

            $('#modal-rekening').modal('show');
        } catch (error) {
            console.error('Error loading rekening data:', error);
            Swal.fire('Error!', 'Terjadi kesalahan saat memuat data rekening.', 'error');
        }
    });

    $('#form-rekening').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var rekeningId = $('#rekening-id').val();
        var url = rekeningId ? "{{ url('pembukaan-rekening') }}/" + rekeningId : "{{ route('pembukaan-rekening.store') }}";
        
        if (rekeningId) {
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#modal-rekening').modal('hide');
                table.ajax.reload();
                Swal.fire('Berhasil!', 'Data pembukaan rekening telah ' + (rekeningId ? 'diperbarui.' : 'ditambahkan.'), 'success');
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
                    Swal.fire('Error!', 'Terjadi kesalahan saat memproses data pembukaan rekening.', 'error');
                }
            }
        });
    });

    // Delete Pembukaan Rekening
    $(document).on('click', '.delete-rekening', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Pembukaan Rekening',
            text: 'Apakah Anda yakin ingin menghapus pembukaan rekening ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('pembukaan-rekening') }}/" + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire('Berhasil!', 'Pembukaan rekening telah dihapus.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus pembukaan rekening.', 'error');
                    }
                });
            }
        });
    });

    // Approval
    var approvalId;
    $(document).on('click', '.approve-rekening', function() {
        approvalId = $(this).data('id');
        $('#modal-approval').modal('show');
    });

    $('#confirm-approval').click(function() {
        $.ajax({
            url: "{{ url('pembukaan-rekening') }}/" + approvalId + "/approve",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#modal-approval').modal('hide');
                table.ajax.reload();
                Swal.fire('Berhasil!', 'Pembukaan rekening telah disetujui.', 'success');
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Terjadi kesalahan saat menyetujui pembukaan rekening.', 'error');
            }
        });
    });

    function resetModalForm() {
        $('#form-rekening')[0].reset();
        $('#rekening-id').val('');
        $('#modal-title').text('Pembukaan Rekening Baru');
        $('#validation-errors').html('').hide();
    }

    // Load provinsi
    $.get("{{ route('api.provinsi') }}", function(data) {
        var options = '<option value="">Pilih Provinsi</option>';
        $.each(data, function(index, item) {
            options += '<option value="' + item.id + '">' + item.name + '</option>';
        });
        $('#rekening-provinsi').html(options);
    });

    // Load kabupaten
    $('#rekening-provinsi').change(function() {
        var provinsiId = $(this).val();
        if(provinsiId) {
            $.get("{{ url('api/location/kota') }}/" + provinsiId, function(data) {
                var options = '<option value="">Pilih Kabupaten/Kota</option>';
                $.each(data, function(index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#rekening-kabupaten').html(options);
            });
        } else {
            $('#rekening-kabupaten').html('<option value="">Pilih Kabupaten/Kota</option>');
        }
    });

    // Load kecamatan
    $('#rekening-kabupaten').change(function() {
        var kabupatenId = $(this).val();
        if(kabupatenId) {
            $.get("{{ url('api/location/kecamatan') }}/" + kabupatenId, function(data) {
                var options = '<option value="">Pilih Kecamatan</option>';
                $.each(data, function(index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#rekening-kecamatan').html(options);
            });
        } else {
            $('#rekening-kecamatan').html('<option value="">Pilih Kecamatan</option>');
        }
    });

    // Load kelurahan
    $('#rekening-kecamatan').change(function() {
        var kecamatanId = $(this).val();
        if(kecamatanId) {
            $.get("{{ url('api/location/kelurahan') }}/" + kecamatanId, function(data) {
                var options = '<option value="">Pilih Kelurahan</option>';
                $.each(data, function(index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#rekening-kelurahan').html(options);
            });
        } else {
            $('#rekening-kelurahan').html('<option value="">Pilih Kelurahan</option>');
        }
    });
});
</script>
@endsection