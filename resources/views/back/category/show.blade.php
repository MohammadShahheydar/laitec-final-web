@extends('layouts.dashboard')

@section('content')
    {{--    {{ dd(var_dump($products[0]->associateSize())) }}--}}
    <section class="container-fluid">
        {{--        <section class="row m-0 p-0">--}}
        {{--            <section class="col-10 offset-1 mt-5">--}}
        <section class="card my-4">
            <section class="card-header">
                <i class="fas fa-table me-1"></i>
            </section>
            <section class="card-body">
                <table id="datatablesSimple" class="text-center table table-hover table-bordered mt-5">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Price</th>
                            <th scope="col">Category</th>
                            <th scope="col">Size</th>
                            <th scope="col">Description</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td style="width: 30%; position: relative">
                                    @if($product->deleted_at)
                                        <section style="position: absolute; top: 50%;left: 50%; z-index: 999; font-size: 48px; transform: translate(-50% , -50%)">
                                            <i style="color: red" class="fas fa-ban"></i>
                                        </section>
                                    @endif
                                    <img class="mx-auto" style="height: 200px; width: 100%; {{ ($product->deleted_at) ? "filter: grayscale(100%) blur(3px); -webkit-filter: grayscale(100%) blur(3px)" : "" }}"
                                         class="img-thumbnail shadow rounded d-block"
                                         src="{{ asset('images/product/'.$product->image) }}" alt="your post">
                                </td>
                                <td style="width: 10%">
                                    {{$product->title}}
                                </td>
                                <td style="width: 10%">
                                    {{$product->price}}
                                </td>
                                <td style="width: 10%">
                                    {{ $product->category->title }}
                                </td>
                                <td style="width: 10%">
                                    @forelse($product->associateSize() as $key => $value)
                                        <section class="m-1">
                                            <button class="btn btn-sm {{ ($product->deleted_at) ? "btn-dark" : "btn-info" }} shadow" disabled>{{ $key }}</button>
                                            :
                                            <button class="btn btn-sm {{ ($product->deleted_at) ? "btn-dark" : "btn-info" }} shadow"
                                                    disabled>{{ (isset($value) && !empty($value))? $value : 0 }}</button>
                                        </section>
                                    @empty
                                        {{ "unavailable" }}
                                    @endforelse
                                </td>
                                <td style="width: 25%">
                                    {{ $product->description }}
                                </td>
                                <td style="width: 2.5%">
                                    @if($product->deleted_at)
                                        <a mark title="restore" href="{{ route('product.restore' , $product->title) }}">
                                            <i class="fas fa-trash-restore"></i>
                                        </a>
                                        {!! Form::open(['route' => ['product.restore' , $product->title] , 'method' => 'PUT']) !!}
                                        {!! Form::close() !!}
                                    @else
                                        <a href="{{ route('product.edit' , ['title' => $product->title]) }}">
                                            <i class="far fa-edit text-info btn"></i>
                                        </a>
                                    @endif
                                </td>
                                <td style="width: 2.5%">
                                    @if($product->deleted_at)
                                        <a mark title="force delete" href="{{ route('product.force-delete' , $product->title) }}">
                                            <span style="color: red">
                                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                        {!! Form::open(['route' => ['product.force-delete' , $product->title] , 'method' => 'DELETE']) !!}
                                        {!! Form::close() !!}
                                    @else
                                        <a mark href="{{ route('product.destroy' , $product->title) }}">
                                            <i class="far fa-trash-alt text-danger btn"></i>
                                        </a>
                                        {!! Form::open(['route' => ['product.destroy' , $product->title] , 'method' => 'DELETE']) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">NO DATA</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <section class="mx-auto text-center">
                    <a href="{{ route('product.create' , $title) }}" id="plus"
                       class="btn btn-success form-control shadow mt-3">
                        <i class="fas fa-plus"></i> ADD NEW PRODUCT
                    </a>
                </section>
            </section>
        </section>
        {{--            </section>--}}
        {{--        </section>--}}
    </section>
@endsection

@section('js')
    <script src="{{ asset('back/js/jquery-3.6.0.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('a[mark]').on('click', function (event) {
                event.preventDefault()
                $(this).siblings('form').submit()
            })
        })
    </script>
@endsection
