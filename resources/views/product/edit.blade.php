@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{ url('/product/'.$product->id) }}" method="post">
            @csrf
            {{ method_field('PATCH') }}
            @include('product.form', ['modo'=>'edit']);
        </form>
    </div>
@endsection
