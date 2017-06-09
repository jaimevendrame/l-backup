@extends('dashboard.templates.app')

@section('content')

    <div class="section">
        <div class="row">
            <div class="col s6">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Info</span>
                        <div class="row">
                            <div class="input-field col s12">
                                <input placeholder="Usuário" id="first_name" type="text" class="validate"  readonly value="{{ $usuario_lotec->idusu .' - '. $usuario_lotec->nomusu}}">
                                <label for="first_name">Usuário:</label>
                            </div>
                            <div class="input-field col s12">
                                <label class="active">Vendedor:</label>
                                <br>
                                <select class="browser-default blue-grey darken-1">
                                    @if ($vendedores->count())
                                        @foreach($vendedores as $vendedor)
                                            <option value="
                                            {{ $vendedor->idven  }}"
{{--                                                    {{ $selectedRole == $vendedor->idven ? 'selected="selected"' : '' }}--}}
                                            >
                                                {{ $vendedor->idven  }} - {{ $vendedor->nomven }}</option>

                                    @endforeach
                                           @endif
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s6">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Bases</span>
                        <table class="bordered highlight">
                            <thead>
                            <tr>
                                <th>Id Base</th>
                                <th>Nome Pro</th>
                                <th>Nome Base</th>
                                <th>Cidade/UF</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($user_bases as $base)
                            <tr>
                                <td>{{ $base->idbase }}</td>
                                <td>{{ $base->nompro }}</td>
                                <td>{{ $base->nombas }}</td>
                                <td>{{ $base->cidbas .'/'. $base->sigufs }}</td>
                            </tr>
                                @empty
                            <tr>
                                nenhum registro encontrado!
                            </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s6">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Bases</span>

                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection




