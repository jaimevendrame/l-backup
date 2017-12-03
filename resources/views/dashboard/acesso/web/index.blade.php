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

</head>
<body>
<h1>Usuários Web</h1>

<div class="container">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>USERNAME</th>
            <th>Email</th>
            <th>Senha</th>
            <th>ID Usuario Desktop</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($data))
            @forelse($data as $u)
                <tr>
                    <td>{{$u->id}}</td>
                    <td>{{$u->name}}</td>
                    <td>{{$u->email}}</td>
                    <td>******</td>
                    <td>{{$u->idusu}}</td>
                    <td><a href="" class="btn"><i class="material-icons">web</i></a></td><td>
                </tr>
            @empty
                <p>Nenhum registro!</p>
            @endforelse
        @endif
        </tbody>
    </table>
</div>

<script type="text/javascript" src="{{ asset('materialize/js/jquery-2.1.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('materialize/js/materialize.min.js') }}"></script>
</body>
</html>