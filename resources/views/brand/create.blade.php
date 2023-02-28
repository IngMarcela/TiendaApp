@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{ url('/brand') }}" method="post">
            @csrf
            @include('brand.form', ['modo'=>'create']);

        </form>
    </div>
@endsection
