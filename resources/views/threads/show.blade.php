@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
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
    
                @foreach ($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}
    
                @auth
                <div class="row">
                    <form action="{{ $thread->link() . '/replies' }}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name="body" rows="5" placeholder="Have something to say?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
                @endauth
    
                @guest
                    <p class="text-center">Please <a href="/login">Sign in</a> to participate in the discussion!</p>
                @endguest
            </div>
            <div class="col-md-4">
                This thread was published {{ $thread->formattedDate }}
                <br>
                by <a href="#">{{ $thread->owner->name }}</a>. 
                <br>
                It currently has {{ $thread->replies_count }} {{ Str::plural('comment', $thread->replies_count) }}.
            </div>
        </div>
    </div>    
@endsection

