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
                        <div class="form-group">
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <textarea name="body" id="body" rows="10" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-default" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection