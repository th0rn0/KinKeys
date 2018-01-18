@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Submit Keyboard</div>
                <div class="panel-body">
                    {{ Form::open(array('url' => 'keyboards', 'files' => 'true')) }}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::label('name', 'Name') }}
                            {{ Form::text('name', old('name'), array('class' => 'form-control')) }}
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('desc_short') ? ' has-error' : '' }}">
                            {{ Form::label('desc_short', 'Short Description') }}
                            {{ Form::text('desc_short', old('desc_short'), array('class' => 'form-control')) }}
                            @if ($errors->has('desc_short'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('desc_short') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('desc_long') ? ' has-error' : '' }}">
                            {{ Form::label('desc_long', 'Long Description') }}
                            {{ Form::text('desc_long', old('desc_long'), array('class' => 'form-control')) }}
                            @if ($errors->has('desc_long'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('desc_long') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('Images') }}
                            {{ Form::file('images[]', ['multiple' => 'multiple']) }}
                        </div>

                        {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
