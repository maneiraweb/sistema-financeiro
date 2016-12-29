@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h4>Listagem de Bancos</h4>
            <a href="{{route('admin.bancos.create')}}" class="btn waves-effect">Novo Banco</a>
            <table class="bordered striped highlight centered responsive-table z-depth-1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bancos as $banco)
                    <tr>
                        <td>{{ $banco->id }}</td>
                        <td>{{ $banco->nome }}</td>
                        <td>
                            <a href="{{route('admin.bancos.edit', ['banco' => $banco->id])}}">Editar</a>
                            |
                            <delete-action action="{{route('admin.bancos.destroy',['banco' => $banco->id])}}" action-element="link-delete-{{$banco->id}}" csrf-token="{{csrf_token()}}">
								<a id="link-delete-{{$banco->id}}" href="{{route('admin.bancos.destroy',['banco' => $banco->id])}}">Excluir</a>
							</delete-action>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $bancos->links() !!}
        </div>
    </div>
@endsection