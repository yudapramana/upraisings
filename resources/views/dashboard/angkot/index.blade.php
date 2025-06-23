@extends('dashboard.layouts.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        table#datatable td,
        table#datatable th {
            font-size: 0.85rem;
            padding: 0.4rem 0.5rem !important;
            vertical-align: middle;
        }
    </style>
@endpush

@section('buttonHeader')
    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-create">
        <i class="fas fa-plus"></i> Tambah Angkot
    </button>

    <!-- Create Modal -->
    <div class="modal fade" id="modal-create">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Formulir Pendaftaran Angkot</h4>
                </div>
                <form method="POST" action="{{ route('angkot.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        {{-- Tampilkan error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Data Pengemudi --}}
                        <div class="form-group"><label>Nama Lengkap</label><input name="nama_lengkap" type="text" class="form-control" required value="{{ old('nama_lengkap') }}"></div>
                        <div class="form-group"><label>Nomor HP aktif</label><input name="mobile_phone" type="text" class="form-control" required value="{{ old('mobile_phone') }}"></div>
                        <div class="form-group"><label>Email</label><input name="email" type="email" class="form-control" required value="{{ old('email') }}"></div>
                        <div class="form-group"><label>Kota Tempat Mendaftar</label>
                            <select name="city_register" class="custom-select" required>
                                <option value="">-Pilih Kab/Kota-</option>
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
                                @endphp
                                @foreach ($cities as $code => $name)
                                    <option value="{{ $code }}" {{ old('city_register') == $code ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"><label>Password</label><input name="password" type="password" class="form-control" required></div>

                        <hr>
                        {{-- Data Rekening --}}
                        <h5>Informasi Rekening Bank</h5>
                        <div class="form-group"><label>Nama Bank</label><select name="bank_name" class="custom-select" required>
                                <option value="">- Pilih Bank -</option>
                                @foreach (['BCA', 'BNI', 'BRI', 'Mandiri', 'BSI', 'CIMB Niaga', 'Permata', 'Danamon', 'BTN', 'BTPN', 'Maybank', 'OCBC NISP', 'Bank Mega', 'Bank Jago'] as $bn)
                                    <option {{ old('bank_name') == $bn ? 'selected' : '' }}>{{ $bn }}</option>
                                @endforeach
                            </select></div>
                        <div class="form-group"><label>Nomor Rekening / e-Wallet</label><input name="account_number" class="form-control" value="{{ old('account_number') }}"></div>
                        <div class="form-group"><label>Nama Pemilik Rekening</label><input name="account_holder" class="form-control" value="{{ old('account_holder') }}"></div>

                        <hr>
                        {{-- Data Kendaraan/Angkot --}}
                        <h5>Informasi Kendaraan</h5>
                        <div class="form-group"><label>Jenis/Trayek Angkot</label>
                            <select name="angkot_type_id" class="custom-select" required>
                                <option value="">-Pilih Trayek-</option>
                                @foreach ($angkotTypes as $row)
                                    <option value="{{ $row->id }}" {{ old('angkot_type_id') == $row->id ? 'selected' : '' }}>
                                        {{ $row->route_number }} - {{ $row->route_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"><label>Plat Nomor Kendaraan</label><input name="license_plate" class="form-control" required value="{{ old('license_plate') }}"></div>
                        <div class="form-group">
                            <label>Foto Angkot</label><br>
                            <button type="button" id="upload_widget" class="btn btn-outline-primary">Upload Foto</button>
                            <input type="hidden" name="vehicle_photo" id="vehicle_photo" value="{{ old('vehicle_photo') }}">
                            <div id="preview_image" class="mt-2">
                                @if (old('vehicle_photo'))
                                    <img src="{{ old('vehicle_photo') }}" style="max-height:150px;" class="img-fluid rounded">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="datatable" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Info Mitra</th>
                        <th>Kota</th>
                        <th>Trayek</th>
                        <th>Plat</th>
                        <th>Rekening</th>
                        <th>Foto</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($angkots as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>

                            {{-- Kolom gabungan Mitra --}}
                            <td>
                                <strong>{{ $row->name }}</strong><br>
                                <small>{{ $row->mobile_phone }}</small><br>
                                <small>{{ $row->email }}</small>
                            </td>

                            {{-- Kolom Kota --}}
                            <td>{{ $cities[$row->city_register] ?? '-' }}</td>

                            {{-- Kolom Trayek --}}
                            <td>
                                {{ $row->vehicle->angkotType->route_number ?? '' }} -
                                {{ $row->vehicle->angkotType->route_name ?? '' }}
                            </td>

                            {{-- Kolom Plat --}}
                            <td><span class="badge badge-dark">{{ $row->vehicle->license_plate ?? '-' }}</span></td>

                            {{-- Kolom Rekening --}}
                            <td>
                                <small>{{ $row->bank_name }}</small><br>
                                <small>{{ $row->account_number }}</small><br>
                                <small>{{ $row->account_holder }}</small>
                            </td>

                            {{-- Kolom Foto --}}
                            <td>
                                @if ($row->vehicle_photo)
                                    <img src="{{ $row->vehicle_photo }}" style="max-height:50px;" class="img-fluid rounded">
                                @else
                                    -
                                @endif
                            </td>

                            {{-- Created --}}
                            <td>{{ $row->created_at->format('d M Y') }}</td>

                            {{-- Action --}}
                            <td>
                                <button data-toggle="modal" data-target="#modal-edit-{{ $row->id }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $row->id }}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @include('dashboard.angkot.partials._edit_modal', ['row' => $row, 'cities' => $cities, 'angkotTypes' => $angkotTypes])
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        // DataTable & form validation
        $('#datatable').DataTable({
            // responsive: true,
            sort: false,
            scrollx: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
        $('.needs-validation').validate({
            rules: {
                nama_lengkap: {
                    required: true
                },
                mobile_phone: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                city_register: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                license_plate: {
                    required: true
                },
                angkot_type_id: {
                    required: true
                }
            },
            messages: {
                nama_lengkap: "Wajib diisi",
                mobile_phone: "Wajib diisi",
                email: "Email tidak valid",
                city_register: "Pilih kota",
                password: "Min 6 karakter",
                license_plate: "Wajib diisi",
                angkot_type_id: "Pilih trayek"
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback',
            highlight(el) {
                $(el).addClass('is-invalid')
            },
            unhighlight(el) {
                $(el).removeClass('is-invalid')
            }
        });

        // Hapus
        $('.btn-delete').click(function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Yakin ingin hapus?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya'
            }).then(res => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: `{{ url('dashboard/angkot/') }}/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success() {
                            Swal.fire('Dihapus!', '', 'success').then(() => location.reload())
                        },
                        error() {
                            Swal.fire('Gagal', '', 'error')
                        }
                    })
                }
            })
        });
    </script>
@endpush
