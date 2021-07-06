@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Create a new thread</h2>
                </div>                 
                <div class="panel-body">
                    <form action="/threads" method="post">
                        @csrf
                        {{-- Channel --}}
                        <div class="form-group">
                            <label for="channel">Select channel</label>
                            <select required name="channel_id" id="channel" class="form-control">
                                <option value="">Please select one</option>
                                @foreach (App\Models\Channel::all() as $channel)
                                    <option value="{{ $channel->id }}" {{ $channel->id == old('channel_id') ? 'selected' : '' }}>{{ $channel->name }}</option>
                                @endforeach
                            </select>
                            @error('channel_id')
                                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- Title --}}
                        <div class="form-group">
                            <input required value="{{ old('title') }}" type="text" name="title" class="form-control" placeholder="Thread title">
                            @error('title')
                                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- Body --}}
                        <div class="form-group">
                            <textarea required name="body" id="body" rows="10" class="form-control" placeholder="Add some content">{{ old('body') }}</textarea>
                            @error('body')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- Submit --}}
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection