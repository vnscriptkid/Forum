@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-headding">
                        <div>
                            <a href="#">{{ $thread->owner->name }}</a> posted: 
                            {{ $thread->title }}</div>                    
                    </div>
                    <div class="panel-body">
                        <p>{{ $thread->body }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach ($thread->replies as $reply)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $reply->owner->name }} said {{ $reply->created_at->diffForHumans() }}
                        </div>
                        <div class="panel-body">
                            <p>{{ $reply->body }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>    
@endsection

