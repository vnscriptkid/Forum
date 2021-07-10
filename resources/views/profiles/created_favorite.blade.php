@component('profiles.activity')
    @slot('heading')
        {{ auth()->user()->name }} liked a reply in 
        <a href="{{ $activity->subject->favorited->link() }}">
            {{ $activity->subject->favorited->thread->title }}
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent