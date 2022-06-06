@extends('layouts.dashboard')

@section('content')
    <section class="container-fluid">
        <section class="row m-0 p-0">
            <section class="col-10 offset-1 mt-5">
                <table class="table mt-5 text-center">
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
                                    {!! Form::model($category , ['route' => ['category.update' , $category->title] , 'method' => 'PUT' , 'class' => 'py-1']) !!}
                                    {!! Form::text('title' , $category->title , ['class' => 'form-control-sm disabled' , 'disabled' => true , 'id' => 'input'. $category->id]) !!}
                                    {!! Form::submit('edit' , ['class' => 'btn btn-sm btn-info mb-1' , 'style'=> 'display:none']) !!}
                                    {!! Form::close() !!}
                                </td>
                                <td>
                                    {{ $category->count }}
                                </td>
                                <td>
                                    <span id="btn-{{ $category->id }}">
                                        <i class="far fa-edit text-info btn"></i>
                                    </span>
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

        $('a[mark]').on('click' , function (evnet) {
            event.preventDefault()
            $(this).siblings('form').submit()
        })

        $('td>span').on('click' , function (evnet) {
            $(this).parent().siblings('td').first().children(0).children('.form-control-sm').prop('disabled' , false)
            $(this).parent().siblings('td').first().children(0).children('.btn').fadeIn()
        })
        function enableInput(event) {
            console.log($(this))
        }
    </script>
@endsection
