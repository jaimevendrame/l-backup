@extends('dashboard.templates.app')

@section('content')
    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <form class="form-group" id="form-cad-edit" method="post" action="/admin/apostas" enctype="multipart/form-data">
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
                                @php
                                    $totalPulesValido = 0;
                                    foreach ($data as $key){
                                        if ($key->sitapo == 'V'){
                                            $totalPulesValido += $key->vlrpalp;
                                        }
                                    }


                                @endphp
                                <div class="input-field col s12 m2">
                                    <input  readonly id="total_pules" type="text" class="validate" value="@php echo number_format($totalPulesValido, 2, ',', '.'); @endphp">
                                    <label class="active" for="first_name">Total Pules</label>
                                </div>


                                {{--<div class="input-field col s12 m2">--}}
                                    {{--<select multiple name="sel_options[]">--}}
                                        {{--<option value="" disabled selected>Opções</option>--}}
                                        {{--<option value="1" @if(isset($despesas)){{ $despesas == 'SIM'  ? 'selected' : '' }} @endif>Ativos</option>--}}
                                        {{--<option value="2" @if(isset($in_ativos)){{ $in_ativos == 'SIM'  ? 'selected' : '' }} @endif>Inativos</option>--}}
                                    {{--</select>--}}
                                    {{--<label>Opções</label>--}}
                                {{--</div>--}}
                                <div class="input-field col s12 m2">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">Atualizar
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                        </form>


                        <table class="mdl-data-table " id="apostas"  cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Pule</th>
                                <th>Valor</th>
                                <th>Revendedor</th>
                                <th>Geração</th>
                                <th>Envio</th>
                                <th>Situação</th>
                                <th>Vendedor</th>
                                <th>Cidade</th>


                            </tr>
                            </thead>
                            <tbody>

                            @forelse($data as $apostas)
                                <tr {{ $apostas->sitapo == 'CAN'  ? "bgcolor = #fffde7" : '' }}>
                                    <td><a class="waves-effect waves-light grey btn modal-trigger" href="#modal1"><i class="tiny material-icons">dehaze</i></a></td>
                                    <td>{{$apostas->numpule}}</td>
                                    <td>{{ number_format($apostas->vlrpalp, 2, ',', '.') }}</td>
                                    <td>{{$apostas->nomreven}}</td>
                                    <td>{{Carbon\Carbon::parse($apostas->horger)->format('H:m:s')}} {{Carbon\Carbon::parse($apostas->datger)->format('d/m/Y')}}</td>
                                    <td>{{Carbon\Carbon::parse($apostas->horenv)->format('H:m:s')}} {{Carbon\Carbon::parse($apostas->datenv)->format('d/m/Y')}}</td>
                                    <td>{{ $apostas->sitapo == 'CAN'  ? 'CANCELADA' : 'VALIDO' }}</td>
                                    <td>{{$apostas->nomven}}</td>
                                    <td>{{$apostas->cidreven}}</td>
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

    <!-- Modal Trigger -->
    {{--<a class="waves-effect waves-light grey btn modal-trigger" href="#modal1"><i class="tiny material-icons">dehaze</i></a>--}}

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Modal Header</h4>
            <p>A bunch of text</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
        </div>
    </div>

@endsection
@push('modal')
<script type="application/javascript">
    $(document).ready(function(){
        $('.modal').modal({
                ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
                    alert("Ready");
                    console.log(modal, trigger);
                },
                complete: function() { alert('Closed'); } // Callback for Modal close
            }
        );
    });
</script>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {

        var table = $('#apostas').DataTable( {
            fixedColumns: {
                leftColumns: 2

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


            scrollY: 480,
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            Bfilter:        false,
            "aaSorting": [[0, "desc"]],


            columnDefs: [
                {
                    targets: [ 0, 1, 2 ,3 ,4 ,5 ,6 ,7 ,8 ],
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

