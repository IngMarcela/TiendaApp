<h1>{{ trans('messages.'.$modo.'_products') }}</h1>
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
    <label for="name">{{ trans('messages.name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ isset($product->name)?$product->name:old('name') }}">
    <br>
</div>
<div class="form-group">
    <label for="reference">{{ trans('messages.size') }}</label>
    <select class="form-select" name="size">
        <option value="">{{ trans('messages.selection_size') }}</option>
        <option value="S" {{ isset($product) && $product->size === 'S' ? 'selected' : '' }}>S</option>
        <option value="M" {{ isset($product) && $product->size === 'M' ? 'selected' : '' }}>M</option>
        <option value="L" {{ isset($product) && $product->size === 'L' ? 'selected' : '' }}>L</option>
    </select>
    <br>
</div>
<div class="form-group">
    <label for="reference">{{ trans('messages.observation') }}</label>
    <input type="text" name="observation" class="form-control" value="{{ isset($product->observation)?$product->observation:old('observation') }}">
    <br>
</div>
<div class="form-group">
    <label for="reference">{{ trans('messages.brand') }}</label>
    <select class="form-select" name="reference">
        <option value="" {{ !isset($product->reference) ? 'selected' : '' }}>{{ trans('messages.selection_brand') }}</option>
        @foreach($brands as $brand)
            <option value="{{$brand->reference}}" {{ isset($product->reference) && $product->reference == $brand->reference ? 'selected' : '' }}>{{$brand->name}}</option>
        @endforeach
    </select>
    <br>
</div>
<div class="form-group">
    <label for="reference">{{ trans('messages.quantity') }}</label>
    <input type="text" name="quantity" class="form-control" value="{{ isset($product->quantity)?$product->quantity:old('quantity') }}">
    <br>
</div>
<div class="form-group">
    <label for="reference">{{ trans('messages.created_at') }}</label>
    <input type="date" name="shipping" class="form-control" value="{{ isset($product->shipping)?$product->shipping:old('shipping') }}">
    <br>
</div>
<input class="btn btn-success" type="submit" value="{{ trans('messages.'.$modo.'_products') }}">
<a class="btn btn-primary" href="{{ url('product/') }}">{{ trans('messages.back') }}</a>
<br>

