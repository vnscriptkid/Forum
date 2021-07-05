@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @foreach ($threads as $thread)
                    <h2>
                        <a href="{{ $thread->link() }}">
                            {{ $thread->title }}
                        </a>
                    </h2>
                    <p>{{ $thread->body }}</p>
                    <br>
                @endforeach
            </div>
        </div>
    </div>    
@endsection

