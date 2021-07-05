@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>{{ $thread->title }}</h2>                    
                <p>{{ $thread->body }}</p>
            </div>
        </div>
    </div>    
@endsection

