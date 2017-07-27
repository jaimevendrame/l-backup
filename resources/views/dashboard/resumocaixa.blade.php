@extends('dashboard.templates.app')

@section('content')

    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <form class="form-group" id="form-cad-edit" method="post" action="/admin/resumocaixa" enctype="multipart/form-data">
                            {{ csrf_field() }}



                            <div class="row">
                                <div class="input-field col s6 m2">
                                   <input id="datIni" name="datIni" type="date" class="datepicker"
                                                   placeholder =@php  echo "De:".'&nbsp;'.date("d/m/Y") @endphp >

                                </div>
                                <div class="input-field col s6 m2">
                                     <input id="datFim" name="datFim" type="date" class="datepicker"
                                             placeholder = @php echo "à:".'&nbsp;'.date("d/m/Y") @endphp>
                                </div>

                                <div class="input-field col s12 m4">
                                    <select multiple name="sel_vendedor[]">
                                        <option value="" disabled selected>Selecionar Vendedores</option>
                                        @forelse($baseAll as $bases)
                                        <option value="{{$bases->ideven}}"{{ $bases->inpadrao == 'SIM'  ? 'selected' : '' }}>{{$bases->ideven}}-{{$bases->nomven}}{{--{{$bases->ideven}}-{{$bases->nomven}}-{{$bases->cidven}}-{{$bases->sigufs}}--}}</option>
                                        @empty
                                            <option value="" disabled selected>Nenhuma base</option>
                                        @endforelse

                                    </select>
                                    <label>Bases selecionadas</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <select multiple>
                                        <option value="" disabled selected>Opções</option>
                                        <option value="1">Com Despesas</option>
                                        <option value="2">Mostrar Inativos</option>
                                    </select>
                                    <label>Opções</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">Atualizar
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>


                                {{--<div class="input-field col s2">--}}
                                    {{--<a class="waves-effect waves-light btn blue-grey"><i class="material-icons left">print</i></a>--}}
                                {{--</div>--}}
                            </div>

                            {{--<div class="row">--}}
                                {{--<div class="input-field col s2">--}}
                                    {{--<input type="checkbox" id="despesas"  name="despesas" value="SIM"/>--}}
                                    {{--<label for="despesas">Com Despesas</label>--}}
                                {{--</div>--}}
                                {{--<div class="input-field col s2">--}}
                                    {{--<input type="checkbox" id="in_ativos" name="in_ativos" value="SIM"/>--}}
                                    {{--<label for="in_ativos">Mostrar Inativos</label>--}}
                                {{--</div>--}}

                            {{--</div>--}}

                        </form>


                        <table class="mdl-data-table " id="example"  cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Revendedor</th>
                                <th>Saldo Anterior</th>
                                <th>Vendido</th>
                                <th>Comissão</th>
                                <th>Liquido</th>
                                <th>Prêmio</th>
                                <th>Despesas</th>
                                <th>Lucro</th>
                                <th>Pagamento</th>
                                <th>Recebimento</th>
                                <th>Última Venda</th>
                                <th>Saldo Atual</th>

                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Revendedor</th>
                                <th>Saldo Anterior</th>
                                <th>Vendido</th>
                                <th>Comissão</th>
                                <th>Liquido</th>
                                <th>Prêmio</th>
                                <th>Despesas</th>
                                <th>Lucro</th>
                                <th>Pagamento</th>
                                <th>Recebimento</th>
                                <th>Última Venda</th>
                                <th>Saldo Atual</th>

                            </tr>
                            </tfoot>
                            <tbody>
                            @forelse($data as $resumo)
                                <tr>
                                    <td>{{ $resumo->nomreven }}</td>
                                    <td
                                    @if ($resumo->vlrdevant < 0)
                                    bgcolor='RED' @elseif ($resumo->vlrdevant > 0) bgcolor='GREEN'
                                    @else @endif >
                                    {{ number_format($resumo->vlrdevant, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrven, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrcom, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrliqbru, 2, ',', '.') }}</td>
                                    <td>@if($resumo->vlrpremio > 0)<a href="#{{$resumo->vlrdevant}}" class="btn">@endif{{ number_format($resumo->vlrpremio, 2, ',', '.') }}</a></td>
                                    @if($resumo->vlrpremio > 0)
                                    <!-- Modal Structure -->
                                    <div id="{{$resumo->vlrdevant}}" class="modal">
                                        <div class="modal-content">
                                            <div class="modal-footer">
                                                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat"><i class="material-icons">close</i></a>
                                            </div>
                                            <h4>Aposta Premiada</h4>
                                            <p>
                                            <div class="video-container">
                                                <iframe width="700" height="315" src="http://192.168.10.10:8000/admin/resumocaixa/aposta_premiada/{{$resumo->idven}}/{{$resumo->idbase}}/{{$resumo->idreven}}/{{Carbon\Carbon::parse($resumo->dataini)->format('Y-m-d')}}/{{Carbon\Carbon::parse($resumo->datafim)->format('Y-m-d')}}" frameborder="0" allowfullscreen></iframe></div>
                                            </p>

                                        </div>

                                    </div>
                                    @endif
                                    <td>{{ number_format($resumo->despesas, 2, ',', '.') }}</td>
                                    <td>{{ number_format(($resumo->vlrliqbru - $resumo->vlrliqbru - $resumo->despesas), 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrpagou, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrreceb, 2, ',', '.') }}</td>
                                    <td> {{ Carbon\Carbon::parse($resumo->dataultven)->format('d/m/Y') }}</td>
{{--                                    <td> {{$resumo->dataultve n}}</td>--}}
                                    <td @if ($resumo->vlrdevatu < 0)
                                        bgcolor='RED' @elseif ($resumo->vlrdevant > 0) bgcolor='GREEN'
                                    @else @endif>{{ number_format($resumo->vlrdevatu, 2, ',', '.') }}</td>


                                </tr>
                            @empty
                                <tr>
                                    nenhum registro encontrado!
                                </tr>
                            @endforelse


                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>



@endsection




