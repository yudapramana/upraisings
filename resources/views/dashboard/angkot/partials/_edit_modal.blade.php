<!-- Modal Edit -->
<div class="modal fade" id="modal-edit-{{ $row->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data Angkot - {{ $row->nama_lengkap }}</h4>
            </div>
            <form method="POST" action="{{ route('angkot.update', $row->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">

                    {{-- Data Pengemudi --}}
                    <div class="form-group"><label>Nama Lengkap</label>
                        <input name="nama_lengkap" type="text" class="form-control" required value="{{ old('name', $row->name) }}">
                    </div>

                    <div class="form-group"><label>Nomor HP aktif</label>
                        <input name="mobile_phone" type="text" class="form-control" required value="{{ old('mobile_phone', $row->mobile_phone) }}">
                    </div>

                    <div class="form-group"><label>Email</label>
                        <input name="email" type="email" class="form-control" required value="{{ old('email', $row->email) }}">
                    </div>

                    <div class="form-group"><label>Kota Tempat Mendaftar</label>
                        <select name="city_register" class="custom-select" required>
                            <option value="">-Pilih Kab/Kota-</option>
                            @foreach ($cities as $code => $name)
                                <option value="{{ $code }}" {{ old('city_register', $row->city_register) == $code ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jangan edit password di edit form, bisa dikosongkan atau ditambah toggle jika diperlukan --}}

                    <hr>
                    {{-- Rekening --}}
                    <h5>Informasi Rekening Bank</h5>

                    <div class="form-group"><label>Nama Bank</label>
                        <select name="bank_name" class="custom-select" required>
                            <option value="">- Pilih Bank -</option>
                            @foreach (['BCA', 'BNI', 'BRI', 'Mandiri', 'BSI', 'CIMB Niaga', 'Permata', 'Danamon', 'BTN', 'BTPN', 'Maybank', 'OCBC NISP', 'Bank Mega', 'Bank Jago'] as $bn)
                                <option value="{{ $bn }}" {{ old('bank_name', $row->bank_name) == $bn ? 'selected' : '' }}>{{ $bn }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group"><label>Nomor Rekening / e-Wallet</label>
                        <input name="account_number" class="form-control" value="{{ old('account_number', $row->account_number) }}">
                    </div>

                    <div class="form-group"><label>Nama Pemilik Rekening</label>
                        <input name="account_holder" class="form-control" value="{{ old('account_holder', $row->account_holder) }}">
                    </div>

                    <hr>
                    {{-- Data Kendaraan --}}
                    <h5>Informasi Kendaraan</h5>

                    <div class="form-group"><label>Jenis/Trayek Angkot</label>
                        <select name="angkot_type_id" class="custom-select" required>
                            <option value="">-Pilih Trayek-</option>
                            @foreach ($angkotTypes as $angkot)
                                <option value="{{ $angkot->id }}" {{ old('angkot_type_id', $row->vehicle->angkot_type_id ?? '-') == $angkot->id ? 'selected' : '' }}>
                                    {{ $angkot->vehicle->route_number ?? 'n/a' }} - {{ $angkot->vehicle->route_name ?? 'n/a' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group"><label>Plat Nomor Kendaraan</label>
                        <input name="license_plate" class="form-control" value="{{ old('license_plate', $row->vehicle->license_plate ?? 'n/a') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Foto Angkot</label><br>
                        <button type="button" class="btn btn-outline-primary upload-widget-btn" data-input-id="vehicle_photo_edit_{{ $row->id }}" data-preview-id="preview_edit_{{ $row->id }}">Upload Foto</button>
                        <input type="hidden" id="vehicle_photo_edit_{{ $row->id }}" name="vehicle_photo" value="{{ old('vehicle_photo', $row->vehicle->vehicle_photo ?? '-') }}">
                        <div id="preview_edit_{{ $row->id }}" class="mt-2">
                            @if (isset($row->vehicle))
                                <img src="{{ $row->vehicle->vehicle_photo }}" style="max-height: 150px;" class="img-fluid rounded border">
                            @endif
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
