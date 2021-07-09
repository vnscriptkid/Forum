@component('profiles.activity')
    @slot('heading')
        {{ auth()->user()->name }} published new thread 
        <a href="{{ $activity->subject->link() }}">{{ $activity->subject->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent