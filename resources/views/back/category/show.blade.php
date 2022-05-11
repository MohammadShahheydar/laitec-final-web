@extends('layouts.dashboard')

@section('content')
    <section class="container-fluid">
        <section class="row m-0 p-0">
            <section class="col-10 offset-1 mt-5">
                <table class="table mt-5">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
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
                                <th scope="row">{{ $product->id }}</th>
                                <td>
                                    <img style="height: 200px; width: 200px;"
                                         class="img-thumbnail shadow rounded d-block"
                                         src="{{ asset('images/product/'.$product->image) }}" alt="your post">
                                </td>
                                <td>
                                    {{$product->title}}
                                </td>
                                <td>
                                    {{ $product->category->title }}
                                </td>
                                <td>
                                    {{ $product->size }}
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
                                <td colspan="7">NO DATA</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <section class="mx-auto text-center">
                    <a href="{{ route('product.create' , $categoryID) }}" id="plus" class="btn btn-success shadow mt-3">
                        <i class="fas fa-plus"></i>
                    </a>
                </section>
            </section>
        </section>
    </section>
@endsection
