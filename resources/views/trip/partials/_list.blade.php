@foreach ($trips as $key => $trip)
    <div class="item{{ $key + 1 }} px-2 d-flex justify-content-between align-items-center">
        <span style="display: inline-grid; text-align: center;">
            <span class="text-muted" style="font-size: 0.75rem;">
                {{ $trip->created_at->format('d M, H:i') }}
            </span>
            <img src="http://res.cloudinary.com/dezj1x6xp/image/upload/v1750262180/PandanViewMandeh/angkotmax_pkwogi.jpg" alt="Foto Kendaraan" class="img-circle elevation-2 mt-1" width="89" style="object-fit: cover;">
        </span>

        <div class="pl-3 pt-2 flex-grow-1">
            <div>
                <span class="badge border rounded text-dark font-weight-bold" style="border-bottom-color: {{ $trip->color }} !important; border-bottom-width: 3px !important; font-size: 0.5rem;">
                    <i class="fas fa-shuttle-van me-1" style="font-size: 0.7rem;"></i>
                    {{ $trip->route_number }}
                </span>
            </div>
            @php
                $locationParts = explode(',', $trip->getoff_location);
                $firstTwo = array_slice($locationParts, 0, 3);
                $formattedLocation = implode(',', $firstTwo);
            @endphp
            <strong class="text-dark d-block">{{ $formattedLocation ?? '-' }}</strong>

            @if ($trip->status == 'completed')
                <div class="pt-3">
                    <i class="fas fa-check-circle text-success me-1"></i> Trip Completed
                </div>
            @else
                <span class="badge bg-secondary mt-1 text-uppercase">
                    {{ ucfirst($trip->status) }}
                </span>
            @endif
        </div>

        <div style="display: inline-grid; text-align: center;">
            <div class="fw-bold mb-1">Rp{{ number_format($trip->trip_fare, 2, ',', '.') }}</div>
            <a href="{{ route('trip.show.' . Request::segment(1), $trip->id) }}" class="badge badge-success text-white px-2 py-1 mt-5">
                Detail
            </a>
        </div>
    </div>
@endforeach
