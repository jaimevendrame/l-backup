@extends('dashboard.templates.app')

@section('content')
    <div class="section">
        <div class="row">
            <div class="col s12 m8 l6">
                <div class="card">

                    <div class="card-content blue-grey darken-2">
                        <span class="card-title center white-text"><b>Senha P/ Movimentar Caixa:</b></span>
                        <div class="card-action">
                            @if(!empty($data))
                                @forelse($data as $s)
                                        <h1 class="center-align white-text"><b>{{$s->baixa_caixa}}</b></h1>
                                    @empty
                                @endforelse
                            @else
                                <p class="white-text">Usuário Administrador</p>
                            @endif
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection





