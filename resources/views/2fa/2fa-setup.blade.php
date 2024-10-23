@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify 2 FA') }}</div>

                <div class="card-body">
                    <form action="{{ route('2fa.verify') }}" method="POST">
                        @csrf
                        <p>Scan this QR code with your Google Authenticator app:</p>

                        {!! $QR_Image !!}

                        <p>Enter the code from your app:</p>
                        <input type="text" name="2fa_code" required>
                        <button type="submit">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
