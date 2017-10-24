@extends('dashboard.templates.app')

@section('content')
    <div class="section">
        <div class="row">
            <div class="col s4 m4 l4">
                <div class="card">

                    <div class="card-content blue-grey darken-2">
                        <span class="card-title center white-text"><b>Movimentar Caixa:</b></span>
                        <div class="card-action">
                        @forelse($data as $s)
                                <h1 class="center-align white-text"><b>{{$s->baixa_caixa}}</b></h1>
                            @empty
                        @endforelse
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">


            </div>
        </div>

    </div>

@endsection

@push('scripts')




<script>
    $(document).ready(function() {

    });
</script>
@endpush



