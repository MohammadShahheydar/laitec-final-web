@extends('layouts.dashboard')

@section('content')
    {{--    {{ dd(var_dump($products[0]->associateSize())) }}--}}
    <section class="container-fluid">
        <section class="row m-0 p-0">
            <section class="col-10 offset-1 mt-5">
                <table class="text-center table table-hover table-bordered mt-5">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Price</th>
                            <th scope="col">Category</th>
                            <th scope="col">Size</th>
                            <th scope="col" style="width: 20%">Description</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <img class="mx-auto" style="height: 200px; width: 100%;"
                                         class="img-thumbnail shadow rounded d-block"
                                         src="{{ asset('images/product/'.$product->image) }}" alt="your post">
                                </td>
                                <td>
                                    {{$product->title}}
                                </td>
                                <td>
                                    {{$product->price}}
                                </td>
                                <td>
                                    {{ $product->category->title }}
                                </td>
                                <td>

                                    @forelse($product->associateSize() as $key => $value)
                                        <section class="m-1">
                                            <button class="btn btn-sm btn-info shadow" disabled>{{ $key }}</button>
                                            :
                                            <button class="btn btn-sm btn-info shadow"
                                                    disabled>{{ (isset($value) && !empty($value))? $value : 0 }}</button>
                                        </section>
                                    @empty
                                        {{ "unavailable" }}
                                    @endforelse
                                </td>
                                <td>
                                    {{ $product->description }}
                                </td>
                                <td>
                                    <a href="{{ route('product.edit' , ['title' => $product->title]) }}">
                                        <i class="far fa-edit text-info btn"></i>
                                    </a>
                                </td>
                                <td>
                                    <a mark href="{{ route('product.destroy' , $product->title) }}">
                                        <i class="far fa-trash-alt text-danger btn"></i>
                                    </a>
                                    {!! Form::open(['route' => ['product.destroy' , $product->title] , 'method' => 'DELETE']) !!}
                                    {!! Form::close() !!}
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
                    <a href="{{ route('product.create' , $title) }}" id="plus" class="btn btn-success shadow mt-3">
                        <i class="fas fa-plus"></i>
                    </a>
                </section>
            </section>
        </section>
    </section>
@endsection

@section('js')
    <script src="{{ asset('back/js/jquery-3.6.0.min.js') }}"></script>

    <script>
        $('a[mark]').on('click' , function (event) {
            event.preventDefault()
            $(this).siblings('form').submit()
        })
    </script>
@endsection
