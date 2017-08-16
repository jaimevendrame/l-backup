@extends('dashboard.templates.app')

@section('content')
    <script>


    </script>

    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <form class="form-group" id="form-cad-edit" method="post" action="/admin/movimentoscaixa/{{$p_ideven}}" enctype="multipart/form-data">
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

                                <div class="input-field col s12 m3">
                                    <select name="sel_revendedor">
                                        <option value="" >Nenhum</option>
                                        @forelse($reven as $r)
                                            <option value="{{$r->idereven}}" @if( isset($sel_revendedor)) {{ $r->idereven == $sel_revendedor  ? 'selected' : '' }} @endif>{{$r->nomreven}}</option>
                                        @empty
                                            <option value="" disabled selected>Nenhuma Revendedor</option>
                                        @endforelse

                                    </select>
                                    <label>Revendedor</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <select name="sel_cobrador">
                                        <option value="" >Nenhum</option>
{{--                                        <option value="1" @if(isset($despesas)){{ $despesas == 'SIM'  ? 'selected' : '' }} @endif>Com Despesas</option>--}}
                                        @forelse($cobrador as $cob)
                                            <option value="{{$cob->idcobra}}"  @if(isset($sel_cobrador)) {{ $cob->idcobra == $sel_cobrador  ? 'selected' : '' }} @endif>{{$cob->nomcobra}}</option>
                                        @empty
                                            <option value="" disabled selected>Nenhuma Cobrador</option>
                                        @endforelse
                                    </select>
                                    <label>Cobradores</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">Mostrar
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                                <div class="input-field col s12 m1">
                                    <!-- Modal Trigger -->
                                    <a class="waves-effect waves-light  btn-floating red modal-trigger" href="#modal_movcaixa"><i class="material-icons">add</i></a>
                                </div>




                            </div>


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


                                foreach($data as $key) {



                                    if ( ($key->tipomov == 'RECEBIMENTO') || ($key->tipomov == 'ESTORNO REC.') || ($key->tipomov == 'DEBITO REC.') || ($key->tipomov == 'CREDITO REC.')){

                                        $recebimento += $key->vlrmov;
                                    }

                                    if ( ($key->tipomov == 'PAGAMENTO') || ($key->tipomov == 'ESTORNO PAG.') || ($key->tipomov == 'DEBITO PAG.') || ($key->tipomov == 'CREDITO PAG.')){

                                        $pagamento += $key->vlrmov;
                                    }

                                    if ( ($key->tipomov == 'DESPESA') ){

                                        $despesas += $key->vlrmov;
                                    }


                                            }
                            @endphp

                            </tfoot>


                        </table>
                        <div class="row"></div>

                        <div class="row">

                            <div class="col s3 ">
                                <div class="col s10 z-depth-2 green hoverable">
                                    <div class="row left-align">
                                        <h5 class="white-text">
                                            Total Recebimento:
                                        </h5>
                                    </div>
                                    <div class="row right-align">
                                        <h5 class="white-text">@php echo number_format($recebimento, 2, ',', '.'); @endphp</h5>
                                    </div>
                                </div>

                            </div>
                            <div class="col s3">
                                <div class="col s10 z-depth-2 red darken-1 hoverable">
                                    <div class="row white-text left-align">
                                        <h5>
                                            Total Pagamento:
                                        </h5>
                                    </div>
                                    <div class="row white-text right-align">
                                        <h5>@php echo number_format($pagamento, 2, ',', '.'); @endphp</h5>
                                    </div>
                                </div>

                            </div>
                            <div class="col s3">
                                <div class="col s10 z-depth-2 orange hoverable">
                                    <div class="row white-text left-align">
                                        <h5>
                                            Despesas:
                                        </h5>
                                    </div>
                                    <div class="row white-text right-align">
                                        <h5>@php echo number_format($despesas, 2, ',', '.'); @endphp</h5>
                                    </div>
                                </div>

                            </div>
                            <div class="col s3">
                                <div class="col s12 z-depth-2 teal hoverable">
                                    <div class="row white-text left-align">
                                        <h5>
                                            Saldo Caixa:
                                        </h5>
                                    </div>
                                    <div class="row white-text right-align">
                                        <h5>@php echo number_format($recebimento - $pagamento, 2, ',', '.');  @endphp</h5>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>


    <script>
        $(function () {
            jQuery("#form-add-mov").submit(function () {


                alert('ok');
                return false;

                var dadosForm = jQuery(this).serialize();

                jQuery.ajax({
                    url: 'add-contato',
                    data: dadosForm,
                    method: 'POST',
                    beforeSend: iniciaPreloader()


                }).done(function (data) {

                    finalizaPreloader();

                    if (data == '1') {
                        jQuery(".contato-errors-msg").hide();

//                    jQuery(".screen").hide();

                        jQuery(".contato-success-msg").html(
                            "<h4>Sua mensagem foi enviada com sucesso!</h4><br>" +
                            "<h4>Aguarde que entraremos em contato</h4>"
                        );
                        jQuery(".contato-success-msg").show();
                        $("#especializati-form").trigger("reset");

                        setTimeout(" jQuery('.contato-success-msg').hide();", 5000);

                    } else {
                        jQuery(".contato-errors-msg").html(data);
                        jQuery(".contato- errors-msg").show();
                    }
                }).fail(function () {
                    finalizaPreloader();
                    alert('Falha ao enviar dados!!');
                });


                return false;
            });

        });
    </script>

    <!-- Modal Structure -->
    <div id="modal_movcaixa" class="modal modal-fixed-footer">
        <div class="right-align">
            <a href="#!" class=" btn modal-action modal-close waves-effect waves-light red "><i class=" Tiny material-icons">close</i></a>
        </div>
        <div class="modal-content">

            <h4>Movimentar Caixa de Revendedor</h4>
            <form id="myform">
                <div class="row">
                    <div class="input-field col s12 m4 l2">
                        <select name="movcaixa_sel_revendedor" id="movcaixa_sel_revendedor">
                            <option value="0" selected>Nenhum</option>
                            @forelse($data_movcax as $r)
                                <option value="{{$r->idreven}}" data-saldo="{{number_format($r->vlrdevatu, 2, ',', '.') }}" >{{$r->nomreven}}</option>
                            @empty
                                <option value="" disabled selected>Nenhuma Revendedor</option>
                            @endforelse

                        </select>
                        <label>Revendedor</label>
                    </div>
                    <div class="input-field col s12 m4 l2">
                        <input readonly id="saldoatu" placeholder="0,00" type="text" class="validate">
                        <label class="active" for="saldoatu">Saldo Atual</label>
                    </div>
                    <div class="input-field col s12 m4 l2">
                        <select name="movcaixa_sel_cobrador" id="movcaixa_sel_cobrador">
                            <option value="" >Nenhum</option>
                            @forelse($cobrador as $cob)
                                <option value="{{$cob->idcobra}}"  @if(isset($sel_cobrador)) {{ $cob->idcobra == $sel_cobrador  ? 'selected' : '' }} @endif>{{$cob->nomcobra}}</option>
                            @empty
                                <option value="" disabled selected>Nenhuma Cobrador</option>
                            @endforelse
                        </select>
                        <label>Cobradores</label>
                    </div>
                    <div class="input-field col s12 m4 l2">
                        <input placeholder="Valor" id="vlrmov" type="text" class="validate">
                        <label for="first_name">Valor</label>
                    </div>
                    <div class="input-field col s12 m12 l3">
                        <button type="reset" class="reset btn waves-effect green waves-light tooltipped" onclick="addMov('R')" data-position="top" data-delay="50" data-tooltip="Recebimento">R</button>
                        <button type="reset"  class="reset btn waves-effect red waves-light tooltipped" onclick="addMov('P')" data-position="top" data-delay="50" data-tooltip="Pagamento">P</button>
                        <button type="reset" class="reset btn waves-effect orange waves-light tooltipped" onclick="addMov('D')" data-position="top" data-delay="50" data-tooltip="Despesa">D</button>
                    </div>

                </div>

            </form>
            <form class="form-group" id="form-add-mov" method="post" action="/admin/movimentoscaixa2" enctype="multipart/form-data">
                {{ csrf_field() }}

            <div id="scroll">
                    <table id="products-table">
                        <thead >
                        <tr>
                            <th>Revendedor</th>
                            <th>Saldo Atual</th>
                            <th>Valor Movimento</th>
                            <th>Saldo Resultado</th>
                            <th>Tipo Movimento</th>
                            <th>Cobrador</th>
                            <th>Ações</th>
                        </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>

            </div>


        </div>
        <div class="modal-footer">
            {{--<a href="#!" class=" btn modal-action  waves-effect waves-green" onclick="enviarDados()">Salvar Movimento</a>--}}
            <button class="btn waves-effect waves-light" type="submit" >Salvar Movimento
                <i class="material-icons right">send</i>
            </button>
        </div>
    </form>
    </div>

@endsection

@push('scripts')

<script>
    $(function () {
        jQuery("#form-add-mov").submit(function () {

            var dadosForm = jQuery(this).serialize();


            confirm("Salvar a movimentação")
            alert(dadosForm);

            jQuery.ajax({
                url: '/admin/movimentoscaixa2',
                data: dadosForm,
                method: 'POST'


            }).done(function (data) {


                if (data == '1') {

                    alert('Movimentação salva com sucesso');

                    setTimeout("location.reload();", 5000);

                } else {
                    alert('Falha ao cadastrar movimentação!!');

                }
            }).fail(function () {
                alert('Falha ao enviar dados!!');


            });
            alert("Form ok!!");
            return false
        });
    });
</script>
<script type="text/javascript" src="{{url('js/jquery.mask.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numbro//min/languages.min.js"></script>



<script>

        $(document).ready(function() {


            $('#saldoatu').mask('000.000,00');
            $('#vlrmov').mask('000.000.000.000.000,00', {reverse: true});


            $('#movcaixa_sel_revendedor').change(function(){
                $('#saldoatu').val($(this).find(':selected').data('saldo'));
                var valor = $("#saldoatu").val().replace(/\./g, "").replace(",", ".");

                if (parseFloat(valor) < 0){
                $('#saldoatu').css('color', '#FF0000')}
                else if (parseFloat(valor) > 0){
                    $('#saldoatu').css('color', 'green')
                } else {
                    $('#saldoatu').css('color', 'black')
                }

            });



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
                        'excelHtml5',
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



        // remover linha
        (function($) {
            remove = function(item) {
                var tr = $(item).closest('tr');

                tr.fadeOut(400, function() {
                    tr.remove();
                });

                return false;
            }
        })(jQuery);

        //adicionar linha

        function addMov(el) {

            if ($("#movcaixa_sel_revendedor :selected").val() == 0){
                Materialize.toast('Selecione um Revendedor!', 3000)
                return false;
            }

            if ($("#vlrmov").val() == ''){
                Materialize.toast('Digite um valor de movimento!', 3000)
                return false;
            }

            var newRow = $("<tr>");
            var cols = "";

            var idreven = $("#movcaixa_sel_revendedor :selected").val();
            var revendedor = $("#movcaixa_sel_revendedor :selected").text();
            var saldo = $("#saldoatu").val().replace(/\./g, "").replace(",", ".");
            var vlrmov = $("#vlrmov").val().replace(/\./g, "").replace(",", ".");
            var cobrador = $("#movcaixa_sel_cobrador :selected").text();
            var idbase = "<?php echo $p->idbase; ?>";
            var idven = "<?php echo $p->idven; ?>";
            var idusu = "<?php echo $idusu; ?>";
            var idcobra = $("#movcaixa_sel_cobrador :selected").val();

            if (el == 'P'){
                var saldoresul = parseFloat(saldo) + parseFloat(vlrmov);
                var tipomov = '<input readonly type="text" class="red white-text center-align" name="tipomov[]" value="PAGAMENTO"/> ';
            }
            if(el == 'R'){
                var saldoresul = saldo - vlrmov;
                var tipomov = '<input readonly type="text" class="green white-text center-align" name="tipomov[]" value="RECEBIMENTO"/> ';

            }
            if(el == 'D'){
                var saldoresul = parseFloat(saldo) - parseFloat(vlrmov);
                var tipomov = '<input readonly type="text" class="orange white-text center-align" name="tipomov[]" value="DESPESAS"/> ';

            }



//            cols += '<td data-idreven="'+$("#movcaixa_sel_revendedor :selected").val()+'">'+ $("#movcaixa_sel_revendedor :selected").text() +'</td>';
//            cols += "<td>"+ $("#saldoatu").val()  +"</td>"
//            cols += "<td>"+ $("#vlrmov").val() + "</td>";
//            cols += '<td data-idcobra="'+ $("#movcaixa_sel_cobrador :selected").val() +'">'+ $("#movcaixa_sel_cobrador :selected").text() +'</td>';

            cols += '<td><input type="hidden" name="idbase[]" value="'+ idbase +'">' +
                '<input type="hidden" name="idven[]" value="'+idven+'">' +
                '<input type="hidden" name="idreven[]" value="'+idreven+'">' +
                '<input readonly type="text" name="revendedor[]" value="'+ revendedor +'"/></td>';
            cols += '<td><input readonly type="text" id="saldoatu2" name="saldoatu[]" value="'+saldo.replace(".", ",")+'"/></td>';
            cols += '<td><input readonly type="text" name="vlrmov[]" value="'+ parseFloat(vlrmov).toFixed(2).replace(".", ",")+'"/></td>';
            cols += '<td><input readonly type="text" name="saldoresul[]" value="'+ saldoresul.toFixed(2).replace(".", ",")+'"/></td>';
            cols += '<td>'+tipomov+'</td>';
            cols += '<td><input type="hidden" name="idusu[]" value="'+ idusu +'">' +
                '<input type="hidden" name="idcobra[]" value="'+ idcobra +'">' +
                '<input readonly type="text" name="cobrador[]" value="'+cobrador+'"/></td>';
            cols += '<td>';
            cols += '<button class="btn waves-effect waves-light grey" onclick="remove(this)" type="button"><i class="material-icons">delete</i></button>';
            cols += '</td>';

            newRow.append(cols);
            $("#products-table").append(newRow);

//            $('#saldoatu2').mask('000,00');



            return false;
        }









</script>

@endpush



