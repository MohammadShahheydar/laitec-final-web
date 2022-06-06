@extends('layouts.dashboard')

@section('content')
    <section class="container-fluid">
        <section class="row m-0 p-0">
            <section class="col-10 offset-1 mt-5">
                <table class="text-center table table-hover table-bordered mt-5">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 30%">Image</th>
                            <th scope="col" style="width: 10%">Title</th>
                            <th scope="col" style="width: 5%">Last Price</th>
                            <th scope="col" style="width: 5%">New Price</th>
                            <th scope="col" style="width: 10%">Deadline</th>
                            <th scope="col" style="width: 10%">Product Title</th>
                            <th scope="col" style="width: 20%">Product Image</th>
                            <th scope="col" style="width: 5%">Edit</th>
                            <th scope="col" style="width: 5%">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($banners as $banner)
                            <tr>
                                <td>
                                    <img class="mx-auto" style="height: 200px; width: 100%;"
                                         class="img-thumbnail shadow rounded d-block"
                                         src="{{ asset('images/banner/'.$banner->image) }}" alt="your post">
                                </td>
                                <td>
                                    {{$banner->title}}
                                </td>
                                <td>
                                    {{$banner->last_price}}
                                </td>
                                <td>
                                    {{ $banner->new_price }}
                                </td>
                                <td>
                                    {{ $banner->discount_deadline }}
                                </td>
                                <td>
                                    {{ $banner->product->title }}
                                </td>
                                <td>
                                    <img class="mx-auto" style="height: 200px; width: 100%;"
                                         class="img-thumbnail shadow rounded d-block"
                                         src="{{ asset('images/product/'.$banner->product->image) }}" alt="your post">
                                </td>
                                <td>
                                    <a href="{{ route('banner.edit' , ['title' => $banner->title]) }}">
                                        <i class="far fa-edit text-info btn"></i>
                                    </a>
                                </td>
                                <td>
                                    <a mark href="{{ route('banner.destroy' , $banner->title) }}">
                                        <i class="far fa-trash-alt text-danger btn"></i>
                                    </a>
                                    {!! Form::open(['route' => ['banner.destroy' , $banner->title] , 'method' => 'DELETE']) !!}
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
