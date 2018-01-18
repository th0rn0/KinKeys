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
            <img src="/storage/{{ $keyboard->getFeatureImage() }}" class="img img-responsive" />
            <div class="panel panel-default">
                <div class="panel-heading">{{ $keyboard->name }} - <small>Posted by {{ $keyboard->user->name }} on {{ $keyboard->created_at }}</small></div>
                <div class="panel-body">
                    {{ Form::open(array('url' => 'keyboards/' . $keyboard->slug . '/update', 'files' => 'true')) }}
                        {{ Form::label('name', 'Name') }}
                        {{ Form::text('name', $keyboard->name, array('class' => 'form-control')) }}
                        {{ Form::label('desc_short', 'Short Description') }}
                        {{ Form::text('desc_short', $keyboard->desc_short, array('class' => 'form-control')) }}
                        {{ Form::label('desc_long', 'Long Description') }}
                        {{ Form::text('desc_long', $keyboard->desc_long, array('class' => 'form-control')) }}
                        <hr>
                        @foreach($keyboard->images as $image)
                            <img src="/storage/{{ $image->path }}" width="50%" class="img img-responsive" />
                            {{ Form::label('images['.$image->id.'][name]', 'Name') }}
                            {{ Form::text('images['.$image->id.'][name]', $image->name, array('class' => 'form-control')) }}
                            {{ Form::label('images['.$image->id.'][desc]', 'Description') }}
                            {{ Form::text('images['.$image->id.'][desc]', $image->desc, array('class' => 'form-control')) }}
                            <hr>
                        @endforeach
                        {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
