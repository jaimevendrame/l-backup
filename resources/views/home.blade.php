@extends('dashboard.templates.app')

@section('content')



    @php
    $ideven = 0;
    @endphp

    <div class="section">
        <div class="row">
            <div class="col s8">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Info</span>
                        <div class="row">
                            <div class="input-field col s12">
                                <input placeholder="Usuário" id="first_name" type="text" class="validate"  readonly value="{{ $usuario_lotec->idusu .' - '. $usuario_lotec->nomusu}}">
                                <label for="first_name">Usuário:</label>
                            </div>
                            <form id="form-cad-edit" method="post" action="/admin/home/data" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="input-field col s12">
                                    <label class="active">Vendedor:</label>
                                    <br>
                                    <select class="browser-default blue-grey darken-1" onchange="test(this)" name="select_ideven">
                                        <option value="" disabled="disabledls
">Selecione uma base</option>
                                        @if ($vendedores->count())
                                            @foreach($vendedores as $vendedor)
                                                <option value="{{ $vendedor->ideven  }}" {{ $vendedor->ideven == $ideven_default  ? 'selected' : '' }}>
                                                    Base: {{ $vendedor->idbase}} Vendedor: {{ $vendedor->idven  }} - {{ $vendedor->nomven }} Cidade: {{ $vendedor->cidbas }}

                                                </option>

                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                                <div class="input-field col s12">
                                    <button class="btn btn-block right">salvar</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
{{--
            @if(session()->has('ideven'))

                <tr>
                    <td>{{ session()->get('ideven') }}</td>

                </tr>
            @endif
--}}
            <div class="col s4">
                {{--<div class="card blue-grey darken-1">--}}
                    {{--<div class="card-content white-text">--}}
                        {{--<span class="card-title">Bases</span>--}}
                        {{--<table class="bordered highlight">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th>Id Base</th>--}}
                                {{--<th>Nome Pro</th>--}}
                                {{--<th>Nome Base</th>--}}
                                {{--<th>Cidade/UF</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}

                            {{--<tbody>--}}
                            {{--@forelse($user_bases as $base)--}}
                            {{--<tr>--}}
                                {{--<td>{{ $base->idbase }}</td>--}}
                                {{--<td>{{ $base->nompro }}</td>--}}
                                {{--<td>{{ $base->nombas }}</td>--}}
                                {{--<td>{{ $base->cidbas .'/'. $base->sigufs }}</td>--}}
                            {{--</tr>--}}
                                {{--@empty--}}
                            {{--<tr>--}}
                                {{--nenhum registro encontrado!--}}
                            {{--</tr>--}}
                                {{--@endforelse--}}

                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}

                {{--</div>--}}
            </div>
        </div>

        <div class="row">
            {{--<div class="col s6">--}}
                {{--<div class="card blue-grey darken-1">--}}
                    {{--<div class="card-content white-text">--}}
                        {{--<span class="card-title">Bases</span>--}}

                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}

        </div>

    </div>

@endsection




