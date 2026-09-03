@extends('Layouts.layout')

@section('title', 'Recovery Key')

@section('content')
    <div class="recovery-page">
        <div class="recovery-card">

            <div class="recovery-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>

            <h3 class="recovery-title">Recovery Key</h3>

            <p class="recovery-subtitle">
                Create a recovery password to securely recover your encrypted conversations.
            </p>

            <form id="recoveryForm" method="POST" action="{{ route('save-private-key') }}">

                <div class="password-group">
                    <label for="recovery_password">Enter recovery password</label>

                    <div class="password-input">
                        <i class="bi bi-key"></i>

                        <input
                            type="password"
                            id="recovery_password"
                            name="recovery_password"
                            class="form-control"
                            placeholder="Enter recovery password"
                            required
                        >

                        <button type="button" class="toggle-password" data-target="recovery_password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="password-group">
                    <label for="recovery_password_confirmation">Confirm recovery password</label>

                    <div class="password-input">
                        <i class="bi bi-key-fill"></i>

                        <input
                            type="password"
                            id="recovery_password_confirmation"
                            name="recovery_password_confirmation"
                            class="form-control"
                            placeholder="Confirm recovery password"
                            required
                        >

                        <button type="button" class="toggle-password" data-target="recovery_password_confirmation">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="password-group">
                    <label for="account_password">Enter your account's password</label>

                    <div class="password-input">
                        <i class="bi bi-person-lock"></i>

                        <input
                            type="password"
                            id="account_password"
                            name="account_password"
                            class="form-control"
                            placeholder="Enter account password"
                            required
                        >

                        <button type="button" class="toggle-password" data-target="account_password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="security-note">
                    <i class="bi bi-info-circle-fill"></i>

                    <span>
                    Your recovery password is used to protect access to your encrypted data.
                    Keep it somewhere safe.
                </span>
                </div>

                <button type="submit" class="recovery-btn">
                    <i class="bi bi-shield-check"></i>
                    Set Recovery Password
                </button>
            </form>

        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/recovery.css"/>
@endsection

@section('scripts')
    <script src="/js/argonencryption.js"></script>
    <script src="/js/argon_config.js"></script>
    <script>

        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const input = document.getElementById(this.dataset.target);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });

        const recoveryForm = document.getElementById('recoveryForm');

        recoveryForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const recoveryPassword = document.getElementById('recovery_password').value;
            const recoveryPasswordConfirmation = document.getElementById('recovery_password_confirmation').value;
            const accountPassword = document.getElementById('account_password').value;

            if (recoveryPassword !== recoveryPasswordConfirmation) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Recovery password and confirmation password do not match.',
                    confirmButtonColor: '#128c7e'
                });
                return;
            }

            if (!accountPassword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Account Password Required',
                    text: 'Please enter your account password.',
                    confirmButtonColor: '#128c7e'
                });
                return;
            }

            const button = recoveryForm.querySelector('.recovery-btn');
            const originalButtonContent = button.innerHTML;

            button.disabled = true;
            button.innerHTML = '<i class="bi bi-hourglass-split"></i> Verifying...';

            try {

                const data = await secureFetch('/api/verify-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        password: accountPassword
                    })
                });


                if (data.status === "success") {
                    const privateKeyJwk = JSON.parse(localStorage.getItem(`private_key_${data.userId}`));
                    const encryptedData = await encryptPrivateKey(privateKeyJwk, recoveryPassword);
                    const saveResponse = await secureFetch('/api/save-private-key', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                        body: JSON.stringify({
                            salt: encryptedData.salt,
                            iv: encryptedData.iv,
                            ciphertext: encryptedData.ciphertext
                        })
                    });

                    Swal.fire({
                        text:saveResponse.message||'Recovery password set successfully!',
                    })

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Verification Failed',
                        text: data.message || 'Unable to verify account password.',
                        confirmButtonColor: '#128c7e'
                    });
                }
            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Something Went Wrong',
                    text: 'Unable to verify your account password. Please try again.',
                    confirmButtonColor: '#128c7e'
                });
            } finally {
                button.disabled = false;
                button.innerHTML = originalButtonContent;
            }
        });
    </script>
@endsection
