<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card flex-fill mb-3">
        <div class="card-header d-flex align-items-center">
            <div class="flex-fill">
                <a href="#">{{ $reply->owner->name }} </a>
                said {{ $reply->formattedDate }}
            </div>
            <form action="/replies/{{ $reply->id }}/favorites" method="post">
                @csrf
                <button {{ $reply->isFavoritedByMe() ? 'disabled' : '' }} type="submit" class="btn btn-sm btn-danger">
                    {{ $reply->favorites_count }}
                    <svg class="bi bi-heart" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                    </svg>
                </button>
            </form>
        </div>
        <div class="card-body">
            <div v-if="editing" class="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                    <div v-if="errors">
                        <small class="form-text text-danger" role="alert" v-text="errors.body[0]"></small>
                    </div>
                </div>
                <div class="form-group">
                    <div @click="update" class="btn btn-sm btn-primary">Update</div>
                    <div @click="cancel" class="btn btn-sm btn-secondary">Cancel</div>
                </div>
            </div>

            <div v-else v-text="body">
                <p>{{ $reply->body }}</p>
            </div>
        </div>
        @can('update', $reply)
            <div v-if="!editing" class="card-footer d-flex">
                <form class="mr-2" action="/replies/{{ $reply->id }}" method="post">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
    
                <button @click="editing = true" class="btn btn-warning">Edit</button>
            </div>
        @endcan
    </div>
</reply>
