@extends('dashboard.templates.app')

@section('content')
    <script src="{{url('assets/js/jquery-3.2.0.min.js')}}"></script>
    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <form class="form-group" id="form-cad-edit" method="post" action="/admin/resultadosorteio/{{$ideven}}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row" style="margin-bottom:0px;">

                                <div class="input-field col s6 m4 l2">

                                        <input  id="datIni" name="datIni" type="date" class="datepicker"
                                                placeholder ="Data inicial"  >

                                </div>
                                @if(isset($linhas))
                                    @if($col >= 6)
                                        <div class="input-field col s4 m1 l1">

                                            <input type="checkbox" id="col6" name="col6" value="7"/>
                                            <label for="col6">6º</label>
                                        </div>
                                    @endif
                                    @if($col >= 7)
                                    <div class="input-field col s4 m1 l1">
                                        <input type="checkbox" id="col7" name="col7" value="8"/>
                                        <label for="col7">7º</label>
                                    </div>
                                    @endif
                                    @if($col >= 8)
                                        <div class="input-field col s4 m1 l1">
                                        <input type="checkbox" id="col8" name="col8" value="9"/>
                                        <label for="col8">8º</label>
                                    </div>
                                    @endif
                                @endif





                                <div class="input-field col s12 m6 l2">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">Atualizar
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>


                            </div>
                            <div class="clearfix"></div>

                        </form>


@php
$x = 0;
$y = 0;

if (!empty($valor)){





    foreach ($valor as $key =>$loteria){
        if($loteria['idlot'] != $x){

            echo '<div class="row">';
                echo '<div class="col s12 m12 l12">';
                    echo '<div class="card">';
                        echo '<div class="card-content">';
                              echo '<span class="card-title"><b>'.$loteria['deslot'].'</b></span>';
                                $x = $loteria['idlot'];

                                echo '<div class="scroll_h">';
                                    echo ' <div class="row">';
                                        foreach ($valor as $key =>$sorteio){
                                        if($sorteio['idlot'] == $loteria['idlot'] && $sorteio['idsor'] != $y){
                                            echo '<div class="card-custom">';
                                                echo '<div class="card">';
                                                    $y = $sorteio['idsor'];

                                                    if ($sorteio['idlot'] == 4){


                                                            echo "<table>";
                                                            echo '<tr>';
                                                            echo '<th>'. $sorteio['dez1'] . '</th>';
                                                            echo '<th>'. $sorteio['dez2'] . '</th>';
                                                            echo '<th>'. $sorteio['dez3'] . '</th>';
                                                            echo '<th>'. $sorteio['dez4'] . '</th>';
                                                            echo '<th>'. $sorteio['dez5'] . '</th>';

                                                            echo '</tr>';
                                                            echo "</table>";

                                                            }
                                                            elseif($sorteio['idlot'] == 5){

                                                            echo "<table>";
                                                            echo '<tr>';
                                                            echo '<th>'. $sorteio['dez1'] . '</th>';
                                                            echo '<th>'. $sorteio['dez2'] . '</th>';
                                                            echo '<th>'. $sorteio['dez3'] . '</th>';
                                                            echo '<th>'. $sorteio['dez4'] . '</th>';
                                                            echo '<th>'. $sorteio['dez5'] . '</th>';
                                                            echo '<th>'. $sorteio['dez6'] . '</th>';

                                                            echo '</tr>';
                                                            echo "</table>";

                                                            }
                                                            else {


                                                            echo '<span class="card-title"><b>'. $sorteio['dessor'] . '</b></span>';
                                                            echo '<table class="tbsorteio">';
                                                            echo '<thead>';
                                                            echo '<th>Prêmio</th>';
                                                            echo '<th>Resultado</th>';
                                                            echo '<th>Grupo</th>';
                                                            echo '<th></th>';
                                                            echo '</thead>';
                                                            echo '</tbody>';

                                                                foreach ($valor as $key =>$ite){
                                                                if ($ite['idsor'] == $sorteio['idsor']){

                                                                    if ( ($ite['seqsor'] < $linhas) || ($ite['seqsor'] < 6) )
                                                                    {
                                                                    echo "<tr>";
                                                                    echo "<td>".$ite['desseq']."</td>";
                                                                    echo "<td>".$ite['milsor']."</td>";
                                                                    echo "<td>".$ite['gru']."</td>";
                                                                    echo "<td>".$ite['desgru']."</td>";
                                                                    echo "</tr>";
                                                                    } elseif ($ite['seqsor'] == 9)
                                                                    {
                                                                    echo "<tr>";
                                                                    echo "<td>".$ite['desseq']."</td>";
                                                                    echo "<td>".$ite['milsor']."</td>";
                                                                    echo "<td>".$ite['gru']."</td>";
                                                                    echo "<td>".$ite['desgru']."</td>";
                                                                    echo "</tr>";
                                                                    }
                                                                    elseif ($ite['seqsor'] == 10)
                                                                    {
                                                                    echo "<tr>";
                                                                    echo "<td>".$ite['desseq']."</td>";
                                                                    echo "<td colspan='3'>".$ite['super5']."</td>";
                                                                    echo "</tr>";
                                                                    }




                                                                }

                                                                }
                                                                echo "</tbody>";
                                                                echo "</table>";
                                                            }
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                        }
                                    echo '</div>';
                                echo '</div>';


                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
}
@endphp

                    </div>

                </div>
            </div>
            <div class="row">


            </div>
        </div>

    </div>

@endsection

@push('scripts')

<script type="text/javascript" src="{{url('js/jquery.mask.js')}}"></script>




<script>
    $(document).ready(function() {

        $('.carousel.carousel-slider').carousel({fullWidth: true});


        //Set data
        @if(empty($datainicial))
            $("#datIni").val('{{date("d/m/Y")}}');
        @else
            $("#datIni").val('{{$datainicial}}');
        @endif


    });
</script>
@endpush



