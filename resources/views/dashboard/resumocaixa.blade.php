@extends('dashboard.templates.app')

@section('content')

    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="input-field col s2">
                                Período: <input type="date" class="datepicker">
                            </div>
                            <div class="input-field col s2">
                                à <input type="date" class="datepicker">
                            </div>
                            <div class="input-field col s2">
                                <input type="checkbox" id="test5" />
                                <label for="test5">Despesas</label>
                            </div>

                            <div class="input-field col s2">
                                <div class="switch ">
                                    <label>
                                        Off
                                        <input type="checkbox">
                                        <span class="lever"></span>
                                        On
                                    </label>
                                </div>
                            </div>
                            <div class="input-field col s2">
                                <a class="waves-effect waves-light btn blue-grey">Base</a>
                            </div>

                            <div class="input-field col s2">
                                <a class="waves-effect waves-light btn blue-grey"><i class="material-icons left">print</i></a>
                            </div>
                        </div>


                        <table class="mdl-data-table display" id="example"  cellspacing="0" width="100%">
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
                                <th>Saldo Atual</th>
                                <th>Vlr.Trans.Rec</th>
                                <th>Vlr.Trans.Pag</th>
                                <th>Última Venda</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($data as $resumo)
                                <tr>
                                    <td>{{ $resumo->nomreven }}</td>
                                    <td>{{ $resumo->vlrdevant }}</td>
                                    <td>{{ $resumo->vlrven }}</td>
                                    <td>{{ $resumo->vlrcom }}</td>
                                    <td>{{ $resumo->vlrliqbru }}</td>
                                    <td>{{ $resumo->vlrpremio }}</td>
                                    <td>{{ $resumo->despesas }}</td>
                                    <td>{{ $resumo->idbase }}</td>
                                    <td>{{ $resumo->vlrpagou }}</td>
                                    <td>{{ $resumo->vlrreceb }}</td>
                                    <td>{{ $resumo->vlrdevatu }}</td>
                                    <td>{{ $resumo->vlrtransr }}</td>
                                    <td>{{ $resumo->vlrtransp }}</td>
                                    <td>{{ $resumo->dataultven }}</td>

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

    </div>



@endsection




