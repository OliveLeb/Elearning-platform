@if($message = Session::get('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
        x
        </button>
        <strong>{{$message}}</strong>
    </div>

@endif

@if($message = Session::get('danger'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">
        x
        </button>
        <strong>{{$message}}</strong>
    </div>

@endif
