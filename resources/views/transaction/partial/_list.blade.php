@foreach ($transactions as $trx)
    <li class="list-group-item mb-2 rounded border-light shadow-sm">
        <div class="d-flex justify-content-between">
            <div>
                <strong>
                    @php
                        $prefix = Request::segment(1);
                    @endphp
                    @if ($prefix == 'customer')
                        {{ $trx->operation == 'plus' ? '⬆️ Top-up' : '⬇️ Pembayaran' }}
                    @else
                        {{ $trx->operation == 'plus' ? '⬆️ Penerimaan' : '⬇️ Penarikan' }}
                    @endif
                </strong><br>
                <small class="text-muted">{{ $trx->created_at->format('d M Y H:i') }}</small>
            </div>
            <div class="text-end">
                <span class="fw-bold {{ $trx->operation == 'plus' ? 'text-success' : 'text-danger' }}">
                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                </span><br>
                <span class="badge bg-{{ $trx->status == 'completed' ? 'success' : ($trx->status == 'pending' ? 'warning text-dark' : 'danger') }}">
                    {{ ucfirst($trx->status) }}
                </span>
            </div>
        </div>

        @if ($trx->description)
            <p class="mt-2 mb-0 small text-muted">{{ $trx->description }}</p>
        @endif

        @if ($trx->proof_url)
            <a href="{{ $trx->proof_url }}" target="_blank" class="d-block mt-2 small text-primary">
                🔗 Lihat Bukti Dukung
            </a>
        @endif
    </li>
@endforeach
