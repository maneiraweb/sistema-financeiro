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
                        <td>
                            
                                    <img src="{{asset("storage/bancos/images/{$banco->logo}")}}" class="banco-logo"/>
                         
                                <div>{{ $banco->nome }}</div>
                       
                        </td>
                        <td>
                            <a href="{{route('admin.bancos.edit', ['banco' => $banco->id])}}">Editar</a>
                            |
                            <delete-action action="{{route('admin.bancos.destroy',['banco' => $banco->id])}}" action-element="link-delete-{{$banco->id}}" csrf-token="{{csrf_token()}}">
								<?php $modalId = "modal-delete-$banco->id";?>
                                <a id="link-modal-{{$banco->id}}" href="#{{$modalId}}">Excluir</a>
                                <modal :modal="{{json_encode(['id' => $modalId])}}" style="display:none">
                                    <div slot="content">
                                        <h5><strong>Deseja excluir este banco?</strong></h5><br>
                                        <div class="divider"></div>
                                        <p>Nome: <strong>{{$banco->nome}}</strong></p>
                                        <div class="divider"></div>
                                    </div>
                                    <div slot="footer">
                                        <button class="btn btn-flat waves-effect green lighten-2 modal-close modal-action" id="link-delete-{{$banco->id}}">Sim</button>     
                                        <button class="btn btn-flat waves-effect modal-close modal-action">Não</button>
                                    </div>
                                </modal>
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