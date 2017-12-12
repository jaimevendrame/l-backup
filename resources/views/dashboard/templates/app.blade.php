<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{ asset('materialize/css/materialize.min.css') }}"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('admin/css/admin.css') }}"  media="screen,projection"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.15/css/dataTables.material.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.2.2/css/select.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    {{--<link rel='stylesheet'  href='https://cdn.datatables.net/v/dt/dt-1.10.12/se-1.2.0/datatables.min.css' type='text/css' media='all' />--}}
    <link rel='stylesheet'  href='https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.9/css/dataTables.checkboxes.css' type='text/css' media='all' />

    <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>









    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Scripts -->
    <script>
        function test(el) {
            var $lnk = document.getElementById("lnk-ideven");
            $lnk.href = $lnk.href.replace(/(.*)/, '/admin/resumocaixa/') + el.value;

            var $lnkcaixa = document.getElementById("lnk");
            $lnkcaixa.href = $lnk.href.replace(/(.*)/, '/admin/movimentoscaixa/') + el.value;

           var $lnkapostas = document.getElementById("lnk-aposta");
            $lnkapostas.href = $lnk.href.replace(/(.*)/, '/admin/apostas/') + el.value;

           var $lnkapostasview = document.getElementById("lnk-aposta-view");
            $lnkapostasview.href = $lnk.href.replace(/(.*)/, '/admin/apostas/view/') + el.value;

            var $lnkapostascancel = document.getElementById("lnk-aposta-cancel");
            $lnkapostascancel.href = $lnk.href.replace(/(.*)/, '/admin/apostas/cancel/') + el.value;

            var $lnkapostaspremio = document.getElementById("lnk-aposta-premio");
            $lnkapostaspremio.href = $lnk.href.replace(/(.*)/, '/admin/apostaspremiadas/') + el.value;

            var $lnkresultsadosorteio = document.getElementById("lnk-resul-sorteio");
            $lnkresultsadosorteio.href = $lnk.href.replace(/(.*)/, '/admin/resultadosorteio/') + el.value;

            var $lnksenhadodia = document.getElementById("lnk-senha");
            $lnksenhadodia.href = $lnk.href.replace(/(.*)/, '/admin/senhadodia/') + el.value;

            var $lnkdescenv = document.getElementById("lnk-descenv");
            $lnkdescenv.href = $lnk.href.replace(/(.*)/, '/admin/descargasenviadas/') + el.value;

            //session



        }


    </script>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>


        document.addEventListener("DOMContentLoaded", function(){
            $('.preloader-background').delay(1700).fadeOut('slow');

            $('.preloader-wrapper')
                .delay(1700)
                .fadeOut();
        });
    </script>
    <style>
        header, main, footer {
            padding-left: 300px;
        }
        @media only screen and (max-width : 992px) {
            header, main, footer {
                padding-left: 0;
            }
        }
        main {
            margin: 0px 10px 0px 10px;
        }

        .modal { width: 95% !important ; height: 95% !important ; }
    </style>


</head>
<div class="preloader-background">
    <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>
<body>

    <div id="app">

        <ul id="dropdown1" class="dropdown-content">
            <li><a href="#!">Perfil</a></li>
            <li><a href="#!">Configurações</a></li>
            <li class="divider"></li>
            @if (!Auth::guest())
            <li><a href="#!">{{ Auth::user()->email }}</a></li>
                @endif

        </ul>
        <header>
            {{--<div class="navbar-fixed">--}}
                <nav class=" blue-grey lighten-3">
                    <div class="nav-wrapper">
                        <div class="row">
                            <div class="col s2 hide-on-large-only">
                                <ul>
                                    <li>
                                        <a href="#" data-activates="slide-out" class="button-collapse">
                                            <i class="material-icons">menu</i></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col s6 m6 l6">

                                <a href="#!" class="breadcrumb">
                                    @if( isset($title) )
                                        {{$title}}
                                    @endif</a>
                                {{--<a href="#!" class="breadcrumb">Second</a>--}}
                                {{--<a href="#!" class="breadcrumb">Third</a>--}}

                            </div>

                            <div class="col s4 m6 l6">

                                <div class="navbar-header">
                                    <ul class="right">

                                        <li><a href="{{ env('URL_ADMIN_LOGOUT') }}"
                                               onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"
                                               class="tooltipped" data-position="left"
                                               data-delay="50" data-tooltip="Logout"
                                            >
                                                <i class="large material-icons">input</i>
                                            </a>
                                            <form id="logout-form" action="{{ env('URL_ADMIN_LOGOUT') }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            {{--</div>--}}
            <ul id="slide-out" class="side-nav fixed  blue-grey darken-3">
                <nav class="blue-grey darken-4">
                    <div class="container">
                        <!-- Branding Image -->
                        <a class="brand-logo" href="{{ url('/home') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                </nav>
                <li>
                    <div class="userView">
                        <div class="background">
                            <img src="{{ asset('admin/images/office.jpg') }}">
                        </div>
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <a href="#!name"><span class="white-text name">Anonimo</span></a>li>
                        @else
                            <div class="row">
                                <div class="col col s4 m4 l4">
                                    <img class="circle avatar" src="{{ asset('admin/images/user_default.jpg') }}">
                                </div>
                                <div class="col col s8 m8 l8">
                                    <a class="dropdown-button" href="#!" data-activates="dropdown1">
                                    <span class="white-text name">{{ Auth::user()->name }}
                                        <i class="material-icons right">arrow_drop_down</i>
                                    </span>
                                    </a>
                                </div>
                            </div>

                        @endif

                    </div>
                </li>
                <li>
                    <form>
                        <div class="input-field">
                            <input id="myInput" name="myInput" type="search" required>
                            <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                            <i class="material-icons">close</i>
                        </div>
                    </form>
                </li>

                </li>
                <ul class="collapsible" data-collapsible="accordion">
                    @php $m = 0;
                    foreach ($vendedores as $item){
                            if ($item->inpadrao == 'SIM'){
                                $m = $item->ideven;

                            }
                        }
                    if (session()->has('ideven')){
                    $m = session()->get('ideven');
                    }



                    @endphp

                   @php
                        foreach($categorias as $key => $value){
                        echo '<li>';
                                echo '<div class="collapsible-header active white-text"><i class="material-icons">view_quilt</i>'.$value.'</div>';
                                echo '<div class="collapsible-body blue-grey darken-4">
                                    <span>
                                        <ul>';
                                            foreach ($menus as $menu){
                                               if ($menu->catact == $value){
                                            echo '<li><a class="waves-effect white-text waves-light tooltipped"  href="'.$menu->route.'/'.$m.'" id="'.$menu->idref.'"
                                            data-position="right" data-delay="50" data-tooltip="'.$menu->capact.'"
                                            >'.$menu->capact.'</a></li>';
                                            }}

                                        echo '
                                        </ul>
                                    </span>
                                </div>';

                        echo '</li>';
                        }
                    @endphp

                </ul>
                @if(!empty($validaMesalidade))
                    @php
                        $datven = new DateTime($validaMesalidade->datven);






                        $datatual = date ("Y-m-d");
                        $datatual = new DateTime($datatual);

{{--                        echo strtotime($datatual->format('Y-m-d'))."<br>";--}}
{{--                        echo strtotime($datven->format('Y-m-d'));--}}

                        $datatualX = strtotime($datatual->format('Y-m-d'));
                        $datvenX = strtotime($datven->format('Y-m-d'));

                        $umdiaantes = $datatual->modify('-1 day');

                    @endphp
                    @if($datvenX < $datatualX)
                        <div class="row">
                            <div class="col s12 m12 l12 ">
                                <div class="card yellow">
                                    <div class="card-content">
                                        <span class="card-title center"><b>Aviso</b></span>
                                        <p class="flow">Sua mensalidade venceu em: <b>{{Carbon\Carbon::parse($validaMesalidade->datven)->format('d/m/Y')}}</b>.</p>
                                        <p class="flow">Evite o bloquei do acesso efetuando o pagamento até o dia: <b>{{Carbon\Carbon::parse($validaMesalidade->datpro)->modify('-1 day')->format('d/m/Y')}}</b>.</p>
                                        <p class="flow">Para maiores informações falar com setor financeiro</p>
                                        <p class="flow">Data para bloquieio: <b>{{Carbon\Carbon::parse($validaMesalidade->datpro)->format('d/m/Y')}}</b></p>
                                        <p></p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif


                @endif


            </ul>


        </header>


    <main>

        <body>
        <div>
            /{{\Illuminate\Support\Facades\Session::put('teste', $m)}}/
            /{{\Illuminate\Support\Facades\Session::get('teste')}}/
            @yield('content')
        </div>
        </body>


    </main>


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
        {{--fim modal padrão--}}
    <!-- Page Layout here -->

    <!-- Scripts -->
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="{{ asset('materialize/js/jquery-2.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('materialize/js/materialize.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('materialize/js/date.format.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

        <script src="{{ asset('materialize/lib/pt_BR.js') }}"></script>
<script type="application/javascript">
    $(document).ready(function(){



        // Show sideNav


        $('.dropdown-button').dropdown({
                inDuration: 300,
                outDuration: 225,
                constrainWidth: false, // Does not change width of dropdown to that of the activator
                hover: true, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: false, // Displays dropdown below the button
                alignment: 'left', // Displays dropdown with edge aligned to the left of button
                stopPropagation: false, // Stops event propagation
            }
        );


        $('select').material_select();


    });

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year


    });

    @if(empty($data[0]->dataini))
        $("#datIni").val('{{date("d/m/Y")}}');
    $("#datFim").val('{{date("d/m/Y")}}');


    @else
    $("#datIni").val('{{Carbon\Carbon::parse($data[0]->dataini)->format('d/m/Y')}}');
    $("#datFim").val('{{Carbon\Carbon::parse($data[0]->datafim)->format('d/m/Y')}}');
    @endif
</script>

@stack('modal')

{{--<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.15/api/sum().js"></script>

        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>


@stack('scripts')
<script language="javascript">
    $(document).ready(function(){
        $(".button-collapse").sideNav();
        $('.collapsible').collapsible('open', 0);

    });
</script>
</body>
</html>
