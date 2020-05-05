<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>

    body{
        background-color: rgb(239, 239, 239);
        font-family: 'Roboto', sans-serif !important;
    }
    .login-header{
        background-color: rgba(0,0,0,0);
        border-bottom: none;
        height: 50px;
    }
    input {
        outline: 0!important;
        border-width: 0 0 2px!important;
        border-color: blue!important;
    }
    input:focus {
        border-color: green!important;
    }

    .form-control{
        border-bottom: 1px solid #5a6268!important;
        border-radius: 0px;
    }

    .login-button{
        background-color: #ff6347;
        border-color: #ff6347;
    }

    .login-button:hover,.login-button:focus{
        background-color: #9c412c;
        border-color: #9c412c;
    }

</style>
<div class="text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mb-5" style="margin-top: 45%;">
                    <div class="card-header login-header">
                        <span style="background-color: #000000; height: 100px; width: 100px;position: absolute;border-radius: 100%;top: -40px;left: -50px; margin-left: 50%">
                            <img src="{{URL::asset('/public/img/werise_logo_white.svg')}}" alt="Logo" height="100" width="90">
                        </span>
                    </div>

                    <div class="card-body my-3">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <label for="email" class="col-md-10 col-form-label text-md-left" style="padding-left: 3px;padding-bottom: 0;">{{ __('E-Mail') }}</label>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-10">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Your e-mail">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <label for="password" class="col-md-10 col-form-label text-md-left" style="padding-left: 3px;padding-bottom: 0;">{{ __('Password') }}</label>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-10">
                                    <input id="password" placeholder="Your password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    @if (Route::has('password.request'))
                                        <a style="color: darkgreen" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row mt-2">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary login-button">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

