@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @foreach ($threads as $thread)
                    <div class="row align-items-center">
                        <h2 class="flex-fill">
                            <a href="{{ $thread->link() }}">
                                {{ $thread->title }}
                            </a>
                        </h2>
                        <a href="{{ $thread->link() }}">{{ $thread->replies_count }} {{ Str::plural(' comment', $thread->replies_count ) }}</a>
                    </div>
                    <p>{{ $thread->body }}</p>
                    <br>
                @endforeach
            </div>
        </div>
    </div>    
@endsection

