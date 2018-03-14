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

