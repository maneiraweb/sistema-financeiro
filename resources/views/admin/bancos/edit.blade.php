@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
        <h4>Edição de Banco</h4>
            {!! Form::model($banco, [
                        'route' => ['admin.bancos.update', 'banco' => $banco->id],
                        'method' => 'PUT',
                        'files' => true
                    ]) !!}
                @include('admin.bancos._form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection