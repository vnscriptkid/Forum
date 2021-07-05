@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div>
                            <a href="#">{{ $thread->owner->name }}</a> posted: 
                            {{ $thread->title }}
                        </div>   
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
                            <a href="#">{{ $reply->owner->name }} </a>
                            said {{ $reply->created_at->diffForHumans() }}
                        </div>
                        <div class="panel-body">
                            <p>{{ $reply->body }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @auth
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form action="{{ $thread->link() . '/replies' }}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name="body" rows="5" placeholder="Have something to say?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        @endauth

        @guest
            <p class="text-center">Please <a href="/login">Sign in</a> to participate in the discussion!</p>
        @endguest
    </div>    
@endsection
