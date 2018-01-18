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
                <div class="panel-heading">Keyboards</div>
                <div class="panel-body">
                    @foreach($keyboards as $keyboard)
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <a href="/keyboards/{{ $keyboard->slug }}">
                                    <img src="/storage/{{ $keyboard->getFeatureImage() }}" class="img img-thumbnail" />
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <h4><a href="/keyboards/{{ $keyboard->slug }}">{{ $keyboard->name }}</a></h4>
                                <p>{{ $keyboard->desc_short }}</p>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <h4>Votes</h4>
                                <p>{{ $keyboard->getVoteCount() }}</p>
                                @if($keyboard->votes()->where([['user_id', Auth::id()], ['positive', true], ['negative', false]])->first() == null )
                                    {{ Form::open(array('url' => 'keyboards/' . $keyboard->slug . '/vote', 'files' => 'true')) }}
                                        <input type="hidden" name="vote" id="vote" value="up"/> 
                                        {{ Form::submit('Up', array('class' => 'btn btn-primary')) }}
                                    {{ Form::close() }}
                                @endif
                                <br>
                                @if($keyboard->votes()->where([['user_id', Auth::id()], ['positive', false], ['negative', true]])->first() == null )
                                    {{ Form::open(array('url' => 'keyboards/' . $keyboard->slug . '/vote', 'files' => 'true')) }}
                                        <input type="hidden" name="vote" id="vote" value="down"/> 
                                        {{ Form::submit('Down', array('class' => 'btn btn-primary')) }}
                                    {{ Form::close() }}
                                @endif
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
