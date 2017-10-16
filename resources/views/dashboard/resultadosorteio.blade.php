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

                                {{--<div class="input-field col s12 m6 l4">--}}
                                    {{--<select multiple name="sel_vendedor[]">--}}
                                        {{--<option value="" disabled selected>Selecionar Vendedores</option>--}}
                                        {{--@forelse($baseAll as $bases)--}}
                                            {{--@if( isset($ideven) && !empty($ideven))--}}
                                            {{--<option value="{{$bases->ideven}}" {{ $bases->ideven == $ideven  ? 'selected' : '' }} >{{$bases->ideven}}-{{$bases->nomven}}</option>--}}
                                                {{--@elseif(isset($ideven2) && (is_array($ideven2))) <option value="{{$bases->ideven}}" @forelse($ideven2 as $select) {{ $bases->ideven == $select  ? 'selected' : '' }} @ @empty @endforelse >{{$bases->ideven}}-{{$bases->nomven}}</option>--}}
                                             {{--@else<table class="col m4">--}}
                                                {{--<thead>--}}
                                                    {{--<tr>--}}
                                                        {{--<th>{{$sorteio->dessor}}</th>--}}
                                                    {{--</tr>--}}
                                                {{--</thead>--}}
                                                {{--<tbody>--}}
                                                {{--<tr>--}}
                                                    {{--<td>llll</td>--}}
                                                {{--</tr>--}}
                                                {{--</tbody>--}}

                                            {{--</table>--}}
                                                {{--<option value="{{$bases->ideven}}">{{$bases->ideven}}-{{$bases->nomven}}</option>--}}
                                            {{--@endif--}}
                                        {{--@empty--}}
                                            {{--<option value="" disabled selected>Nenhuma base</option>--}}
                                        {{--@endforelse--}}

                                    {{--</select>--}}
                                    {{--<label>Bases selecionadas</label>--}}
                                {{--</div>--}}

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



