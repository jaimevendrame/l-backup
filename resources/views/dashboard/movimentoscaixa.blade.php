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
                                           placeholder ="Data inicial">

                                </div>
                                <div class="input-field col s6 m2">
                                     <input id="datFim" name="datFim" type="date" class="datepicker"
                                             placeholder ="Data final">
                                </div>

                                <div class="input-field col s12 m2">
                                    <select name="sel_revendedor">
                                        <option value="" disabled selected>Selecionar Revendedor</option>
                                        @forelse($reven as $r)
                                            <option value="{{$r->idreven}}">{{$r->idreven}} - {{$r->nomreven}}</option>
                                        @empty
                                            <option value="" disabled selected>Nenhuma Revendedor</option>
                                        @endforelse

                                    </select>
                                    <label>Revendedor</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <select name="sel_cobrador">
                                        <option value="" disabled selected>Cobrador</option>
{{--                                        <option value="1" @if(isset($despesas)){{ $despesas == 'SIM'  ? 'selected' : '' }} @endif>Com Despesas</option>--}}
                                        @forelse($cobrador as $cob)
                                            <option value="{{$cob->idcobra}}">{{$cob->nomcobra}}</option>
                                        @empty
                                            <option value="" disabled selected>Nenhuma Cobrador</option>
                                        @endforelse
                                    </select>
                                    <label>Cobradores</label>
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

                        <table class="mdl-data-table " id="movcaixa"  cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Revendedor</th>
                                <th>Saldo Anterior</th>
                                <th>Valor Movimento</th>
                                <th>Saldo Após Mov.</th>
                                <th>Data Mov.</th>
                                <th>Horário</th>
                                <th>Tipo Mov.</th>
                                <th>Cobrador</th>
                                <th>Usuário Mov.</th>

                            </tr>
                            </thead>
                            <tbody>

                            @forelse($data as $movi)

                                <tr>
                                    <td>{{ $movi->nomreven }}</td>
                                    <td><b>{{ number_format($movi->saldoant, 2, ',', '.') }}</b></td>
                                    <td>{{ number_format($movi->vlrmov, 2, ',', '.') }}</td>
                                    <td>{{ number_format($movi->saldoatu, 2, ',', '.') }}</td>
                                    <td> {{ Carbon\Carbon::parse($movi->datmov)->format('d/m/Y') }}</td>
                                    <td>{{ Carbon\Carbon::parse($movi->hormov)->format('H:m:s') }}</td>
                                    <td @if ($movi->tipomov == 'RECEBIMENTO') class='white-text' bgcolor='#4caf50'
                                    @else class='white-text' bgcolor='#e53935'@endif>
                                        <b>{{ $movi->tipomov }}</b>
                                    </td>
                                    <td>{{ $movi->nomcobra }}</td>
                                    <td>{{ $movi->nomeusumov }}</td>



                                </tr>
                            @empty
                                <tr>
                                    nenhum registro encontrado!
                                </tr>
                            @endforelse

                            <tfoot>
                            @php
                                $recebimento = 0;

                                $pagamento = 0;

                                $despesas = 0;

                                $str_recebimento = array("RECEBIMENTO", "ESTORNO REC.", "DEBITO REC.", "CREDITO REC.");
                                $str_pagamento = array("PAGAMENTO", "ESTORNO PAG.", "DEBITO PAG.", "CREDITO PAG.");
                                $str_despesa = array("DESPESA");



                                foreach($data as $key) {

                                    if (array_key_exists($key->tipomov,$str_recebimento)){
                                    @dd($key->tipomov);

                                     $recebimento += $key->vlrmov;

                                    }

                                    if (array_key_exists($key->tipomov,$str_pagamento)){

                                     $pagamento += $key->vlrmov;

                                    }

                                    if (array_key_exists($key->tipomov,$str_despesa)){

                                     $despesas += $key->vlrmov;

                                    }


                                            }
                            @endphp
                            <tr>

                                <th>Revendedor</th>
                                <th>Saldo Anterior</th>
                                <th>Valor Movimento</th>
                                <th>Saldo Após Mov.</th>
                                <th>Data Mov.</th>
                                <th>Horário</th>
                                <th>Tipo Mov.</th>
                                <th>Cobrador</th>
                                <th>Usuário Mov.</th>

                            </tr>
                            </tfoot>


                        </table>
                        <div class="row">
                            <div class="col s2">Total Recebimento: @php echo number_format($recebimento, 2, ',', '.'); @endphp</div>
                            <div class="col s2">Total Pagamento: @php echo number_format($pagamento, 2, ',', '.'); @endphp</div>
                            <div class="col s2"> Despesas: @php echo number_format($despesas, 2, ',', '.'); @endphp</div>
                            <div class="col s2"></div>
                            <div class="col s2"></div>
                            <div class="col s2 right-align">Saldo Caixa: @php echo number_format($recebimento - $pagamento, 2, ',', '.');  @endphp</div>
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

            var table = $('#movcaixa').DataTable(
                {
                    fixedColumns: {
                        leftColumns: 1

                    },

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


                    scrollY: 380,
                    scrollX:        true,
                    scrollCollapse: true,
                    paging:         false,
                    Bfilter:        false,

                    columnDefs: [
                        {
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

                }

            );


            // #myInput is a <input type="text"> element
            $('#myInput').on( 'keyup', function () {
                table.search( this.value ).draw();
            } );


        } );


</script>

@endpush



