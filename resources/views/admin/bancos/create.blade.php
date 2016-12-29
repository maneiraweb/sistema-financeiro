@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
        <h4>Novo Banco</h4>
            {!! Form::open(['route' => 'admin.bancos.store']) !!}
                @include('admin.bancos._form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection