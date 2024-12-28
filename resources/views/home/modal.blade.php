<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Center modal vertically -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>

                <!-- Custom Close Button with Red "X" -->
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <!-- Login Form -->
                <!-- Tampilkan pesan error jika ada -->
                @if ($errors->has('loginError'))
                    <div class="alert alert-danger">
                        {{ $errors->first('loginError') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="usernameLogin" class="form-label">Email</label>
                        <input type="text" class="form-control" id="usernameLogin" name="username" required
                            value="{{ old('username') }}">
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="passwordLogin" class="form-label">Password</label>
                        <input type="password" class="form-control" id="passwordLogin" name="password" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary w-50">Login</button>
                    </div>

                </form>

                <!-- Toggle untuk form register (optional, jika dibutuhkan) -->


                <!-- Register Form (Initially Hidden) -->
                <form id="registerForm" method="POST" action="{{ route('register') }}" style="display: none;">
                    @csrf

                    <!-- Alert for validation errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="nameRegister" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nameRegister" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="usernameRegister" class="form-label">Username</label>
                        <input type="text" class="form-control" id="usernameRegister" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailRegister" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailRegister" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordRegister" class="form-label">Password</label>
                        <input type="password" class="form-control" id="passwordRegister" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPasswordRegister" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPasswordRegister" name="password2"
                            required>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary w-50">Register</button>
                    </div>
                </form>

                <div class="d-flex align-items-center">
                    <div class="form-check form-switch w-50 ">
                        <label class="form-check-label" for="switchMode" id="switch">Switch</label>
                        <input class="form-check-input" type="checkbox" id="switchMode" onclick="toggleMode()">
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <a href="{{ route('forget.password') }}">Forgot Password?</a>
                </div>

                <!-- Forgot Password Modal -->


            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Toggle Between Login and Register Forms -->
<script>
    function toggleMode() {
        const isRegisterMode = document.getElementById("switchMode").checked;
        const modalTitle = document.getElementById("loginModalLabel");
        const loginForm = document.getElementById("loginForm");
        const registerForm = document.getElementById("registerForm");
        const switchElement = document.getElementById("switch");

        if (isRegisterMode) {
            modalTitle.innerText = "Register";
            loginForm.style.display = "none";
            registerForm.style.display = "block";
            switchElement.innerText = "Register";
        } else {
            modalTitle.innerText = "Login";
            loginForm.style.display = "block";
            registerForm.style.display = "none";
            switchElement.innerText = "Login";
        }
    }
</script>

<style>
    /* Style for custom close button */
</style>
