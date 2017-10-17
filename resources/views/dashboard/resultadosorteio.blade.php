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
                                    @if($linhas >= 6)
                                        <div class="input-field col s4 m1 l1">

                                            <input type="checkbox" id="col6" name="col6" value="7"/>
                                            <label for="col6">6º</label>
                                        </div>
                                    @endif
                                    @if($linhas >= 7)
                                    <div class="input-field col s4 m1 l1">
                                        <input type="checkbox" id="col7" name="col7" value="8"/>
                                        <label for="col7">7º</label>
                                    </div>
                                    @endif
                                    @if($linhas >= 8)
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

                            @if(!empty($data))

                                @forelse($data as $key)

                                    <div class="row">
                                        {{--<div class="col s12 m12 l12">--}}
                                        <div class="card">
                                            <div class="card-content">
                                                <span class="card-title"><b>{{$key->deslot}}</b></span>
                                                <div class="scroll_h">
                                                    <div class="row">
                                                        @forelse($sorteios as $sorteio)
                                                            @if($sorteio->idlot == $key->idlot)
                                                                <div class="card-custom">
                                                                    <div class="card">

                                                                        @if($sorteio->idlot == 4)
                                                                            <table>
                                                                                <tr>
                                                                                    <th>{{$sorteio->dez1}}</th>
                                                                                    <th>{{$sorteio->dez2}}</th>
                                                                                    <th>{{$sorteio->dez3}}</th>
                                                                                    <th>{{$sorteio->dez4}}</th>
                                                                                    <th>{{$sorteio->dez5}}</th>
                                                                                </tr>
                                                                            </table>
                                                                        @elseif($sorteio->idlot == 5)
                                                                            <table>
                                                                                <tr>
                                                                                    <th>{{$sorteio->dez1}}</th>
                                                                                    <th>{{$sorteio->dez2}}</th>
                                                                                    <th>{{$sorteio->dez3}}</th>
                                                                                    <th>{{$sorteio->dez4}}</th>
                                                                                    <th>{{$sorteio->dez5}}</th>
                                                                                    <th>{{$sorteio->dez6}}</th>
                                                                                </tr>
                                                                            </table>
                                                                        @else
                                                                            <span class="card-title"><b>{{$sorteio->dessor}}</b></span>
                                                                            <table class="">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Prêmio</th>
                                                                                    <th>Resultado</th>
                                                                                    <th>Grupo</th>
                                                                                    <th></th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                @forelse($sorteioite as $ite)
                                                                                    @if($ite->idsor == $sorteio->idsor)
                                                                                        @if($ite->seqsor < $linhas)
                                                                                            <tr>
                                                                                                <td>{{$ite->desseq}}</td>
                                                                                                <td>{{$ite->milsor}}</td>
                                                                                                <td>{{$ite->gru}}</td>
                                                                                                <td>{{$ite->desgru}}</td>
                                                                                            </tr>
                                                                                        @elseif($ite->seqsor == 9)
                                                                                            <tr>
                                                                                                <td>{{$ite->desseq}}</td>
                                                                                                <td>{{$ite->milsor}}</td>
                                                                                                <td>{{$ite->gru}}</td>
                                                                                                <td>{{$ite->desgru}}</td>
                                                                                            </tr>
                                                                                        @elseif($ite->seqsor == 10)
                                                                                            <tr>
                                                                                                <td>{{$ite->desseq}}</td>
                                                                                                <td colspan="3">{{$ite->super5}}</td>
                                                                                            </tr>
                                                                                        @endif
                                                                                    @endif
                                                                                @empty
                                                                                    <p>Sem dados!</p>
                                                                                @endforelse
                                                                                </tbody>
                                                                            </table>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @empty
                                                            <p>Sem dados!</p>
                                                        @endforelse
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        {{--</div>--}}
                                    </div>
                                @empty
                                    <p>nada</p>
                                @endforelse


                            @endif

                        </form>

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
        @if(empty($sorteios[0]->dataini))
            $("#datIni").val('{{date("d/m/Y")}}');
        @else
            $("#datIni").val('{{Carbon\Carbon::parse($sorteios[0]->dataini)->format('d/m/Y')}}');
        @endif


    });
</script>
@endpush



