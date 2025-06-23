<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Formulir Pendaftaran Angkot</h4>
            </div>
            <form method="POST" action="{{ route('angkot.store') }}" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input name="nama_lengkap" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor HP</label>
                        <input name="mobile_phone" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" type="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kota</label>
                        <select name="city_register" class="custom-select" required>
                            <option value="">-Pilih-</option>
                            <!-- Daftar kabupaten/kota -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input name="password" type="password" class="form-control" required>
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
