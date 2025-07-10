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


                @if (Request::segment(1) == 'customer')
                    <span class="badge border rounded text-dark font-weight-bold" style=" border-bottom-color: {{ $trip->color }} !important; border-bottom-width: 3px !important; font-size: 0.5rem;">
                        <i class="fas fa-shuttle-van me-1" style="font-size: 0.7rem;"></i>
                        {{ $trip->route_number }}
                    </span>
                    <span class="badge badge-dark font-weight-bold">{{ $trip->license_plate }}</span>
                @else
                    <strong class="text-dark" style="font-size: 0.7rem;">{{ $trip->user->name }} </strong>
                @endif
            </div>
            @php
                $locgetonparts = explode(',', $trip->geton_location);
                $sliceon = array_slice($locgetonparts, 0, 2);
                $getonAddress = implode(',', $sliceon);

                $locgetoffparts = explode(',', $trip->getoff_location);
                $sliceoff = array_slice($locgetoffparts, 0, 2);
                $getoffAddress = implode(',', $sliceoff);
            @endphp
            {{-- <strong class="text-dark d-block d-sm-none">{{ $getonAddress ?? '-' }}</strong> --}}
            {{-- <strong class="text-dark d-none d-xs-none d-sm-block d-md-none d-lg-none">{{ $formattedLocation ?? '-' }}</strong> --}}
            {{-- <strong class="text-dark d-none d-xs-none d-sm-none d-md-block d-lg-block">{{ $trip->getoff_location ?? '-' }}</strong> --}}
            {{-- <strong class="text-dark">{{ $trip->user->name }} </strong><br>
                                                naik di <br>
                                                <strong class="text-dark">{{ $getonAddress ?? 'n/a' }}</strong> <br>
                                                turun di <br>
                                                <strong class="text-dark"> {{ $getoffAddress ?? 'n/a' }} </strong>
                                                <br> --}}

            <div class="d-flex align-items-center" style="font-size: 0.7rem;">

                <img src="http://res.cloudinary.com/dezj1x6xp/image/upload/v1750247146/PandanViewMandeh/panelarah_angkotapp_k37dlt.jpg" alt="Foto Kendaraan" class="img-circle elevation-2 me-4" width="15" style="object-fit: cover;">

                <div class="ps-1 px-1" style="line-height: 1">
                    <small class="text-dark">Naik dari</small><br>
                    @php
                        $locationParts = explode(',', $trip->geton_location);
                        $firstTwo = array_slice($locationParts, 0, 2);
                        $formattedLocation = implode(',', $firstTwo);
                    @endphp
                    <strong class="text-dark">{{ $formattedLocation ?? '-' }}</strong>

                    <div class="ms-2 mb-1" style="height: 11px; border-left: 2px #ccc;"></div>

                    <small class="text-dark">Turun di - {{ $trip->distance ?? 'n/a' }} km</small><br>
                    @php
                        if ($trip->getoff_location) {
                            $locationParts2 = explode(',', $trip->getoff_location);
                            $firstTwo2 = array_slice($locationParts2, 0, 2);
                            $formattedLocation2 = implode(',', $firstTwo2);
                        } else {
                            $formattedLocation2 = 'On Going';
                        }
                    @endphp
                    <strong class="text-dark">{{ $formattedLocation2 }}</strong>
                </div>
            </div>



            @if ($trip->status == 'completed')
                <div class="pt-2" style="font-size: 0.7rem">
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
