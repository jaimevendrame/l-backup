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
                                    <td>
                                        <a id="link-modal" class="waves-effect waves-light grey btn modal-trigger" href="#" onclick='openModal1("/admin/apostas/view/{{$apostas->numpule}}/{{$apostas->ideven}}")'>
                                            <i class="tiny material-icons">dehaze</i></a>
                                    </td>
                                    <td>{{$apostas->numpule}}</td>
                                    <td>{{ number_format($apostas->vlrpalp, 2, ',', '.') }}</td>
                                    <td>{{$apostas->nomreven}}</td>
                                    <td>{{Carbon\Carbon::parse($apostas->horger)->format('H:m:s')}} {{Carbon\Carbon::parse($apostas->datger)->format('d/m/Y')}}</td>
                                    <td>{{Carbon\Carbon::parse($apostas->horenv)->format('H:m:s')}} {{Carbon\Carbon::parse($apostas->datenv)->format('d/m/Y')}}</td>
                                    <td>{{ $apostas->sitapo == 'CAN'  ? 'CANCELADO' : 'VALIDO' }}</td>
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

    <div id="aposta" class="modal">
        <div class="right-align">
            <a href="#!" class=" btn modal-action modal-close waves-effect waves-light red "><i class=" Tiny material-icons">close</i></a>
        </div>
        <div class="modal-content">
            <h4>Visualizar Aposta</h4>
            <div id="modal_content" class="row">
                <div class="row">
                    <div class="input-field col s12 m2">
                        <input  readonly id="n_aposta" type="text" class="validate" value="0000">
                        <label class="active" for="n_aposta">Nº Aposta</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <input  readonly id="vlr_aposta" type="text" class="validate" value="0,00">
                        <label class="active" for="vlr_aposta">Valor</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input  readonly id="revendedor" type="text" class="validate" value="Revendedor">
                        <label class="active" for="revendedor">Revendedor</label>
                    </div>


                </div>
                <div class="row">
                    <table id="tb-apostas" class="mdl-data-table__cell--non-numeric">
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
                            <th>VLRCOTACAO</th>
                            <th>Vlr Prêmio</th>
                            <th>VLRPALPF</th>
                            <th>VLRPALPD</th>
                            <th>VLRPRESEC</th>
                            <th>VLRPREMOL</th>
                            <th>VLRPRESMJ</th>
                            <th>VLRPREPAG</th>
                        </tr>
                        </thead>
                        <tbody id="tbody_aposta">
                        </tbody>
                    </table>
                </div>
        </div>
        {{--<div class="modal-footer">--}}
            {{--<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Ok</a>--}}
        {{--</div>--}}
    </div>

@endsection
@push('modal')
<script type="application/javascript">


    $(document).ready(function(){

        //init the modal
        $('.modal').modal();

        $('#tb-apostas').DataTable({

            dom: 'rt',
            scrollY: 480,
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            Bfilter:        false,
            "searching": false,
            "pagination": false,
        });



    });


    function openModal1(url) {

        $('#tbody_aposta').empty(); //Limpando a tabela

        $('#aposta').modal('open');


        jQuery.getJSON(url, function (data) {

            var vlrPalp = 0

            for (var i = 0; i <data.length; i++){

                var newRow = $("<tr>");
                var cols = "";
                var palp = [data[i].palp1];


                if (data[i].palp2){
                    palp.push(data[i].palp2);
                }
                if (data[i].palp3){
                    palp.push(data[i].palp3);
                }
                if (data[i].palp4){
                    palp.push(data[i].palp4);
                }
                if (data[i].palp5){
                    palp.push(data[i].palp5);
                }
                if (data[i].palp6){
                    palp.push(data[i].palp6);
                }
                if (data[i].palp7){
                    palp.push(data[i].palp7);
                }
                if (data[i].palp8){
                    palp.push(data[i].palp8);
                }
                if (data[i].palp9){
                    palp.push(data[i].palp9);
                }
                if (data[i].palp10){
                    palp.push(data[i].palp10);
                }
                if (data[i].palp11){
                    palp.push(data[i].palp11);
                }
                if (data[i].palp12){
                    palp.push(data[i].palp12);
                }
                if (data[i].palp13){
                    palp.push(data[i].palp13);
                }
                if (data[i].palp14){
                    palp.push(data[i].palp14);
                }
                if (data[i].palp15){
                    palp.push(data[i].palp15);
                }
                if (data[i].palp16){
                    palp.push(data[i].palp16);
                }
                if (data[i].palp17){
                    palp.push(data[i].palp17);
                }
                if (data[i].palp18){
                    palp.push(data[i].palp18);
                }
                if (data[i].palp19){
                    palp.push(data[i].palp19);
                }
                if (data[i].palp20){
                    palp.push(data[i].palp20);
                }
                if (data[i].palp21){
                    palp.push(data[i].palp21);
                }
                if (data[i].palp22){
                    palp.push(data[i].palp22);
                }
                if (data[i].palp23){
                    palp.push(data[i].palp23);
                }
                if (data[i].palp24){
                    palp.push(data[i].palp24);
                }
                if (data[i].palp25){
                    palp.push(data[i].palp25);
                }

                var todosPalp = palp.join('-');

                var vlrpalp = data[i].vlrpalp;
                var numpule = data[i].numpule;
                var idreven = data[i].idbase +' '+ data[i].nomreven;


                if(data[i].sitapo == 'V'){

                    var vaSituapo = 'VALIDO';
                } else if(data[i].sitapo == 'CAN'){
                    var vaSituapo = 'CANCELADO';
                } else {
                    var vaSituapo = 'PREMIADO';

                }

                var datApo = DateChance(data[i].datapo);
                var datEnv = DateChance(data[i].datenv);

                var horEnv = time_format(new Date(data[i].horenv));

                 vlrPalp += parseFloat(vlrpalp);


                cols += '<td>'+data[i].destipoapo+'</td>';
                cols += '<td>'+todosPalp+'</td>';
                cols += '<td>'+data[i].descol+'</td>';
                cols += '<td>'+parseFloat(vlrpalp).toFixed(2).replace(".", ",")+'</td>';
                cols += '<td>'+datApo+'</td>';
                cols += '<td>'+data[i].deshor+'</td>';
                cols += '<td>'+vaSituapo+'</td>';
                cols += '<td>'+datEnv+'</td>';
                cols += '<td>'+horEnv+'</td>';
                cols += '<td>'+data[i].datcan+'</td>';
                cols += '<td>'+data[i].horcan+'</td>';
                cols += '<td>'+data[i].vlrcotacao+'</td>';
                cols += '<td>'+data[i].vlrpre+'</td>';
                cols += '<td>'+data[i].vlrpalpf+'</td>';
                cols += '<td>'+data[i].vlrpalpd+'</td>';
                cols += '<td>'+data[i].vlrpresec+'</td>';
                cols += '<td>'+data[i].vlrpresmj+'</td>';
                cols += '<td>'+data[i].vlrpre+'</td>';


                newRow.append(cols);
                $("#tbody_aposta").append(newRow);
            }

            $('#vlr_aposta').val(vlrPalp.toFixed(2).replace(".", ","));
            $('#n_aposta').val(numpule);
            $('#revendedor').val(idreven);
        });

    };

    function DateChance(data) {
        var getDate = data.slice(0, 10).split('-'); //create an array
        var _date =getDate[2] +'/'+ getDate[1] +'/'+ getDate[0];
        return _date;

    }

    function time_format(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seg = date.getSeconds();
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ':' + seg;
//        return date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear() + " " + strTime;
        return strTime;
    }





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
