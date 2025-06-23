@extends('dashboard.layouts.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="withdrawTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Metode</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $trx)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $trx->ewallet->user->name }}<br>
                                <small>{{ $trx->ewallet->user->email }}</small>
                            </td>
                            <td>{{ ucfirst($trx->method) }}</td>
                            <td>
                                <span class="text-danger">
                                    -Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $trx->status == 'completed' ? 'success' : ($trx->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            <td>{{ date_format($trx->created_at, 'd M Y H:i') }}</td>
                            <td>
                                @if ($trx->status == 'pending')
                                    <form method="POST" action="{{ route('admin.ewallet.withdraw.verify', $trx->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="action" value="approve" class="btn btn-sm btn-success">Approve</button>
                                        <button type="submit" name="action" value="reject" class="btn btn-sm btn-danger">Reject</button>
                                    </form>
                                @else
                                    <em>-</em>
                                @endif
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
    <script>
        $(function() {
            $('#withdrawTable').DataTable({
                responsive: true,
                autoWidth: false,
            });
        });
    </script>
@endpush
