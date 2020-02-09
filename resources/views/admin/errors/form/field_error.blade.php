@if($errors->has($name))
    @foreach($errors->get($name) as $error)
        <div class="alert alert-danger" style="margin-top: 10px">{{ $error }}</div>
    @endforeach
@endif
