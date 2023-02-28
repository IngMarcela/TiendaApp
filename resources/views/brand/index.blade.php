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
<a href="{{ url('brand/create') }}" class="btn btn-success"> {{ trans('messages.register_brand') }} </a>
    <br>
    <br>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>{{ trans('messages.reference') }}</th>
                <th>{{ trans('messages.name') }}</th>
                <th>{{ trans('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $brands as $brand )
            <tr>
                <td>{{ $brand->reference }}</td>
                <td>{{ $brand->name }}</td>
                <td>
                    <a href="{{ url('/brand/'.'1'.'/edit') }}" class="btn btn-warning">
                        {{ trans('messages.edit') }}
                    </a>
                    |
                    <form action="{{ url('/brand/'.$brand->reference ) }}" method="post" class="d-inline">
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
    {!! $brands->links() !!}
</div>
@endsection
