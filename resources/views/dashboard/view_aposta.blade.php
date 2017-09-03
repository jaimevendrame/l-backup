@extends('dashboard.templates.app')

@section('content')
    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">

                        @if($title == 'Cancelar Aposta')
                        <form class="form-group" id="form-cad-edit" method="post" action="/admin/apostas/cancel/{{$ideven}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @else
                        <form class="form-group" id="form-cad-edit" method="post" action="/admin/apostas/view/{{$ideven}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                        @endif
                            <div class="row">
                                <div class="input-field col s8 m3">
                                    <input  id="numpule" name="numpule" type="text" class="validate" value="@if(!empty($data)) {{$data[0]->numpule}} @endif">
                                    <label class="active" for="numpule">Nº Aposta</label>
                                </div>
                                <div class="input-field col s4 m1">
                                    <button class="tiny btn waves-effect waves-light" type="submit" name="action">
                                        <i class="tiny material-icons">send</i>
                                    </button>
                                </div>

                                <div class="input-field col s12 m2">
                                    <input  readonly id="vlr_aposta" type="text" class="validate" value="@if(!empty($data)) {{number_format($data[0]->vlrpalp, 2, ',', '.')}} @endif">
                                    <label class="active" for="vlr_aposta">Valor</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input  readonly id="revendedor" type="text" class="validate" value="@if(!empty($data)) {{$data[0]->idbase}}-{{$data[0]->nomreven}} @endif">
                                    <label class="active" for="revendedor">Revendedor</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input  readonly id="vendedor" type="text" class="validate" value="@if(!empty($data)) {{$data[0]->idven}}-{{$data[0]->nomven}} @endif">
                                    <label class="active" for="vendedor">Vendedor</label>
                                </div>
                            </div>

                        </form>
                                @if($title == 'Cancelar Aposta')
                                <form class="form-group" id="form-cancel" method="post" action="/admin/apostas/cancel/pule/{{$ideven}}" send="cancelar" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="numpule" id="numpule" value="@if(!empty($data)) {{$data[0]->numpule}} @endif">
                                    <input type="hidden" name="retorno" id="retorno" value="CANCELADO COM SUCESSO @php echo date('d/m/Y')." "; echo date('h:i:s');@endphp">
                                </form>
                                @endif
                        @if(!empty($data))
                            <div class="row">
                                <table class="mdl-data-table " id="apostas"  cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Modalidade</th>
                                        <th>Palpites</th>
                                        <th>Colocação</th>
                                        <th>Valor</th>
                                        <th>P/Dia</th>
                                        <th>Horário</th>
                                        <th>Situação</th>
                                        <th>Data Envio</th>
                                        <th>Hora Envio</th>
                                        <th>Data Canc</th>
                                        <th>Hora Canc</th>
                                        <th>Cotação</th>
                                        <th>Vlr Prêmio</th>
                                        <th>Vlr Palp Bancou</th>
                                        <th>Vlr Palp Desc</th>
                                        <th>Prêmio Seco</th>
                                        <th>Prêmio Molhado</th>
                                        <th>Prêmio SecMol</th>
                                        <th>Prêmio Bancou</th>


                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($data as $aposta)
                                        <tr>
                                            <td>{{$aposta->destipoapo}}</td>
                                            <td>
                                                @if( isset($aposta->palp1) ){{$aposta->palp1}}@endif @if( isset($aposta->palp2) ){{'- '.$aposta->palp2}}@endif @if( isset($aposta->palp3) ) {{'- '.$aposta->palp3}} @endif @if( isset($aposta->palp4) ){{'- '.$aposta->palp4}}@endif

                                                @if( isset($aposta->palp5) ){{'- '.$aposta->palp5}}@endif

                                                @if( isset($aposta->palp6) ){{'- '.$aposta->palp6}}@endif

                                                @if( isset($aposta->palp7) ){{'- '.$aposta->palp7}}@endif

                                                @if( isset($aposta->palp8) ){{'- '.$aposta->palp8}}@endif

                                                @if( isset($aposta->palp9) ){{'- '.$aposta->palp9}}@endif

                                                @if( isset($aposta->palp10) ){{'- '.$aposta->palp10}}@endif

                                                @if( isset($aposta->palp11) ){{'- '.$aposta->palp11}}@endif

                                                @if( isset($aposta->palp12) ){{'- '.$aposta->palp12}}@endif

                                                @if( isset($aposta->palp13) ){{'- '.$aposta->palp13}}@endif

                                                @if( isset($aposta->palp13) ){{'- '.$aposta->palp13}}@endif

                                                @if( isset($aposta->palp14) ){{'- '.$aposta->palp14}}@endif

                                                @if( isset($aposta->palp15) ){{'- '.$aposta->palp15}}@endif

                                                @if( isset($aposta->palp16) ){{'- '.$aposta->palp16}}@endif

                                                @if( isset($aposta->palp17) ){{'- '.$aposta->palp17}}@endif

                                                @if( isset($aposta->palp18) ){{'- '.$aposta->palp18}}@endif

                                                @if( isset($aposta->palp19) ){{'- '.$aposta->palp19}}@endif

                                                @if( isset($aposta->palp20) ){{'- '.$aposta->palp20}}@endif

                                                @if( isset($aposta->palp21) ){{'- '.$aposta->palp21}}@endif

                                                @if( isset($aposta->palp22) ){{'- '.$aposta->palp22}}@endif

                                                @if( isset($aposta->palp23) ){{'- '.$aposta->palp23}}@endif

                                                @if( isset($aposta->palp24) ){{'- '.$aposta->palp24}}@endif

                                                @if( isset($aposta->palp25) ){{'- '.$aposta->palp25}}@endif
                                            </td>
                                            <td>{{$aposta->descol}}</td>
                                            <td>{{number_format($aposta->vlrpalp, 2, ',', '.')}}</td>
                                            <td>{{Carbon\Carbon::parse($aposta->datapo)->format('d/m/Y')}}</td>
                                            <td>{{$aposta->deshor}}</td>
                                            <td>{{$aposta->sitapo == 'CAN'  ? 'CANCELADO' : $aposta->sitapo == 'V'  ? 'VALIDO':'PREMIADO'}}</td>
                                            <td>{{Carbon\Carbon::parse($aposta->datenv)->format('d/m/Y')}}</td>
                                            <td>{{Carbon\Carbon::parse($aposta->horenv)->format('H:i:s')}}</td>
                                            <td>{{Carbon\Carbon::parse($aposta->datcan)->format('d/m/Y')}}</td>
                                            <td>{{Carbon\Carbon::parse($aposta->horcan)->format('H:i:s')}}</td>
                                            <td>{{number_format($aposta->vlrcotacao, 2, ',', '.')}}</td>
                                            <td>{{number_format($aposta->vlrpre, 2, ',', '.')}}</td>
                                            <td>{{number_format($aposta->vlrpalpf, 2, ',', '.')}}</td>
                                            <td>{{number_format($aposta->vlrpalpd, 2, ',', '.')}}</td>
                                            <td>{{number_format($aposta->vlrpresec, 2, ',', '.')}}</td>
                                            <td>{{number_format($aposta->vlrpremol, 2, ',', '.')}}</td>
                                            <td>{{number_format($aposta->vlrpresmj, 2, ',', '.')}}</td>
                                            <td>{{number_format($aposta->vlrprepag, 2, ',', '.')}}</td>
                                        </tr>

                                    @empty
                                        <tr>
                                            nenhum registro encontrado!
                                        </tr>
                                    @endforelse
                                </table>
                            </div>
                        @else
                        <p>Nenhum registro encontrado!</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@if($title == 'Cancelar Aposta')

@push('scripts')
        <script type="text/javascript" src="{{url('js/jquery.mask.js')}}"></script>

        <script>
    $(document).ready(function() {

        var cancelar = $('#form-cancel').attr('send');


        $('#numpule').mask('00000000000'), {reverse: true};


        var table = $('#apostas').DataTable( {
//            fixedColumns: {
//                leftColumns: 2
//
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
                },


                {
                    text: 'Cancelar Aposta',
                    action: function () {

                        var nr_pule = $('#numpule').val();

                        if ( nr_pule == ''){
                            Materialize.toast('Digite uma Aposta', 3000)
                            return false;
                        }

                        var dadosForm = jQuery('#form-cancel').serialize();

                        var action= $('#form-cancel').attr('action');

//                        alert(dadosForm);

                        decisao = confirm("Cancelar a aposta: "+ nr_pule);

                        if (decisao){

                            jQuery.ajax({
                                url: action,
                                data: dadosForm,
                                method: 'POST'


                            }).done(function (data) {


                                if (data == '1') {

                                    alert('Aposta '+ nr_pule + ' cancelada com sucesso');

                                    location.reload();

                                } else {
                                    alert('Falha ao cancelar a Aposta: '+ nr_pule + '\n' + data);

                                }
                            }).fail(function () {
                                alert('Falha ao enviar dados!!');


                            });

                            return false;



                        } else {
                            return false;
                        }

                    }
                },


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
    @else
    @push('scripts')
    <script type="text/javascript" src="{{url('js/jquery.mask.js')}}"></script>

    <script>
        $(document).ready(function() {

            var cancelar = $('#form-cancel').attr('send');


            $('#numpule').mask('00000000000'), {reverse: true};


            var table = $('#apostas').DataTable( {
//            fixedColumns: {
//                leftColumns: 2
//
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
                    },


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
@endif
