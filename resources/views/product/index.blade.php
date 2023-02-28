@extends('layouts.app')
@section('content')
<div class="container">

    @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
            {{Session::get('message')}}
            <button type="button" class="btn-close" aria-label="Close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{Session::get('error')}}
            <button type="button" class="btn-close" aria-label="Close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
<a href="{{ url('product/create') }}" class="btn btn-success"> {{ trans('messages.register_product') }} </a>
    <br>
    <br>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>{{ trans('messages.name') }}</th>
                <th>{{ trans('messages.size') }}</th>
                <th>{{ trans('messages.observation') }}</th>
                <th>{{ trans('messages.brand') }}</th>
                <th>{{ trans('messages.quantity') }}</th>
                <th>{{ trans('messages.created_at') }}</th>
                <th>{{ trans('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $products as $product )
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->size }}</td>
                <td>{{ $product->observation }}</td>
                <td>{{ $product->brand_name }}</td>
                <td>{{ $product->quantity }} </td>
                <td>{{ $product->shipping }} </td>
                <td>
                    <a href="{{ url('/product/'.$product->id.'/edit') }}" class="btn btn-warning">
                        {{ trans('messages.edit') }}
                    </a>
                    |
                    <form action="{{ url('/product/'.$product->id ) }}" method="post" class="d-inline">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input
                            type="submit"
                            onclick="return confirm('¿Quieres borrar?')"
                            value="{{ trans('messages.delete') }}"
                            class="btn btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $products->links() !!}
</div>
@endsection
