@extends('layouts.dashboard')

@section('css')
    <link href="{{ asset('back/css/slider/slider.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <section class="container-fluid">
        <section class="row m-0 p-0">
            <section class="col-10 offset-1 my-2">
                {!! Form::open(['route' => 'product.store' , 'method' => 'POST' , 'files' => true]) !!}
                <div class="file-upload shadow">
                    <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">
                        Add Image
                    </button>
                    <div class="image-upload-wrap">
                        <input class="file-upload-input" name="image" type='file' onchange="readURL(this);"
                               accept="image/*"/>
                        <div class="drag-text">
                            <h3>Drag and drop a file or select add Image</h3>
                        </div>
                    </div>
                    <div class="file-upload-content">
                        <img class="file-upload-image" src="#" alt="your image"/>
                        <div class="image-title-wrap">
                            <button type="button" onclick="removeUpload()" class="remove-image">Remove <span
                                    class="image-title">Uploaded Image</span></button>
                        </div>
                    </div>
                    <section class="my-3">
                        <label for="title" class="form-label mt-3 text-success">Title:</label>
                        <input id="title" type="text" name="title" class="form-control text-success">
                    </section>
                    <section class="my-3">
                        <label for="size" class="form-label mt-3 text-success">Size:</label>
                        <input id="size" type="text" name="size" class="form-control text-success">
                        <small id="emailHelp" class="form-text text-muted">Separate sizes with comma (,).</small>
                    </section>
                    <section class="my-3">
                        <label for="description" class="form-label mt-3 text-success">Description:</label>
                        <textarea id="description" type="text" name="description" class="form-control text-success" rows="5"></textarea>
                    </section>
                    <input type="hidden" name="category_id" value="{{ $id }}">
                    @if($errors->any())
                        <section class="row">
                            <section class="col-11 mx-auto alert-danger rounded mt-3">
                                <ul class="my-auto">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </section>
                        </section>
                    @endif
                    {!! Form::submit('CREATE' , ['class' => 'file-upload-btn mt-4']) !!}
                </div>
                {!! Form::close() !!}
            </section>
        </section>
    </section>
@endsection

@section('js')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);

            } else {
                removeUpload();
            }
        }

        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }

        $('.image-upload-wrap').bind('dragover', function () {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function () {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
    </script>
@endsection
