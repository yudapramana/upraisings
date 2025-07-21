@extends('auth.layouts.layout')

@section('content')
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login - Angkot App</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-block btn-primary">Sign In</button>
                        </div>
                    </div>

                    {{-- <p class="mb-1">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                I forgot my password
                            </a>
                        @endif
                    </p> --}}

                    <div class="mt-3">
                        <label class="d-block mb-2">Login Demo:</label>
                        <div class="d-flex justify-content-between flex-wrap gap-2">
                            <button type="button" class="btn btn-outline-info btn-sm mb-2" onclick="fillDemo('customer1')">User_1</button>
                            <button type="button" class="btn btn-outline-info btn-sm mb-2" onclick="fillDemo('customer2')">User_2</button>
                            <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="fillDemo('partner1')">Angkot_1</button>
                            <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="fillDemo('partner2')">Angkot_2</button>
                            <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="fillDemo('partner3')">Angkot_3</button>
                            <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="fillDemo('partner4')">Angkot_4</button>
                            <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="fillDemo('partner5')">Angkot_5</button>
                            <button type="button" class="btn btn-outline-warning btn-sm mb-2" onclick="fillDemo('approval')">Admin</button>
                            <button type="button" class="btn btn-outline-dark btn-sm mb-2" onclick="fillDemo('director')">Director</button>

                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ url('/') }}" class="btn btn-secondary btn-sm">
                            ← Kembali ke Halaman Utama
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection


<script>
    function fillDemo(role) {
        const emails = {
            customer1: 'tghoz@gmail.com',
            customer2: 'annsab@gmail.com',
            partner1: 'agusbunto@gmail.com',
            partner2: 'rina.marlina@example.com',
            partner3: 'dedi.surya@gmail.com',
            partner4: 'siti.nurjanah@gmail.com',
            partner5: 'taufik.hidayat@example.com',
            approval: 'admin@admin.com',
            director: 'director@angkot.com' // ✅ Tambahan
        };

        const passwords = {
            customer1: 'customer',
            customer2: 'customer',
            partner1: '12345678',
            partner2: 'rinamarlina',
            partner3: 'dedisurya',
            partner4: 'nurjanah2024',
            partner5: 'taufik123',
            approval: 'admin',
            director: 'director' // ✅ Tambahan
        };

        document.getElementById('email').value = emails[role];
        document.getElementById('password').value = passwords[role];
    }
</script>
