@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @foreach ($threads as $thread)
                    <div class="card mb-3">
                        <div class="card-header d-flex align-items-center">
                            <div class="flex-fill">
                                <h5 class="card-title">
                                    <a href="{{ $thread->link() }}">
                                        {{ $thread->title }}
                                    </a>
                                </h5>
                                By <a href="#">{{ $thread->owner->name }}</a>
                            </div>
                            <a href="{{ $thread->link() }}">{{ $thread->replies_count }} {{ Str::plural(' comment', $thread->replies_count ) }}</a>
                        </div>
                        <p class="card-body">{{ $thread->body }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>    
@endsection

