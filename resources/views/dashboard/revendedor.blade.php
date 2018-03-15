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
                        <a href="/admin/revendedor/create/{{$ideven}}/add" class="btn">NOVO</a>
                    @if(!empty($data))
                            <table class="mdl-data-table " id="example"  cellspacing="0" width="100%">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>NOME REVENDEDOR</th>
                                    <th>CIDADE</th>
                                    <th>UF</th>
                                    <th>SITUAÇÃO</th>
                                    <th>VENDEDOR</th>
                                    <th>NOME VENDEDOR</th>
                                </tr></thead>
                                <tbody>
                                @forelse($data as $d)
                                    <tr>
                                        <td>{{ $d->idereven}}</td>
                                        <td>{{ $d->nomreven }}</td>
                                        <td>{{ $d->cidreven }}</td>
                                        <td>{{ $d->sigufs }}</td>
                                        <td>{{ $d->sitreven }}</td>
                                        <td>{{ $d->idven }}</td>
                                        <td>{{ $d->nomven }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <p>nenhum registro encontrado!</p>
                                    </tr>
                                @endforelse
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>NOME REVENDEDOR</th>
                                    <th>CIDADE</th>
                                    <th>UF</th>
                                    <th>SITUAÇÃO</th>
                                    <th>VENDEDOR</th>
                                    <th>NOME VENDEDOR</th>
                                </tr>
                                </tfoot>
                            </table>
                            @else
                            <p>Nenhum registro encontrado!</p>
                        @endif
                        <!-- Modal Trigger -->
                            {{--<a class="waves-effect waves-light btn modal-trigger" href="#modal2">Novo</a>--}}

                            <!-- Modal Structure -->
                            <div id="modal2" class="modal">
                                <div class="modal-content">
                                    <h4>Cadastro de Revendedor</h4>
                                    <div class="row">
                                        <form action="" class="col m12">
                                            <div class="row">
                                                <div class="input-field col m2">
                                                    <select>
                                                        <option value="" disabled selected>Choose your option</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                    </select>
                                                    <label>Base</label>
                                                </div>
                                                <div class="input-field col m2">
                                                    <input id="idbase" type="text" class="validate">
                                                    <label for="idbase">Id Base</label>
                                                </div>
                                                <div class="input-field col m4">
                                                    <input id="nompro" type="text" class="validate">
                                                    <label for="nompro">Nome</label>
                                                </div>
                                                <div class="input-field col m2">
                                                    <input id="cidbas" type="text" class="validate">
                                                    <label for="cidbas">Cidade</label>
                                                </div>
                                                <div class="input-field col m2">
                                                    <input id="uf" type="text" class="validate">
                                                    <label for="uf">UF</label>
                                                </div>

                                                <div class="input-field col m2">
                                                <select>
                                                    <option value="" disabled selected>Choose your option</option>
                                                    <option value="1">Option 1</option>
                                                    <option value="2">Option 2</option>
                                                    <option value="3">Option 3</option>
                                                </select>
                                                <label>Vendedor</label>
                                            </div>
                                            <div class="input-field col m2">
                                                <input id="idbase" type="text" class="validate">
                                                <label for="idbase">Id Vendedor</label>
                                            </div>
                                            <div class="input-field col m4">
                                                <input id="nompro" type="text" class="validate">
                                                <label for="nompro">Vendedor</label>
                                            </div>
                                            <div class="input-field col m2">
                                                <input id="cidbas" type="text" class="validate">
                                                <label for="cidbas">Cidade</label>
                                            </div>
                                            <div class="input-field col m2">
                                                <input id="uf" type="text" class="validate">
                                                <label for="uf">UF</label>
                                            </div>
                                                <div class="input-field col m6">
                                                    <input id="idreven" type="text" class="validate">
                                                    <label for="idreven">Id Revendedor</label>
                                                </div>
                                                <div class="input-field col m6">
                                                    <input id="idereven" type="text" class="validate">
                                                    <label for="idereven">Identificação única</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="nomreven" type="text" class="validate">
                                                    <label for="nomreven">Nome</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="apereven" type="text" class="validate">
                                                    <label for="apereven">Nome Fantásia</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="endreven" type="text" class="validate">
                                                    <label for="endreven">Endereço</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="baireven" type="text" class="validate">
                                                    <label for="baireven">Bairro</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="cidreven" type="text" class="validate">
                                                    <label for="cidreven">Cidade</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <select>
                                                        <option value="" disabled selected>Choose</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                    </select>
                                                    <label>UF</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="telreven" type="text" class="validate">
                                                    <label for="telreven">Telefone</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="celreven" type="text" class="validate">
                                                    <label for="celreven">Celular</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <select>
                                                        <option value="" disabled selected>Choose</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                    </select>
                                                    <label>Situação</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="obsreven" type="text" class="validate">
                                                    <label for="obsreven">Observação</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <select>
                                                        <option value="" disabled selected>Choose</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                    </select>
                                                    <label>Local de Trabalho</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="datcad" name="datcad" type="date" class="datepicker">
                                                    <label for="datcad">Data Cadastro</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="usercad" type="text" class="validate">
                                                    <label for="usercad">Usuário Cadastrado</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="datalt" type="text" class="validate">
                                                    <label for="datalt">Data última Alteração</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="useralt" type="text" class="validate">
                                                    <label for="useralt">Usuário Alteração</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="limcred" type="text" class="validate">
                                                    <label for="limcred">Limite de Crédito</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="vlrcom" type="text" class="validate">
                                                    <label for="vlrcom">Comissão Padrão</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="vlrmaxpalp" type="text" class="validate">
                                                    <label for="vlrmaxpalp">Vlr. Máximo p/ Palpite</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="vlrblopre" type="text" class="validate">
                                                    <label for="vlrblopre">Bloquear prêmio maior que</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="limlibpre" type="text" class="validate">
                                                    <label for="limlibpre">Limite de dias para prêmio</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <select>
                                                        <option value="" disabled selected>Choose</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                    </select>
                                                    <label>Solicita Autênciacação p/ Liberar Prêmio</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <select>
                                                        <option value="" disabled selected>Choose</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                    </select>
                                                    <label>Cobrador</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <input id="portacom" type="text" class="validate">
                                                    <label for="portacom">Porta Comunicação</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <select>
                                                        <option value="" disabled selected>Choose</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                    </select>
                                                    <label>Permissão Reimprimir Aposta</label>
                                                </div>
                                                <div class="input-field col s4 m4 l2">
                                                    <select>
                                                        <option value="" disabled selected>Choose</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                    </select>
                                                    <label>Permissão Terminal Cancelar Aposta</label>
                                                </div>

                                            </div>{{-- end row--}}
                                            <div class="row">
                                                <button class="btn waves-effect waves-light" type="submit" >Confirmar
                                                    <i class="material-icons right">send</i>
                                                </button>
                                            </div>
                                        </form>{{-- end form --}}
                                    </div>
                                </div>

                                {{--<div class="modal-footer">--}}
                                    {{--<a href="#!" class=" btn modal-action  waves-effect waves-green" onclick="enviarDados()">Salvar Movimento</a>--}}
                                    {{--<button class="btn waves-effect waves-light" type="submit" >Confirmar--}}
                                        {{--<i class="material-icons right">send</i>--}}
                                    {{--</button>--}}
                                {{--</div>--}}

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


        $('ul.tabs').tabs();

        var table = $('#example').DataTable( {


            dom: 'fBrtip',
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
            Bfilter:        true,
            "aaSorting": [[1, "asc"],[6, "desc"]],


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

