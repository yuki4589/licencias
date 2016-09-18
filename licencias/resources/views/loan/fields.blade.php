@include('license.exposed.fields')

@include('person.exposed.fields')

<div class="form-group @if($errors->first('loan_date')) has-error @endif">
    {!! Form::label('loan_date', 'Fecha de préstamo', ['class' => 'control-label']) !!}
    @if(isset($loan))
        {!! Form::date('loan_date') !!}
    @else
        {!! Form::date('loan_date', \Carbon\Carbon::now()) !!}
    @endif
</div>

<div class="form-group @if($errors->first('giving_back_date')) has-error @endif">
    {!! Form::label('giving_back_date', 'Fecha de devolución', ['class' => 'control-label']) !!}
    @if(isset($loan))
        {!! Form::date('giving_back_date') !!}
    @else
        {!! Form::date('giving_back_date', \Carbon\Carbon::now()) !!}
    @endif
</div>