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
                                <div class="input-field col s2">
                                   Período: <input id="datIni" name="datIni" type="date" class="datepicker"
                                                   placeholder = @php echo date("d/m/Y") @endphp >
                                </div>
                                <div class="input-field col s2">
                                    à <input id="datFim" name="datFim" type="date" class="datepicker"
                                             placeholder = @php echo date("d/m/Y") @endphp>
                                </div>
                                <div class="input-field col s2">
                                    <input type="checkbox" id="test5" />
                                    <label for="test5">Despesas</label>
                                </div>

                                {{--<div class="input-field col s2">--}}
                                    {{--<div class="switch ">--}}
                                        {{--<label>--}}
                                            {{--Off--}}
                                            {{--<input type="checkbox">--}}
                                            {{--<span class="lever"></span>--}}
                                            {{--On--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="input-field col s4">
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
                                    <td>{{ number_format($resumo->vlrdevant, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrven, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrcom, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrliqbru, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrpremio, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->despesas, 2, ',', '.') }}</td>
                                    <td>{{ $resumo->idbase }}</td>
                                    <td>{{ number_format($resumo->vlrpagou, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrreceb, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrdevatu, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrtransr, 2, ',', '.') }}</td>
                                    <td>{{ number_format($resumo->vlrtransp, 2, ',', '.') }}</td>
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




