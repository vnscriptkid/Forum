<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="#">{{ $reply->owner->name }} </a>
            said {{ $reply->formattedDate }}
        </div>
        <div class="panel-body">
            <p>{{ $reply->body }}</p>
        </div>
    </div>
</div>