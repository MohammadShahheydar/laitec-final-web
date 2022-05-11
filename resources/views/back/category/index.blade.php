@extends('layouts.dashboard')

@section('content')
    <section class="container-fluid">
        <section class="row m-0 p-0">
            <section class="col-10 offset-1 mt-5">
                <table class="table mt-5">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Number</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <th scope="row">{{ $category->id }}</th>
                                <td>
                                    {{$category->title}}
                                </td>
                                <td>
                                    {{ $category->count }}
                                </td>
                                <td>
                                    <a href="{{ route('category.edit' , ['title' => $category->title]) }}">
                                        <i class="far fa-edit text-info btn"></i>
                                    </a>
                                </td>
                                <td>
                                    <a mark href="{{ route('category.destroy' , $category->title) }}">
                                        <i class="far fa-trash-alt text-danger btn"></i>
                                    </a>
                                    {!! Form::open(['route' => ['category.destroy' , $category->title] , 'method' => 'DELETE']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">NO DATA</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <section class="row ">
                    <section class="col-6 offset-3 mt-2">
                        <section id="create-new-category" class="alert alert-success" style="display: none">
                            {!! Form::open(['route' => 'category.store' , 'method' => 'POST' , 'class' => 'text-center']) !!}
                            <div class="form-floating mb-3">
                                <input class="form-control" name="title" id="inputEmail" type="text"
                                       placeholder="t-shirt" value="{{ old('name') }}"/>
                                <label for="inputEmail">Title</label>
                            </div>
                            {!! Form::submit('Create' , ['class' => 'btn btn-success']); !!}
                            {!! Form::close() !!}
                        </section>
                    </section>
                </section>
                <section class="mx-auto text-center">
                    <button id="plus" class="btn btn-success shadow mt-3">
                        <i class="fas fa-plus"></i>
                    </button>
                </section>
            </section>
        </section>
    </section>
@endsection

@section('js')
    <script src="{{ asset('back/js/jquery-3.6.0.min.js') }}"></script>
    <script>
        $('button#plus').on('click', function (event) {
            $('#create-new-category').slideDown();
        })
    </script>
@endsection
