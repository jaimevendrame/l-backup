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
                        <form class="form-group" id="form-cad-edit" method="post" action="/admin/descargasenviadas/{{$ideven}}" enctype="multipart/form-data">
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
                                    <select multiple name="sel_lotodia[]">
                                        <option value="" disabled selected>Selecionar</option>
                                        @forelse($semana as $s)

                                            @if(!empty($idehor))
                                                <option value="{{$s->idehor}}" @forelse($idehor as $select) {{ $s->idehor == $select  ? 'selected' : '' }} @ @empty @endforelse >{{$s->idehor}}-{{$s->deshor}}</option>

                                                @else
                                                <option value="{{$s->idehor}}">{{$s->deshor}}</option>

                                            @endif

                                        @empty
                                            <option value="" disabled selected>Nenhum</option>
                                        @endforelse

                                    </select>
                                    <label>Loterias do Dia</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <select multiple name="sel_vendedor[]">
                                        <option value="" disabled selected>Selecionar Vendedores</option>
                                        @forelse($baseAll as $bases)
                                            @if( empty($ideven2) )
                                            <option value="{{$bases->ideven}}" {{ $bases->ideven == $ideven  ? 'selected' : '' }} >{{$bases->ideven}}-{{$bases->nomven}}</option>
                                            @elseif(isset($ideven2) && (is_array($ideven2)))
                                            <option value="{{$bases->ideven}}" @forelse($ideven2 as $select) {{ $bases->ideven == $select  ? 'selected' : '' }} @ @empty @endforelse >{{$bases->ideven}}-{{$bases->nomven}}</option>
                                             @else
                                                <option value="{{$bases->ideven}}">{{$bases->ideven}}-{{$bases->nomven}}</option>
                                            @endif
                                        @empty
                                            <option value="" disabled selected>Nenhuma base</option>
                                        @endforelse

                                    </select>
                                    <label>Bases selecionadas</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m2">
                                    <select name="sel_vendedord">
                                        <option value="" >Nenhum</option>
                                        @if(!empty($descarga))
                                            @forelse($descarga as $d)
                                                <option value="{{$d->idbasedesc}}{{$d->idvendesc}}"@if( !empty($idvendd)) {{ $d->idbasedesc.$d->idvendesc == $idvendd  ? 'selected' : '' }} @endif>{{$d->nomven}}</option>
                                            @empty
                                                <option value="" disabled selected>Nenhum vendedor</option>
                                            @endforelse
                                        @endif
                                    </select>
                                    <label>Vendedor</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <select  name="sel_situacao">
                                        {{--<option value="3" disabled selected>Opções</option>--}}
                                        <option value="3" @if(!empty($idsit)) {{ $idsit == 3  ? 'selected' : '' }}  @endif>Todos</option>
                                        <option value="0" @if(!empty($idsit)) {{ $idsit == 0  ? 'selected' : '' }}  @endif>Pendente de liberação</option>
                                        <option value="1" @if(!empty($idsit)) {{ $idsit == 1  ? 'selected' : '' }}  @endif>Liberadas</option>
                                        <option value="2" @if(!empty($idsit)) {{ $idsit == 2  ? 'selected' : '' }}  @endif>Não liberadas</option>
                                    </select>
                                    <label>Situação</label>
                                </div>
                                <div class="input-field col s8 m2 l2">
                                    <input  id="numpule" name="numpule" type="text" class="validate" @if(!empty($palpite)) value="{{$palpite}}" @else value="" @endif>
                                    <label class="active" for="numpule">Nº Aposta</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <select  name="sel_loterias">
                                        <option value=""  selected>Todos</option>
                                        @forelse($loterias as $l)
                                        <option value="{{$l->idlot}}" @if(!empty($idlot)) {{ $l->idlot == $idlot  ? 'selected' : '' }}  @endif>{{$l->deslot}}</option>
                                        @empty
                                        <option value="">Nenhum</option>
                                        @endforelse
                                    </select>
                                    <label>Loterias</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">Atualizar
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>

                        </form>

                        @if(!empty($data))

                            <table class="mdl-data-table " id="example"  cellspacing="0" width="100%">

                                <thead><tr>
                                    <th></th>
                                    <th></th>
                                    <th>Pule</th>
                                    <th>Data Sorteio</th>
                                    <th>Loteria</th>
                                    <th>Modalidade</th>
                                    <th>Palpite</th>
                                    <th>Vlr. Descarga</th>
                                    <th>Colocação Descarga</th>
                                    <th>Colocação Palpite</th>
                                    <th>Situação</th>
                                    <th>Horário Limite</th>
                                    <th>Vendedor Destino</th>
                                    <th>Data Envio Aposta</th>
                                </tr></thead>
                                <tbody>

                                @forelse($data as $d)

                                    <tr>
                                        <td><a class="waves-effect waves-light btn blue" onclick='edit("/descargasenviadas/view/{{$ideven}}/{{$d->idapo}}")'><i class="material-icons">info</i></a>
                                        <td>{{ $d->infodesc }}</td>
                                        <td>{{ $d->numpule }}</td>
                                        <td>{{ Carbon\Carbon::parse($d->datapo)->format('d/m/Y') }}</td>
                                        <td>{{ $d->deshor }}</td>
                                        <td>{{ $d->destipoapo }}</td>
                                        <td>  @if( isset($d->palp1) ){{$d->palp1}}@endif

                                            @if( isset($d->palp2) ){{'- '.$d->palp2}}@endif

                                            @if( isset($d->palp3) ) {{'- '.$d->palp3}} @endif

                                            @if( isset($d->palp4) ){{'- '.$d->palp4}}@endif

                                            @if( isset($d->palp5) ){{'- '.$d->palp5}}@endif

                                            @if( isset($d->palp6) ){{'- '.$d->palp6}}@endif

                                            @if( isset($d->palp7) ){{'- '.$d->palp7}}@endif

                                            @if( isset($d->palp8) ){{'- '.$d->palp8}}@endif

                                            @if( isset($d->palp9) ){{'- '.$d->palp9}}@endif

                                            @if( isset($d->palp10) ){{'- '.$d->palp10}}@endif

                                            @if( isset($d->palp11) ){{'- '.$d->palp11}}@endif

                                            @if( isset($d->palp12) ){{'- '.$d->palp12}}@endif

                                            @if( isset($d->palp13) ){{'- '.$d->palp13}}@endif

                                            @if( isset($d->palp13) ){{'- '.$d->palp13}}@endif

                                            @if( isset($d->palp14) ){{'- '.$d->palp14}}@endif

                                            @if( isset($d->palp15) ){{'- '.$d->palp15}}@endif

                                            @if( isset($d->palp16) ){{'- '.$d->palp16}}@endif

                                            @if( isset($d->palp17) ){{'- '.$d->palp17}}@endif

                                            @if( isset($d->palp18) ){{'- '.$d->palp18}}@endif

                                            @if( isset($d->palp19) ){{'- '.$d->palp19}}@endif

                                            @if( isset($d->palp20) ){{'- '.$d->palp20}}@endif

                                            @if( isset($d->palp21) ){{'- '.$d->palp21}}@endif

                                            @if( isset($d->palp22) ){{'- '.$d->palp22}}@endif

                                            @if( isset($d->palp23) ){{'- '.$d->palp23}}@endif

                                            @if( isset($d->palp24) ){{'- '.$d->palp24}}@endif

                                            @if( isset($d->palp25) ){{'- '.$d->palp25}}@endif
                                        </td>
                                        <td>{{ number_format($d->vlrpalpo, 2, ',', '.') }}</td>
                                        <td>{{ $d->tipodesc }}</td>
                                        <td>{{ $d->descol }}</td>
                                        @if($d->sitdes = 'PRO')
                                            <td>LIBERADO</td>
                                        @elseif($d->sitdes = 'EL')
                                            @if( ( Carbon\Carbon::parse($d->horlim)->format('H:i:s') < Carbon\Carbon::now()->format('H:i:s') )
                                    && ( Carbon\Carbon::parse($d->datapo)->format('d/m/Y') == Carbon\Carbon::now()->format('Hd/m/Y') )
                                    || ( Carbon\Carbon::parse($d->datapo)->format('d/m/Y') < Carbon\Carbon::now()->format('Hd/m/Y') ) )
                                                <td>NÃO LIBERADO</td>
                                            @else
                                                <td>PENDENTE DE LIBERAÇÃO</td>
                                            @endif
                                        @elseif($d->sitdes = 'PRE')
                                            <td class="orange">PREMIADO</td>
                                        @endif
                                        <td>{{Carbon\Carbon::parse($d->horlim)->format('H:i:s')}}</td>
                                        <td>{{ $d->nomven }}</td>
                                        <td> {{ Carbon\Carbon::parse($d->datenv)->format('d/m/Y') }} - {{Carbon\Carbon::parse($d->horenv)->format('H:i:s')}} </td>


                                    </tr>
                                @empty
                                    <tr>
                                        <p>nenhum registro encontrado!</p>
                                    </tr>
                                @endforelse

                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Pule</th>
                                    <th>Data Sorteio</th>
                                    <th>Loteria</th>
                                    <th>Modalidade</th>
                                    <th>Palpite</th>
                                    <th>Vlr. Descarga</th>
                                    <th>Colocação Descarga</th>
                                    <th>Colocação Palpite</th>
                                    <th>Situação</th>
                                    <th>Horário Limite</th>
                                    <th>Vendedor Destino</th>
                                    <th>Data Envio Aposta</th>

                                </tr>
                                </tfoot>


                            </table>

                            @else
                            <p>Nenhum registro encontrado!</p>

                        @endif


                    </div>

                </div>
            </div>
            @php
                $total = 0;
                foreach ($data as $d){
                    $total = $total + $d->vlrpalpo;
                }
            @endphp
            <div class="row">
                <div class="col s12 offset-m9 m3 offset-l9 l3">
                    <div class="col s12 z-depth-2 blue-grey lighten-5 hoverable">
                        <div class="row left-align">
                            <h5 class=" blue-grey-text">
                                Total:
                            </h5>
                        </div>
                        <div class="row right-align">
                            <h5 class=" blue-grey-text">@php echo number_format($total, 2, ',', '.');  @endphp</h5>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Modal Header</h4>
            <p>A bunch of text</p>
            <input type="text" id="teste">
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    $(document).ready(function() {
        $('.modal').modal();


        var table = $('#example').DataTable( {


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
            "aaSorting": [[3, "desc"],[6, "desc"]],


//            columnDefs: [
//                {
//                    targets: [ 0, 1, 2 ,3 ,4 ,5 ,6 ,7 ,8 ,9 ,10 ,11],
//                    className: 'mdl-data-table__cell--non-numeric'
//                }


//            ],

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

    //Editar
    function edit(urlEdit){

        jQuery.getJSON(urlEdit, function(data){
            $('#teste').val(data.nomvem_o);

        });

        $('#modal1').modal('open');
        return false;
    }
</script>
@endpush

