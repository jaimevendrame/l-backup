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
                        <h4>Cadastro de Revendedor</h4>
                        <div class="row">
                            <form method="post" action="/admin/revendedor/create/{{$ideven}}/add" class="col m12">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col s12 m12 l6">
                                        <ul class="tabs">
                                            <li class="tab col s6 m6 l6"><a class="active" href="#cadastro">Cadastro</a></li>
                                            <li class="tab col s6 m6 l6"><a href="#opcionais">Opcionais</a></li>
                                        </ul>
                                    </div>
                                    <div id="cadastro" class="col s12">
                                        <div class="row">
                                            {{--<div class="input-field col s8 m8 l8">--}}
                                                {{--<select class="base">--}}
                                                    {{--<option value="" disabled selected>Selecione</option>--}}
                                                    {{--@forelse($baseAll as $b)--}}
                                                        {{--@if( isset($ideven) && !empty($ideven))--}}
                                                        {{--<option value="{{ $b->idbase }}" {{ $b->ideven == $ideven  ? 'selected' : '' }}>{{ $b->nombas }} </option>--}}
                                                        {{--@else--}}
                                                        {{--<option value="{{ $b->idbase }}">{{ $b->nombas }}</option>--}}
                                                        {{--@endif--}}

                                                    {{--@empty--}}
                                                        {{--<option value="" disabled selected>Nenhuma base</option>--}}
                                                    {{--@endforelse--}}
                                                {{--</select>--}}
                                                {{--<label>Base</label>--}}
                                            {{--</div>--}}
                                            <div class="input-field col s8 m8 l6">
                                                <input id="nomebase" type="text" class="validate" readonly value="{{$baseNome}}">
                                                <label id="lnomebase" for="nomebase">Base</label>
                                            {{--</div> <div class="input-field col s4 m4 l4">--}}
                                                <input id="idbase" type="hidden" name="idbase" class="validate" readonly value="{{$idbase}}">
                                                {{--<label id="lidbase" for="idbase">Id Base</label>--}}
                                            </div>
                                            {{--<div class="input-field col m4">--}}
                                            {{--<input id="nompro" type="text" class="validate" readonly>--}}
                                            {{--<label id="lnompro" for="nompro">Nome</label>--}}
                                            {{--</div>--}}
                                            {{--<div class="input-field col m2">--}}
                                            {{--<input id="cidbas" type="text" class="validate" readonly="">--}}
                                            {{--<label id="lcidbas" for="cidbas">Cidade</label>--}}
                                            {{--</div>--}}
                                            {{--<div class="input-field col m2">--}}
                                            {{--<input id="uf" type="text" class="validate" readonly>--}}
                                            {{--<label id="luf" for="uf">UF</label>--}}
                                            {{--</div>--}}
                                        </div>
                                        <div class="row">
                                            {{--<div class="input-field col s8 m8 l8">--}}
                                                {{--<select class="vendedor">--}}
                                                    {{--<option value="" disabled selected>Selecione</option>--}}
                                                    {{--@forelse($vendedores as $v)--}}
                                                        {{--<option value="{{ $v->idven }}">{{ $v->nomven }}</option>--}}
                                                    {{--@empty--}}
                                                        {{--<option value="" disabled selected>Nenhum vendedor</option>--}}
                                                    {{--@endforelse--}}
                                                {{--</select>--}}
                                                {{--<label>Vendedor</label>--}}
                                            {{--</div>--}}
                                            <div class="input-field col s8 m8 l6">
                                                <input id="nomven" type="text" class="validate" readonly value="{{$vendedorNome}}">
                                                <label id="lnomven" for="nomven">Vendedor</label>
                                            </div>
                                            {{--<div class="input-field col s4 m4 l4">--}}
                                                <input id="idven" type="hidden" name="idven" class="validate" readonly value="{{$idvendedor}}">
                                                {{--<label id="lidven" for="idven">Id Vendedor</label>--}}
                                            {{--</div>--}}
                                            {{--<div class="input-field col m4">--}}
                                            {{--<input id="nomven" type="text" class="validate">--}}
                                            {{--<label id="lnomven" for="nomven">Vendedor</label>--}}
                                            {{--</div>--}}
                                            {{--<div class="input-field col m2">--}}
                                            {{--<input id="cidven" type="text" class="validate">--}}
                                            {{--<label id="lcidven" for="cidven">Cidade</label>--}}
                                            {{--</div>--}}
                                            {{--<div class="input-field col m2">--}}
                                            {{--<input id="ufven" type="text" class="validate">--}}
                                            {{--<label id="lufven" for="ufven">UF</label>--}}
                                            {{--</div>--}}
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l4">
                                                <input id="idereven" type="text" class="validate" name="idereven">
                                                <label for="idereven">Identificação única</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6">
                                                <input id="nomreven" type="text" class="validate" name="nomreven">
                                                <label for="nomreven">Nome</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m8 l4">
                                                <input id="cidreven" type="text" class="validate" name="cidreven">
                                                <label for="cidreven">Cidade</label>
                                            </div>

                                            <div class="input-field col s12 m4 l2">
                                                <select name="sigufs">
                                                    <option value="" disabled selected>Selecione</option>
                                                    <option value="AC">Acre</option>
                                                    <option value="AL">Alagoas</option>
                                                    <option value="AP">Amapá</option>
                                                    <option value="AM">Amazonas</option>
                                                    <option value="BA">Bahia</option>
                                                    <option value="CE">Ceará</option>
                                                    <option value="DF">Distrito Federal</option>
                                                    <option value="ES">Espírito Santo</option>
                                                    <option value="GO">Goiás</option>
                                                    <option value="MA">Maranhão</option>
                                                    <option value="MT">Mato Grosso</option>
                                                    <option value="MS">Mato Grosso do Sul</option>
                                                    <option value="MG">Minas Gerais</option>
                                                    <option value="PA">Pará</option>
                                                    <option value="PB">Paraíba</option>
                                                    <option value="PR">Paraná</option>
                                                    <option value="PE">Pernambuco</option>
                                                    <option value="PI">Piauí</option>
                                                    <option value="RJ">Rio de Janeiro</option>
                                                    <option value="RN">Rio Grande do Norte</option>
                                                    <option value="RS">Rio Grande do Sul</option>
                                                    <option value="RO">Rondônia</option>
                                                    <option value="RR">Roraima</option>
                                                    <option value="SC">Santa Catarina</option>
                                                    <option value="SP">São Paulo</option>
                                                    <option value="SE">Sergipe</option>
                                                    <option value="TO">Tocantins</option>
                                                </select>
                                                <label>UF</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l4">
                                                <input id="limcred" type="text" class="validate" name="limcred">
                                                <label for="limcred">Limite de Crédito</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l4">
                                                <input id="vlrcom" type="text" class="validate" name="vlrcom">
                                                <label for="vlrcom">Comissão Padrão %</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l4">
                                                <input id="vlrmaxpalp" type="text" class="validate" name="vlrmaxpalp">
                                                <label for="vlrmaxpalp">Vlr. Máximo p/ Palpite</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l4">
                                                <input id="vlrblopre" type="text" class="validate" name="vlrblopre">
                                                <label for="vlrblopre">Bloquear prêmio maior que</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l4">
                                                <input id="limlibpre" type="text" class="validate" name="limlibpre">
                                                <label for="limlibpre">Limite de dias para prêmio</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l4">
                                                <select name="sitreven">
                                                    <option value="" disabled selected></option>
                                                    <option value="ATIVO">ATIVO</option>
                                                    <option value="INATIVO">INATIVO</option>
                                                </select>
                                                <label>Situação</label>
                                            </div>
                                        </div>



                                    </div>
                                    <div id="opcionais" class="col s12">
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6">
                                                <input id="idreven" type="text" class="validate" name="idreven" value="{{$idreven}}">
                                                <label for="idreven">Id Revendedor</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6">
                                                <input id="endreven" type="text" class="validate" name="endreven">
                                                <label for="endreven">Endereço</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6">
                                                <input id="baireven" type="text" class="validate" name="baireven">
                                                <label for="baireven">Bairro</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6">
                                                <input id="celreven" type="text" class="validate" name="celreven">
                                                <label for="celreven">Celular</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6">
                                                <input id="obsreven" type="text" class="validate" name="obsreven">
                                                <label for="obsreven">Observação</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6">
                                                <select name="insolaut">
                                                    <option value="SIM">SIM</option>
                                                    <option value="NAO" selected>NÃO</option>
                                                </select>
                                                <label>Solicita Autênciacação p/ Liberar Prêmio</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6">
                                                <select name="idcobra">
                                                    <option value="" disabled selected>Selecione</option>

                                                    @forelse($cobrador as $c)
                                                        <option value="{{ $c->idcobra }}">{{ $c->nomcobra }}</option>
                                                    @empty
                                                        <option value="" disabled selected>Nenhum vendedor</option>
                                                    @endforelse
                                                </select>
                                                <label>Cobrador</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <input id="portacom" type="text" class="validate" name="porta_com" value="2016">
                                                <label for="portacom">Porta Comunicação</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <input id="datcad" type="date" class="datepicker" name="datcad">
                                                <label for="datcad">Data Cadastro</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <select name="in_impapo">
                                                    <option value="SIM">SIM</option>
                                                    <option value="NAO" selected>NÃO</option>
                                                </select>
                                                <label>Permissão Reimprimir Aposta</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <input id="usercad" type="text" class="validate" name="idusucad">
                                                <label for="usercad">Usuário Cadastrado</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <select name="in_canapo">
                                                    <option value="SIM">SIM</option>
                                                    <option value="NAO" selected>NÃO</option>
                                                </select>
                                                <label>Permissão Terminal Cancelar Aposta</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <input id="datalt" type="date" class="datepicker" name="datalt">
                                                <label for="datalt">Data última Alteração</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <select name="in_impdireta">
                                                    <option value="SIM">SIM</option>
                                                    <option value="NAO" selected>NÃO</option>
                                                </select>
                                                <label>Impressão direta do Bilhete</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <input id="useralt" type="text" class="validate" name="idusualt">
                                                <label for="useralt">Usuário Alteração</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6">
                                                <select name="loctrab">
                                                    <option value="" disabled selected>Selecione</option>
                                                    <option value="AMBULANTE">AMBULANTE</option>
                                                    <option value="BAR">BAR</option>
                                                    <option value="CHALE">CHALE</option>
                                                    <option value="PONTO FIXO">PONTO FIXO</option>
                                                </select>
                                                <label>Local de Trabalho</label>
                                            </div>

                                        </div>

                                                {{--<div class="col s12 m4 l2">--}}
                                                    {{--Loterias--}}
                                                {{--</div>--}}

                                    </div>
                                </div>

                                <div class="row">
                                    <button class="btn waves-effect waves-light" type="submit" >Confirmar
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </form>{{-- end form --}}
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
        <script type="text/javascript" src="{{url('js/jquery.mask.js')}}"></script>

<script>

    $(document).ready(function() {

        $('#limcred').mask('000.000.000.000.000,00', {reverse: true});
        $('#vlrcom').mask('000.000.000.000.000,00', {reverse: true});
        $('#vlrmaxpalp').mask('000.000.000.000.000,00', {reverse: true});
        $('#vlrblopre').mask('000.000.000.000.000,00', {reverse: true});
        $('#limlibpre').mask('000.000.000.000.000,00', {reverse: true});
        $('#celreven').mask('(00)00000-0000');



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
            paging:         true,
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
        <script>
            $( ".base" ).change(function() {
                urlBase = '/admin/revendedor/base/'+ this.value;
                base(urlBase);
            });

            $( ".vendedor" ).change(function() {


                var base = 0;

                base = $('#idbase').val();


                if (base == 0) {
                    alert('Selecione uma base antes');
                    return false;
                }



                urlVend = '/admin/revendedor/vendedor/'+ base +'/'+ this.value;

//                alert( urlVend);

//                return false;

                vendedor(urlVend);

            });
            function base(url) {
                jQuery.getJSON(url, function (data) {
//                    alert( data[0].nompro );
                    $('#idbase').val(data[0].idbase);
                    $('#lidbase').addClass("active");

                    $('#nompro').val(data[0].nompro);
                    $('#lnompro').addClass("active");

                    $('#cidbas').val(data[0].cidbas);
                    $('#lcidbas').addClass("active");

                    $('#uf').val(data[0].sigufs);
                    $('#luf').addClass("active");

                });
            }

            function vendedor(url) {
                jQuery.getJSON(url, function (data) {
//                    alert( data[0].nompro );
                    $('#idven').val(data[0].idven);
                    $('#lidven').addClass("active");

                    $('#nomven').val(data[0].nomven);
                    $('#lnomven').addClass("active");

                    $('#cidven').val(data[0].cidven);
                    $('#lcidven').addClass("active");

                    $('#ufven').val(data[0].sigufs);
                    $('#lufven').addClass("active");

                });
            }

        </script>
@endpush

