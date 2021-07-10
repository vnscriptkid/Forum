@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3">{{ $profileUser->name }}
            <small class="text-muted">Since {{ $profileUser->created_at->diffForHumans() }}</small>
        </h1>   
        
        @foreach ($activitiesByDate as $date => $activities)
            <h2 class="display-5 card-header">{{ $date }}</h2>
            <br>    
            @foreach ($activities as $activity)
                @if (view()->exists("profiles.{$activity->type}"))
                    @include("profiles.{$activity->type}")
                @endif
            @endforeach
        @endforeach
    </div>
@endsection