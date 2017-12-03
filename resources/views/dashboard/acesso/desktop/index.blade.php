@extends('dashboard.templates.app')

@section('content')
    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <table>
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Login</th>
                                <th>Senha</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($data))
                                @forelse($data as $u)
                                    <tr>
                                        <td>{{$u->idusu}}</td>
                                        <td>{{$u->nomusu}}</td>
                                        <td>{{$u->logusu}}</td>
                                        <td>{{$u->senusu}}</td>
                                        <td>{{$u->emausu}}</td>
                                        <td><a href="/admin/acesso/web/create/{{$u->idusu}}" class="btn"><i class="material-icons">web</i></a></td>
                                    </tr>
                                @empty
                                    <p>Nenhum registro!</p>
                                @endforelse
                            @endif
                            </tbody>
                        </table>
                        </form>
                    </div>

                </div>
            </div>
            <div class="row">


            </div>
        </div>

    </div>
@endsection