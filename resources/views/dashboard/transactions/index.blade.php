@extends('dashboard.layouts.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">{{ $titlePages }}</h4>

        <!-- Ringkasan -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h4 id="totalFare">Rp 0</h4>
                        <p>Total Pendapatan</p>
                    </div>
                    <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h4 id="totalTrip">0</h4>
                        <p>Total Trip Selesai</p>
                    </div>
                    <div class="icon"><i class="fas fa-route"></i></div>
                </div>
            </div>
        </div>

        <!-- Tabel -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped" id="tripTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Nama Penumpang</th>
                            <th>No. Trayek</th>
                            <th>No. Polisi</th>
                            <th>Naik</th>
                            <th>Turun</th>
                            <th>Jarak (km)</th>
                            <th>Tarif (Rp)</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('/') }}plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/') }}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/') }}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('/') }}plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('/') }}plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('/') }}plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('/') }}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('/') }}plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('/') }}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script>
        $(function() {
            let table = $('#tripTable').DataTable({
                processing: true,
                autoWidth: false,
                responsive: true,
                serverSide: false,
                searching: true,
                paging: true,
                info: true,
                lengthChange: false,
                pageLength: 100,
                order: false,
                sort: false,
                dom: "<'row'<'col-md-6'B><'col-md-6'f>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                buttons: [
                    'copy', 'excel',
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'Laporan Pembayaran Mahasiswa',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'print', 'colvis'
                ],
                ajax: {
                    url: '{{ route('admin.transactions.index') }}',
                    type: 'GET',
                    dataSrc: function(json) {
                        $('#totalFare').text('Rp ' + parseFloat(json.summary.total_fare).toLocaleString('id-ID'));
                        $('#totalTrip').text(json.summary.total_trip);
                        return json.data;
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }, // tanggal trip
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'route_number',
                        name: 'route_number'
                    },
                    {
                        data: 'license_plate',
                        name: 'license_plate'
                    },
                    {
                        data: 'geton_short',
                        name: 'geton_short',
                        title: 'Naik Dari'
                    },
                    {
                        data: 'getoff_short',
                        name: 'getoff_short',
                        title: 'Turun Di'
                    },
                    {
                        data: 'distance',
                        name: 'distance',
                        className: 'text-center'
                    },
                    {
                        data: 'trip_fare',
                        name: 'trip_fare',
                        className: 'text-right'
                    }
                ]
            });
        });
    </script>
@endpush
