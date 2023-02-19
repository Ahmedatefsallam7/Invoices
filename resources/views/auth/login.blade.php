@extends('layouts.master2')

@section('title')
    تسجيل دخول - برنامج الفواتير
@stop

<style>
    .card-sigin {
        margin: auto;
        width: 30%;
        padding: 15px;
        padding-top: 20px;
        background-color: rgb(224, 231, 249);
        border: 1px;
        border-radius: 8px;
    }
</style>

@section('content')
    <div class="card-sigin">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">

                <label>البريد الالكتروني</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label>كلمة المرور</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="form-check-label" for="remember">
                                {{ __('تذكرني') }}
                            </label>
                        </div>
                    </div>
                </div>
                <p>اذ لم تقم بالتسجيل من قبل اضغط هنا <u style="color: blue"><a href="{{ route('register') }}">تسجيل
                        </a></u></p>
            </div>

           

            <button type="submit" class="btn btn-main-primary btn-block">
                {{ __('تسجيل الدخول') }}
            </button>
        </form>
    </div>
@endsection
