<div class="row">
    <div class="input-field col s6">
        {!! Form::label('nome', 'Nome') !!}
        {!! Form::text('nome', null) !!}
    </div>
</div>
<div class="row">
    <div class="input-field col s6">
        {!! Form::submit('Salvar', ['class' => 'btn waves-effect']) !!}
    </div>
</div>