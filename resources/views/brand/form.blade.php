<h1>{{ trans('messages.'.$modo.'_brand') }}</h1>
@if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach( $errors->all() as $error)
                <li>{{ trans('messages.'.$error) }}</li>
            @endforeach
        </ul>

    </div>
@endif

<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" name="name" value="{{ isset($brand->name)?$brand->name:old('name') }}">
    <br>
</div>
<input class="btn btn-success" type="submit" value="{{ trans('messages.'.$modo.'_brand') }}">
<a class="btn btn-primary" href="{{ url('brand/') }}">Regresar</a>
<br>
