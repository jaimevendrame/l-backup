@extends('dashboard.templates.app')

@section('content')
    <script src="{{url('assets/js/jquery-3.2.0.min.js')}}"></script>

    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <form class="form-group" id="form-cad-edit" method="post" action="/admin/apostaspremiadas" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row">

                                <div class="input-field col s12 m4 l2">
                                    <input id="n_pule" name="n_pule" type="tel" class="validate">
                                    <label class="active" for="n_pule">Nº Aposta</label>
                                </div>

                                <div class="input-field col s6 m4 l2">
                                    <input  id="datIni" name="datIni" type="date" class="datepicker"
                                           placeholder ="Data inicial" disabled>
                                </div>
                                <div class="input-field col s6 m4 l2">
                                     <input id="datFim" name="datFim" type="date" class="datepicker"
                                             placeholder ="Data final" disabled>
                                </div>

                                <div class="input-field col s12 m6 l4">
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

                                <div class="input-field col s12 m6 l2">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">Atualizar
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>


                            </div>
                            <div class="row">
                                <div class="input-field col s12 m4 l3 ">
                                    <input class="with-gap" name="group1" type="radio" id="test1" checked="checked" onclick="handleClick(this);" value="0"/>
                                    <label for="test1">Aguardando Liberação</label>
                                </div>
                                <div class="input-field col s12 m4 l2 ">
                                    <input class="with-gap" name="group1" type="radio" id="test2" onclick="handleClick(this);" value="1"/>
                                    <label for="test2">Não Liberados</label>
                                </div>
                                <div class="input-field col s12 m4 l2 ">
                                    <input class="with-gap" name="group1" type="radio" id="test3"  onclick="handleClick(this);" value="2"/>
                                    <label for="test3">Liberados</label>
                                </div>
                            </div>

                        </form>
                        @if(!empty($data))
                        <form id="frm-example">
                            <table class="mdl-data-table display" id="apostas_premiada"  cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Aposta Nº</th>
                                    <th>Data p/ Sorteio</th>
                                    <th>Horário</th>
                                    <th>Valor Palpite</th>
                                    <th>Valor Prêmio</th>
                                    <th>Limite p/ Pagamento</th>
                                    <th>Dias restante</th>
                                    <th>Revendedor</th>
                                    <th>Modalidade Apostas</th>
                                    <th>Palpite</th>
                                    <th>Colocação</th>
                                    <th>Data Liberação</th>
                                    <th>Manual</th>


                                </tr>
                                </thead>
                                <tbody>
                                {{--//#fffde7--}}
                                @php $l = 0 @endphp
                                @forelse($data as $apostas)
                                    @php $l += 1 @endphp

                                    <tr>
                                        <td>
                                            <input type="checkbox" id="{{$l}}" class="filled-in"  onclick="handleClick2();"  value="{{$apostas->vlrpre}}"/><label  for="{{$l}}">&nbsp;</label>
                                        </td>
                                        <td>{{$apostas->numpule}}</td>
                                        <td>{{Carbon\Carbon::parse($apostas->datapo)->format('d/m/Y')}}</td>
                                        <td>{{$apostas->deshor}}</td>
                                        <td class="valor">{{ number_format($apostas->vlrpalp, 2, ',', '.') }}</td>
                                        <td>{{ number_format($apostas->vlrpre, 2, ',', '.') }}</td>
                                        <td>{{Carbon\Carbon::parse($apostas->datlimpre)->format('d/m/Y')}}</td>
                                        <td>
                                        @php
                                        $dataAtual = date('Y-m-d');
                                        $dataLim = Carbon\Carbon::parse($apostas->datlimpre)->format('Y/m/d');
                                        $date1=date_create($dataAtual);
                                        $date2=date_create($dataLim);
                                        if($dataLim > $dataAtual){
                                            $diff=date_diff($date1,$date2);
                                            echo $diff->format("%a");
                                        }

                                        @endphp
                                        </td>
                                        <td>{{$apostas->nomreven}}</td>
                                        <td>{{$apostas->destipoapo}}</td>
                                        <td>
                                            @if( isset($apostas->palp1) ){{$apostas->palp1}}@endif

                                            @if( isset($apostas->palp2) ){{'- '.$apostas->palp2}}@endif

                                            @if( isset($apostas->palp3) ) {{'- '.$apostas->palp3}} @endif

                                            @if( isset($apostas->palp4) ){{'- '.$apostas->palp4}}@endif

                                            @if( isset($apostas->palp5) ){{'- '.$apostas->palp5}}@endif

                                            @if( isset($apostas->palp6) ){{'- '.$apostas->palp6}}@endif

                                            @if( isset($apostas->palp7) ){{'- '.$apostas->palp7}}@endif

                                            @if( isset($apostas->palp8) ){{'- '.$apostas->palp8}}@endif

                                            @if( isset($apostas->palp9) ){{'- '.$apostas->palp9}}@endif

                                            @if( isset($apostas->palp10) ){{'- '.$apostas->palp10}}@endif

                                            @if( isset($apostas->palp11) ){{'- '.$apostas->palp11}}@endif

                                            @if( isset($apostas->palp12) ){{'- '.$apostas->palp12}}@endif

                                            @if( isset($apostas->palp13) ){{'- '.$apostas->palp13}}@endif

                                            @if( isset($apostas->palp13) ){{'- '.$apostas->palp13}}@endif

                                            @if( isset($apostas->palp14) ){{'- '.$apostas->palp14}}@endif

                                            @if( isset($apostas->palp15) ){{'- '.$apostas->palp15}}@endif

                                            @if( isset($apostas->palp16) ){{'- '.$apostas->palp16}}@endif

                                            @if( isset($apostas->palp17) ){{'- '.$apostas->palp17}}@endif

                                            @if( isset($apostas->palp18) ){{'- '.$apostas->palp18}}@endif

                                            @if( isset($apostas->palp19) ){{'- '.$apostas->palp19}}@endif

                                            @if( isset($apostas->palp20) ){{'- '.$apostas->palp20}}@endif

                                            @if( isset($apostas->palp21) ){{'- '.$apostas->palp21}}@endif

                                            @if( isset($apostas->palp22) ){{'- '.$apostas->palp22}}@endif

                                            @if( isset($apostas->palp23) ){{'- '.$apostas->palp23}}@endif

                                            @if( isset($apostas->palp24) ){{'- '.$apostas->palp24}}@endif

                                            @if( isset($apostas->palp25) ){{'- '.$apostas->palp25}}@endif
                                        </td>
                                        <td>{{$apostas->descol}}</td>
                                        <td>{{Carbon\Carbon::parse($apostas->datlimpre)->format('d/m/Y')}} - {{Carbon\Carbon::parse($apostas->horlibpre)->format('H:i:s')}} </td>
                                        <td>{{$apostas->prelibmanual}}</td>
                                    </tr>

                                @empty
                                    <tr>
                                        nenhum registro encontrado!
                                    </tr>
                                @endforelse
                            </table>
                        </form>
                        @else
                        <p>Nenhum registro encontrado!</p>
                        @endif

                    </div>

                </div>
            </div>
            <div class="row">
                @php
                    $totalPulesValido = 0;
                    foreach ($data as $key){
                        $totalPulesValido += $key->vlrpre;
                    }

                @endphp
                <div class="row">

                </div>
                <div class="row">
                    <div class="col s12 m12 l6 z-depth-2 gray hoverable">
                        <div class="row">
                            <div class="col s6 m6 l6 valign-wrapper"  style="padding-top: 10%">
                                <div id="pagar_premio">
                                    <a class="waves-effect waves-light btn">Pagar</a>
                                </div>
                            </div>
                            <div class="col s6 m6 l6 right-align">
                                <p class="right-align">Total Selecionados:</p>
                                <h3 class="resultado">0,00</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 l6 z-depth-2 red hoverable">
                        <div class="row right-align">
                            <p class="white-text">Total de Prêmios:</p>
                            <h3 class="white-text">@php echo number_format($totalPulesValido, 2, ',', '.'); @endphp</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@push('scripts')
<script type="text/javascript" src="{{url('js/jquery.mask.js')}}"></script>
<script>
    var currentValue = 0;
    function handleClick(myRadio) {
//        alert('Old value: ' + currentValue);
//        alert('New value: ' + myRadio.value);
        currentValue = myRadio.value;
        if (currentValue > 0){
            document.getElementById("datIni").disabled = false;
            document.getElementById("datFim").disabled = false;
        } else {
            document.getElementById("datIni").disabled = true;
            document.getElementById("datFim").disabled = true;

        }
    }
</script>

<script>
    function id( el ){
        return document.getElementById( el );
    }

    function handleClick2() {


        var inputs = id('apostas_premiada').getElementsByTagName('input');

        var  valor = 0;
        for( var i=0; i<inputs.length; i++ )
        {
            if( inputs[i].type=='checkbox' )
            {
                 inputs[i].value;
                if (inputs[i].checked){
                    valor = parseFloat(valor) + parseFloat(inputs[i].value);
                }
            }

            if (valor > 0){
                $("#pagar_premio").show();
            } else {
                $("#pagar_premio").hide();
            }

            $(".resultado").html(valor.toFixed(2).replace('.',','));
        }



    }
</script>


        <script>
    $(document).ready(function() {

        $("#pagar_premio").hide();

        $('#n_pule').mask('####################'), {reverse: true};

        var table = $('#apostas_premiada').DataTable( {

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
            "bProcessing": true,
            "aaSorting": [[1, "desc"]],


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
        // Handle form submission event
        $('#frm-example').on('submit', function(e){
            var form = this;

            var rows_selected = table.column(0).checkboxes.selected();

            // Iterate over all selected checkboxes
            $.each(rows_selected, function(index, rowId){
                // Create a hidden element
                $(form).append(
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'id[]')
                        .val(rowId)
                );
            });
        });


//        $('#apostas_premiada tbody').on('click', 'tr', function () {
//            var data = table.row( this ).data();
//            alert( 'You clicked on '+data[0]+'\'s row' );

//            $('table tr').each(function(){
//                var name = $(this).find('.selected').html();
//                alert(name);

//            });

//            var cell = table.cell( this );
//
//            $('#click-output').prepend(
//                '<div>'+cell.data()+'</div>'
//            alert(cell.data)
//            );

//            $('#apostas_premiada tbody tr td').each(
//                function(){
//                    //aqui dentro você teria tudo que tivesse dentro de cada tr td...
//                    var valor = $(this).find('valor').html;
//                    console.log(valor);
//
//                }
//            );

//        } );

//        $(table.table().container()).on( 'click', 'td', function () {
//            var cell = table.cell( this );
//
//            $('#click-output').prepend(
//                '<div>'+cell.data()+'</div>'
//                alert(cell.data)
//            );
//        } );
//
//        // #myInput is a <input type="text"> element
//        $('#myInput').on( 'keyup', function () {
//            table.search( this.value ).draw();
//        } );



    });
</script>
@endpush

