<?php $errorClass = $errors->first('nome') ? ['class' => 'validate invalid'] : [] ?>
<div class="row">
    <div class="input-field col s6">
        {!! Form::text('nome', null, $errorClass) !!}
        {!! Form::label('nome', 'Nome', ['data-error' => $errors->first('nome')]) !!}
    </div>
    <div class="input-field file-field col s6">
        <div class="btn">
            <span>Logo</span>
            {!! Form::file('logo') !!}
        </div>
        <div class="file-path-wrapper">
            <input type="text" class="file-path"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="input-field col s6">
        {!! Form::submit('Salvar', ['class' => 'btn waves-effect']) !!}
    </div>
</div>