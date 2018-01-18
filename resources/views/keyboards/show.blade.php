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
                <div class="panel-heading">
                    {{ $keyboard->name }} - <small>Posted by {{ $keyboard->user->name }} on {{ $keyboard->created_at }}</small>
                    @if(Auth::id() == $keyboard->user_id)
                        <a href="/keyboards/{{ $keyboard->slug }}/edit">
                            <span class="glyphicon glyphicon-pencil pull-right"></span>
                        </a>
                    @endif
                </div>
                <div class="panel-body">
                    <h4>{{ $keyboard->desc_short }}</h4>
                    <p>Votes: {{ $keyboard->getVoteCount() }}</p>
                    <p>{{ $keyboard->desc_long }}</p>
                    @foreach($keyboard->images as $image)
                        <img src="/storage/{{ $image->path }}" class="img img-rounded img-responsive" />
                        @if($image->name != NULL)
                            <p>{{ $image->name }} - <small>{{ $image->desc }}</small></p>
                        @endif
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
