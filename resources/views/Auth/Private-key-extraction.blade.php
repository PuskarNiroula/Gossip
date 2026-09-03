
@extends('Layouts.layout')

@section('title', 'Recovery Key')

@section('content')
    <div class="recovery-container">
        <div class="recovery-card">
            <h2>Recover Private Key</h2>
            <p>Enter your recovery key to extract your private key.</p>

            <form action="#" method="POST" id="recovery-key-form">
                @csrf

                <div class="form-group">
                    <label for="recovery_key">Enter your recovery key</label>
                    <input
                        type="password"
                        id="recovery_key"
                        name="recovery_key"
                        placeholder="Enter your recovery key"
                        required
                    >
                </div>

                <button type="submit" class="recovery-btn">
                    Recover Private Key
                </button>
            </form>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/recover.css">
@endsection

@section('scripts')
    <script src="/js/argon_config.js"></script>
    <script src="/js/argonencryption.js"></script>
    <script>
        document.getElementById('recovery-key-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const recoveryPassword = document.getElementById('recovery_key').value;

            try {
                const metaData = await secureFetch('/api/get-private-meta-data', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });


                if (metaData.status !== "success") {
                    throw new Error(metaData.message || 'Unable to get recovery data');
                }


                const privateKeyJwk = await extractPrivateKey(
                    recoveryPassword,
                    metaData
                );

                localStorage.setItem(`private_key_${metaData.userId}`, JSON.stringify(privateKeyJwk));
                window.location.href = '/dashboard';

            } catch (error) {
                console.error(error);
            }
        });

    </script>
@endsection

