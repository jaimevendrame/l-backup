@extends('dashboard.templates.app')

@section('content')
    {{--@forelse($ideven2 as $p)--}}
        {{--{{$p}}--}}
        {{--@empty--}}
        {{--@endforelse--}}

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
                                           placeholder ="Data inicial">

                                </div>
                                <div class="input-field col s6 m2">
                                     <input id="datFim" name="datFim" type="date" class="datepicker"
                                             placeholder ="Data final">
                                </div>

                                <div class="input-field col s12 m4">
                                    <select multiple name="sel_vendedor[]">
                                        <option value="" disabled selected>Selecionar Vendedores</option>
                                        @forelse($baseAll as $bases)
                                            @if( isset($ideven) && !empty($ideven))
                                            <option value="{{$bases->ideven}}" {{ $bases->ideven == $ideven  ? 'selected' : '' }} >{{$bases->ideven}}-{{$bases->nomven}}</option>
                                                @elseif(isset($ideven2) && (is_array($ideven2))) <option value="{{$bases->ideven}}" @forelse($ideven2 as $select) {{ $bases->ideven == $select  ? 'selected' : '' }} @ @empty @endforelse >{{$bases->ideven}}-{{$bases->nomven}}</option>
                                             @else
                                                <option value="{{$bases->ideven}}">{{$bases->ideven}}-{{$bases->nomven}}</option>
                                            @endif
                                        @empty
                                            <option value="" disabled selected>Nenhuma base</option>
                                        @endforelse

                                    </select>
                                    <label>Bases selecionadas</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <select multiple name="sel_options[]">
                                        <option value="" disabled selected>Opções</option>
                                        <option value="1" @if(isset($despesas)){{ $despesas == 'SIM'  ? 'selected' : '' }} @endif>Com Despesas</option>
                                        <option value="2" @if(isset($in_ativos)){{ $in_ativos == 'SIM'  ? 'selected' : '' }} @endif>Mostrar Inativos</option>
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
                            <tbody>

                            @forelse($data as $resumo)

                                <tr>
                                    <td>{{ $resumo->nomreven }}</td>
                                    <td
                                            @if ($resumo->vlrdevant < 0)class='white-text' bgcolor='#e53935'
                                            @elseif ($resumo->vlrdevant > 0) class='white-text' bgcolor='#4caf50'
                                    @else @endif >
                                        <b>{{ number_format($resumo->vlrdevant, 2, ',', '.') }}</b></td>
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
                                                    <iframe width="700" height="315" src="/admin/resumocaixa/aposta_premiada/{{$resumo->idven}}/{{$resumo->idbase}}/{{$resumo->idreven}}/{{Carbon\Carbon::parse($resumo->dataini)->format('Y-m-d')}}/{{Carbon\Carbon::parse($resumo->datafim)->format('Y-m-d')}}" frameborder="0" allowfullscreen></iframe></div>
                                                </p>

                                            </div>

                                        </div>
                                    @endif
                                    @if(isset($despesas))
                                        @if($despesas == 'SIM')
                                        <td>{{ number_format($resumo->despesas, 2, ',', '.') }}</td>
                                        @else
                                        <td>{{ number_format(0, 2, ',', '.') }}</td>
                                        @endif
                                    @else
                                        <td>{{ number_format(0, 2, ',', '.') }}</td>

                                    @endif
                                    <td>{{ number_format(($resumo->vlrliqbru - $resumo->vlrpremio - $resumo->despesas), 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrpagou, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrreceb, 2, ',', '.') }}</td>
                                    <td> {{ Carbon\Carbon::parse($resumo->dataultven)->format('d/m/Y') }}</td>
                                    {{--                                    <td> {{$resumo->dataultve n}}</td>--}}
                                    <td @if ($resumo->vlrdevatu < 0) class='white-text' bgcolor='#e53935'
                                        @elseif ($resumo->vlrdevant > 0) class='white-text' bgcolor='#4caf50'
                                    @else @endif><b>{{ number_format($resumo->vlrdevatu, 2, ',', '.') }}</b></td>


                                </tr>
                            @empty
                                <tr>
                                    nenhum registro encontrado!
                                </tr>
                            @endforelse

                            <tfoot>
                            @php
                                $saldoanterior = 0;

                                $venda = 0;

                                $comissao = 0;

                                $liquido = 0;

                                $premio = 0;

                                $despesas = 0;


                                $pagto = 0;

                                $recb = 0;

                                $saldoatual = 0;
                                $semvendas = 0;

                                foreach($data as $key) {

                                        if ($key->vlrven <= 0){
                                        $semvendas += 1;
                                        }

                                         $saldoanterior += $key->vlrdevant;

                                         $venda += $key->vlrven;

                                         $comissao += $key->vlrcom;

                                         $liquido += $key->vlrliqbru;

                                         $premio+= $key->vlrpremio;

                                         $despesas += $key->despesas;


                                         $pagto+= $key->vlrpagou;

                                         $recb+= $key->vlrreceb;

                                         $saldoatual+= $key->vlrdevatu;

                                            }
                            @endphp
                            <tr>

                                <th>Revendedor</th>
                                <th>@php echo number_format($saldoanterior, 2, ',', '.'); @endphp</th>
                                <th>@php echo number_format($venda, 2, ',', '.'); @endphp</th>
                                <th>@php echo number_format($comissao, 2, ',', '.'); @endphp</th>
                                <th>@php echo number_format($liquido, 2, ',', '.'); @endphp</th>
                                <th>@php echo number_format($premio, 2, ',', '.'); @endphp</th>
                                <th>@php echo number_format($despesas, 2, ',', '.'); @endphp</th>
                                <th>@php echo number_format($liquido - $premio - $despesas, 2, ',', '.'); @endphp</th>
                                <th>@php echo number_format($pagto, 2, ',', '.'); @endphp</th>
                                <th>@php echo number_format($recb, 2, ',', '.'); @endphp</th>
                                <th>Última Venda</th>
                                <th>@php echo number_format($saldoatual, 2, ',', '.'); @endphp</th>

                            </tr>
                            </tfoot>


                        </table>
                        <div class="row">
                            <div class="col s2">Revendedor: @php echo count($data)@endphp</div>
                            <div class="col s2">Sem vendas: @php echo $semvendas @endphp</div>
                            <div class="col s2">Com vendas: @php echo count($data) - $semvendas @endphp</div>
                            <div class="col s2"></div>
                            <div class="col s2"></div>
                            <div class="col s2 right-align">Caixa: @php echo number_format($recb - $pagto, 2, ',', '.');  @endphp</div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>



@endsection




