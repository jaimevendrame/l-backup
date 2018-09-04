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
                                        <option value="1" @if(isset($var_despesas)){{ $var_despesas == 'SIM'  ? 'selected' : '' }} @endif>Com Despesas</option>
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
                            <tr bgcolor="#fffde7">

                                <th class="black-text">Revendedor</th>
                                <th class="black-text">@php echo number_format($venda, 2, ',', '.'); @endphp</br><b>Vendido</b></th>
                                <th class="black-text">@php echo number_format($comissao, 2, ',', '.'); @endphp</br><b>Comissão</b></th>
                                <th class="black-text">@php echo number_format($liquido, 2, ',', '.'); @endphp</br><b>Liquido</b></th>
                                <th class="black-text">@php echo number_format($premio, 2, ',', '.'); @endphp</br><b>Prêmio</b></th>
                                <th class="black-text">@php echo number_format($despesas, 2, ',', '.'); @endphp</br><b>Despesas</b></th>
                                <th class="black-text">@php echo number_format($liquido - $premio - $despesas, 2, ',', '.'); @endphp</br><b>Lucro</b></th>
                                <th class="black-text">@php echo number_format($pagto, 2, ',', '.'); @endphp</br><b>Pagamento</b></th>
                                <th class="black-text">@php echo number_format($recb, 2, ',', '.'); @endphp</br><b>Recebimento</b></th>
                                <th class="black-text">@php echo number_format($saldoatual, 2, ',', '.'); @endphp</br><b>Saldo Atual</b></th>
                                <th class="black-text">Última Venda</th>
                                <th class="black-text">@php echo number_format($saldoanterior, 2, ',', '.'); @endphp </br><b>Saldo Anterior</b></th>

                            </tr>

                            </thead>
                            <tbody>

                            @forelse($data as $resumo)

                                <tr>
{{--                                    <td>{{ $resumo->nomreven }}</td>--}}
                                    <td>@php if (strlen($resumo->nomreven) <=15) {
                                    echo $resumo->nomreven;
                                    } else {
                                    echo substr($resumo->nomreven, 0, 15) . '...';
                                    }@endphp</td>
                                    <td>{{ number_format($resumo->vlrven, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrcom, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrliqbru, 2, ',', '.') }}</td>
                                    <td>@if($resumo->vlrpremio > 0)<a href="#{{$resumo->vlrdevant}}" class="btn">@endif{{ number_format($resumo->vlrpremio, 2, ',', '.') }}</a></td>
                                @if($resumo->vlrpremio > 0)
                                    <!-- Modal Structure -->
                                        <div id="{{$resumo->vlrdevant}}" class="modal modal2">
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
                                    @if(isset($var_despesas))
                                        @if($var_despesas == 'SIM')
                                        <td>{{ number_format($resumo->despesas, 2, ',', '.') }}</td>
                                        @else
                                        <td>{{ number_format(0, 2, ',', '.') }}
                                        </td>
                                        @endif
                                    @else
                                        <td>{{ number_format(0, 2, ',', '.') }}</td>

                                    @endif
                                    <td>{{ number_format(($resumo->vlrliqbru - $resumo->vlrpremio - $resumo->despesas), 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrpagou, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrreceb, 2, ',', '.') }}</td>
                                    <td @if ($resumo->vlrdevatu < 0) class='white-text' bgcolor='#e53935'
                                        @elseif ($resumo->vlrdevant > 0) class='white-text' bgcolor='#4caf50'
                                    @else @endif><b>{{ number_format($resumo->vlrdevatu, 2, ',', '.') }}</b></td>
                                    <td> {{ Carbon\Carbon::parse($resumo->dataultven)->format('d/m/Y') }}</td>
                                    {{--                                    <td> {{$resumo->dataultve n}}</td>--}}

                                    <td
                                            @if ($resumo->vlrdevant < 0)class='white-text' bgcolor='#e53935'
                                            @elseif ($resumo->vlrdevant > 0) class='white-text' bgcolor='#4caf50'
                                    @else @endif >
                                        <b>{{ number_format($resumo->vlrdevant, 2, ',', '.') }}</b></td>
                                </tr>
                            @empty
                                <tr>
                                    nenhum registro encontrado!
                                </tr>
                            @endforelse

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
                                <th>Saldo Atual</th>
                                <th>Última Venda</th>

                            </tr>
                            </tfoot>


                        </table>
                        <div class="row"></div>
                        <div class="row">
                            <div class="col s12 m12 l3">
                                <div class="col s10 z-depth-2 blue-grey lighten-5 hoverable">
                                    <div class="row left-align">
                                        <h5 class=" blue-grey-text">
                                            Revendedor:
                                        </h5>
                                    </div>
                                    <div class="row right-align">
                                        <h5 class=" blue-grey-text">@php echo count($data)@endphp</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m12 l3">
                                <div class="col s10 z-depth-2 blue-grey lighten-5 hoverable">
                                    <div class="row left-align">
                                        <h5 class="blue-grey-text">
                                            Sem vendas:
                                        </h5>
                                    </div>
                                    <div class="row right-align">
                                        <h5 class="blue-grey-text">@php echo $semvendas @endphp</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m12 l3">
                                <div class="col s10 z-depth-2 blue-grey lighten-5 hoverable">
                                    <div class="row left-align">
                                        <h5 class="blue-grey-text">
                                            Com vendas:
                                        </h5>
                                    </div>
                                    <div class="row right-align">
                                        <h5 class="blue-grey-text">@php echo count($data) - $semvendas @endphp</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m12 l3">
                                @php
                                if ( ($recb - $pagto) < 0)
                                 $cor = 'vermelho';
                                else
                                $cor = 'verde';
                                @endphp
                                <div class="col s10 z-depth-2 @php echo $cor @endphp  hoverable">
                                    <div class="row left-align">
                                        <h5 class="blue-grey-text white-text">
                                            Caixa:
                                        </h5>
                                    </div>
                                    <div class="row right-align">
                                        <h5 class="blue-grey-text white-text">@php echo number_format($recb - $pagto, 2, ',', '.');  @endphp</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>



@endsection


@push('scripts')
<script>
    $(document).ready(function() {
        $('.modal').modal();


        var table = $('#example').DataTable( {
//            fixedColumns: {
//                leftColumns: 1
//            },


            dom: 'Brtip',
            buttons: [
                {
                    extend: 'copy',
                    text: 'Copiar',
                },
                'pdf',
                'excel',
                {
                    extend: 'print',
                    text: 'Imprimir',
                }
            ],


            scrollY: 480,
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            Bfilter:        false,
            "aaSorting": [[0, "desc"]],


            columnDefs: [
                {
                    targets: [ 0, 1, 2 ,3 ,4 ,5 ,6 ,7 ,8 ,9 ,10 ,11],
                    className: 'mdl-data-table__cell--non-numeric'
                }


            ],

            language: {
                "decimal":        ",",
                "thousands":      ".",
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }

        } );

        // #myInput is a <input type="text"> element
        $('#myInput').on( 'keyup', function () {
            table.search( this.value ).draw();
        } );

    });
</script>
@endpush

