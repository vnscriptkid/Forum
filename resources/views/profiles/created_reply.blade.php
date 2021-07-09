@component('profiles.activity')
    @slot('heading')
        {{ auth()->user()->name }} replied to thread  
        <a href="{{ $activity->subject->thread->link() }}">
            {{ $activity->subject->thread->title }}
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent