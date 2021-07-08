@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $profileUser->name }}
            <small class="text-muted">Since {{ $profileUser->created_at->diffForHumans() }}</small>
        </h1>   
        
        @foreach ($threads as $thread)
            <div class="card mb-3">
                <div class="card-header d-flex align-items-center">
                    <div class="flex-fill">
                        <h5 class="card-title">
                            <a href="{{ $thread->link() }}">
                                {{ $thread->title }}
                            </a>
                        </h5>
                        By <a href="{{ route('profile', $thread->owner->name) }}">{{ $thread->owner->name }}</a>
                    </div>
                    <a href="{{ $thread->link() }}">{{ $thread->replies_count }} {{ Str::plural(' comment', $thread->replies_count ) }}</a>
                </div>
                <p class="card-body">{{ $thread->body }}</p>
            </div>
        @endforeach

        {{ $threads->links() }}
    </div>
@endsection