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
                                <div class="input-field col s3">
                                   <input id="datIni" name="datIni" type="date" class="datepicker"
                                                   placeholder =@php  echo "De:".'&nbsp;'.date("d/m/Y") @endphp >
                                </div>
                                <div class="input-field col s3">
                                     <input id="datFim" name="datFim" type="date" class="datepicker"
                                             placeholder = @php echo "à:".'&nbsp;'.date("d/m/Y") @endphp>
                                </div>

                                <div class="input-field col s6">
                                    <select multiple id="sel_vendedor" name="sel_vendedor[]">
                                        <option value="" disabled selected>Selecionar Vendedores</option>
                                        @forelse($baseAll as $bases)
                                        <option value="{{$bases->ideven}}"
                                                {{ $bases->inpadrao == 'SIM'  ? 'selected' : '' }}>
                                            {{$bases->ideven}} - {{$bases->nomven}} - {{$bases->cidven}}-{{$bases->sigufs}}</option>
                                        @empty
                                            <option value="" disabled selected>Nenhuma base</option>

                                        @endforelse

                                    </select>
                                    <label>Bases selecionadas</label>
                                </div>

                                {{--<div class="input-field col s2">--}}
                                    {{--<a class="waves-effect waves-light btn blue-grey"><i class="material-icons left">print</i></a>--}}
                                {{--</div>--}}
                            </div>
                            <div class="row">
                                <div class="input-field col s2">
                                    <input type="checkbox" id="despesas"  name="despesas" value="SIM"/>
                                    <label for="despesas">Com Despesas</label>
                                </div>
                                <div class="input-field col s2">
                                    <input type="checkbox" id="in_ativos" name="in_ativos" value="SIM"/>
                                    <label for="in_ativos">Mostrar Inativos</label>
                                </div>
                                <button class="btn waves-effect waves-light" type="submit" name="action">Atualizar
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
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
                                <th>Vlr.Trans.Rec</th>
                                <th>Vlr.Trans.Pag</th>
                                <th>Última Venda</th>
                                <th>Saldo Atual</th>

                            </tr>
                            </thead>

                            <tbody>
                            @forelse($data as $resumo)
                                <tr>
                                    <td>{{ $resumo->nomreven }}</td>
                                    <td>{{ number_format($resumo->vlrdevant, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrven, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrcom, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrliqbru, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrpremio, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->despesas, 2, ',', '.') }}</td>
                                    <td>{{ $resumo->idbase }}</td>
                                    <td>{{ number_format($resumo->vlrpagou, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrreceb, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrtransr, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrtransp, 2, ',', '.') }}</td>
                                    <td>{{ $resumo->dataultven }}</td>
                                    <td>{{ number_format($resumo->vlrdevatu, 2, ',', '.') }}</td>


                                </tr>
                            @empty
                                <tr>
                                    nenhum registro encontrado!
                                </tr>
                            @endforelse

                            {{--</tbody>--}}
                            {{--<tfoot>--}}
                            {{--<tr>--}}
                                {{--<th>Revendedor</th>--}}
                                {{--<th>Saldo Anterior</th>--}}
                                {{--<th>Vendido</th>--}}
                                {{--<th>Comissão</th>--}}
                                {{--<th>Liquido</th>--}}
                                {{--<th>Prêmio</th>--}}
                                {{--<th>Despesas</th>--}}
                                {{--<th>Lucro</th>--}}
                                {{--<th>Pagamento</th>--}}
                                {{--<th>Recebimento</th>--}}
                                {{--<th>Vlr.Trans.Rec</th>--}}
                                {{--<th>Vlr.Trans.Pag</th>--}}
                                {{--<th>Última Venda</th>--}}
                                {{--<th>Saldo Atual</th>--}}
                            {{--</tr>--}}
                            {{--</tfoot>--}}
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>



@endsection




