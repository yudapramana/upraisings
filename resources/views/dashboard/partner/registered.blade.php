@extends('dashboard.layouts.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Informasi User</th>
                        <th>Kota Pendaftaran</th>
                        <th>Informasi Rekening</th>
                        <th>Status Verifikasi</th>
                        <th>Status Akun</th>
                        <th>Dibuat pada</th>
                        <th>Diupdate pada</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <strong>{{ $data->name }}</strong><br>
                                {{ $data->email }}<br>
                                {{ $data->mobile_phone }}
                            </td>
                            <td>
                                @php
                                    $cities = [
                                        '1309' => 'Kabupaten Kepulauan Mentawai',
                                        '1301' => 'Kabupaten Pesisir Selatan',
                                        '1302' => 'Kabupaten Solok',
                                        '1303' => 'Kabupaten Sijunjung',
                                        '1304' => 'Kabupaten Tanah Datar',
                                        '1305' => 'Kabupaten Padang Pariaman',
                                        '1306' => 'Kabupaten Agam',
                                        '1307' => 'Kabupaten Lima Puluh Kota',
                                        '1308' => 'Kabupaten Pasaman',
                                        '1311' => 'Kabupaten Solok Selatan',
                                        '1310' => 'Kabupaten Dharmas Raya',
                                        '1312' => 'Kabupaten Pasaman Barat',
                                        '1371' => 'Kota Padang',
                                        '1372' => 'Kota Solok',
                                        '1373' => 'Kota Sawah Lunto',
                                        '1374' => 'Kota Padang Panjang',
                                        '1375' => 'Kota Bukittinggi',
                                        '1376' => 'Kota Payakumbuh',
                                        '1377' => 'Kota Pariaman',
                                    ];
                                    echo $cities[$data->city_register] ?? '-';
                                @endphp
                            </td>
                            <td>
                                @if ($data->bank_name && $data->account_number && $data->account_holder)
                                    {{ $data->bank_name }} - {{ $data->account_number }} ({{ $data->account_holder }})
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($data->account_verification == 'pending')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif ($data->account_verification == 'verified')
                                    <span class="badge badge-success">Terverifikasi</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if ($data->account_status == 'active')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif ($data->account_status == 'inactive')
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @else
                                    <span class="badge badge-danger">Suspended</span>
                                @endif
                            </td>
                            <td>{{ date_format(date_create($data->created_at), 'd M Y H:i:s') }}</td>
                            <td>{{ date_format(date_create($data->updated_at), 'd M Y H:i:s') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-{{ $data->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <div class="modal fade" id="modal-{{ $data->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Verifikasi Akun - {{ $data->name }}</h4>
                                            </div>

                                            <form action="{{ route('partner-verification.update', $data->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Status Verifikasi :</label>
                                                        <select class="form-control" name="account_verification">
                                                            <option value="pending" {{ $data->account_verification == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                            <option value="verified" {{ $data->account_verification == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                                            <option value="rejected" {{ $data->account_verification == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Status Akun :</label>
                                                        <select class="form-control" name="account_status">
                                                            <option value="active" {{ $data->account_status == 'active' ? 'selected' : '' }}>Aktif</option>
                                                            <option value="inactive" {{ $data->account_status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                                            <option value="suspended" {{ $data->account_status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('/') }}plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/') }}plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false
            });

            $('.btn-delete').click(function() {
                Swal.fire({
                    title: 'Anda Yakin Ingin menghapus user ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).attr('data-id');

                        $.ajax({
                            type: 'DELETE',
                            url: "{{ url('/admin/partner-verification/delete/') }}/" + id,
                            data: {
                                '_token': '{{ csrf_token() }}',
                            },
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire('Terhapus!', 'User berhasil dihapus!', 'success').then(function() {
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('GAGAL!', 'Terjadi Kesalahan', 'error')
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
