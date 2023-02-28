@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{ url('/brand/'.$brand->reference) }}" method="post">
            @csrf
            {{ method_field('PATCH') }}
            @include('brand.form', ['modo'=>'edit']);
        </form>
    </div>
@endsection
