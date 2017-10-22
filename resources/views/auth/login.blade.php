@extends('layouts.template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m6 l6  offset-m3  offset-l3">
            <div class="card z-depth-5">
                <div class="card-content">
                    <div class="row center-align">
                        <i class="large material-icons red-text lighten-2">cloud</i>
                        <p><h5 class="red-text">LOTECWEB</h5></p>
                    </div>
                    {{--<span class="card-title center-align">LOTECWeb</span>--}}
                    <div class="row">
                        <form class="col s12" role="form" method="POST" action="{{ env('URL_ADMIN_LOGIN') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">perm_identity</i>
                                        <input id="email" type="email" name="email" class="validate {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email">Email</label>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">lock</i>
                                        <input id="password" type="password" name="password" class="validate {{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password">Senha</label>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 ">
                                        <input type="checkbox" id="remember" {{ old('remember') ? 'checked' : ''}}/>
                                        <label for="remember">Lembre-me?</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 center">
                                        <button class="btn waves-effect waves-light col s12 z-depth-4 red lighten-2" type="submit" name="action">
                                            Entrar
                                        </button>
                                    </div>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{--<div class="card-action right-align">--}}
                    {{--<a href="{{ url('/password/reset') }}">Esqueceu a senha?</a>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</div>
@endsection
