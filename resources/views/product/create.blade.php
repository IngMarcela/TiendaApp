@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{ url('/product') }}" method="post">
            @csrf
            @include('product.form', ['modo'=>'create']);

        </form>
    </div>
@endsection
