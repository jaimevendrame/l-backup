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



    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
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
    </style>
</head>
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
                            <img src="images/office.jpg">
                        </div>
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <a href="#!user"><img class="circle" src="images/user_default.jpg"></a>
                            <a href="#!name"><span class="white-text name">Anonimo</span></a>li>
                        @else
                            <div class="row">
                                <div class="col col s4 m4 l4">
                                    <img class="circle avatar" src="images/user_default.jpg">
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
                <ul class="collapsible" data-collapsible="accordion">

                   @php
                        foreach($categorias as $key => $value){
                        echo '<li>';
                                echo '<div class="collapsible-header active white-text"><i class="material-icons">view_quilt</i>'.$value.'</div>';
                                echo '<div class="collapsible-body blue-grey darken-4">
                                    <span>
                                        <ul>';
                                            foreach ($menus as $menu){
                                               if ($menu->catact == $value){
                                            echo '<li><a class="waves-effect white-text waves-light tooltipped"  href="'.$menu->route.'"
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


            </ul>
        </header>


    <main>
        <div>
            @yield('content')
        </div>

    </main>

<footer class="page-footer blue-grey lighten-3">
    <div class="footer-copyright">
        <div class="container">
            © 2017 {{ config('app.name', 'Laravel') }} - jsource.dev
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
        </div>
    </div>
</footer>


        {{--modal padrão--}}
    <!-- Modal Trigger -->
        {{--<a class="waves-effect waves-light btn" href="#modal1">Modal</a>--}}

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
        <script src="{{ asset('materialize/lib/pt_BR.js') }}"></script>
<script type="application/javascript">
    $(document).ready(function(){
        // Show sideNav

        $(".button-collapse").sideNav();

        $('.dropdown-button').dropdown({
                inDuration: 300,
                outDuration: 225,
                constrainWidth: false, // Does not change width of dropdown to that of the activator
                hover: true, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: false, // Displays dropdown below the button
                alignment: 'left', // Displays dropdown with edge aligned to the left of button
                stopPropagation: false // Stops event propagation
            }
        );
        $('.modal').modal();

        $('select').material_select();


    });

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
    });


</script>
{{--<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.15/api/sum().js"></script>

        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>


<script>
    $(document).ready(function() {
        var table = $('#example').DataTable( {
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1

            },


            dom: 'Brtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ],
//            columns: [
//                { data: "Revendedor" },
//                { data: "Saldo Anterior", className: "sum" },
//                { data: "Vendido", className: "sum" },
//                { data: "Comissão", className: "sum" },
//                { data: "Liquido", className: "sum" },
//                { data: "Prêmio", className: "sum" },
//                { data: "Despesas", className: "sum" },
//                { data: "Lucro", className: "sum" },
//                { data: "Pagamento", className: "sum" },
//                { data: "Recebimento", className: "sum" },
//                { data: "Última Venda" },
//                { data: "Saldo Atual", className: "sum" }
//
//            ],
//            "footerCallback": function(row, data, start, end, display) {
//                var api = this.api();
//
//                var intVal = function ( i ) {
//                    return typeof i === 'string' ?
//                        i.replace(/[\$,.]/g, '')*1 :
//                        typeof i === 'number' ?
//                            i : 0;
//                };
//
//                var numFormat = $.fn.dataTable.render.number( '.', ',', 2).display;
//
//
//                api.columns('.sum', { page: 'current' }).every(function () {
//                    var sum = api
//                        .cells( null, this.index(), { page: 'current'} )
//                        .render('display')
//                        .reduce(function (a, b) {
//                            var x = intVal(a) || 0;
//                            var y = intVal(b) || 0;
//                            return x + y;
//                        }, 0);
//                    console.log(this.index() +' '+ sum);
////                    alert(sum);
//                    $(this.footer()).html((numFormat(parseInt(sum)/100)));
//                    $( api.columns( 1 ).footer() ).html( (numFormat(parseInt(sum)/100)));
//                });
//            },

            scrollY: 380,
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            Bfilter:        false,
            "aaSorting": [[0, "desc"]],


            columnDefs: [
                {
                    targets: [ 0, 1, 2 ,3 ,4 ,5 ,6 ,7 ,8 ,9 ,10 ,11],
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


//        new $.fn.dataTable.Buttons( table, {
//            buttons: [
//                'copy', 'excel', 'pdf'
//            ]
//        } );
//
//
//        table.buttons().container()
//            .appendTo( $('.botao', table.table().container() ) );
    });







</script>
</body>
</html>
