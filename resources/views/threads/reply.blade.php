<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card flex-fill mb-3">
        <div class="card-header d-flex align-items-center">
            <div class="flex-fill">
                <i class="fas fa-comment"></i>
                <a href="#">{{ $reply->owner->name }} </a>
                said {{ $reply->formattedDate }}
            </div>
            <favorite :reply="{{ $reply }}"/>
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
            <button @click="destroy" class="btn btn-sm btn-danger mr-2"><i class="fas fa-trash-alt"></i> Delete</button>
    
                <button @click="editing = true" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</button>
            </div>
        @endcan
    </div>
</reply>
