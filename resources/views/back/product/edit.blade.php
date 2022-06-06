@extends('layouts.dashboard')


@section('css')
    <link href="{{ asset('back/css/slider/slider.css') }}" rel="stylesheet"/>
@endsection

@php
    $sizes = json_decode($product->size , true);
@endphp

@section('content')
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <section class="container-fluid">
        <section class="row m-0 p-0">
            <section class="col-10 offset-1 my-2">
                {!! Form::model($product , ['route' => ['product.update' , $product->title] , 'method' => 'PUT' , 'files' => true]) !!}
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
                    {{--                   Product slider--}}
                    <section class="my-3">
                        <div class="upload__box">
                            <div class="upload__btn-box">
                                <label class="upload__btn form-control">
                                    <p>Upload Product Slider Image</p>
                                    <input type="file" name="productSlider[]" multiple="true" data-max_length="20" class="upload__inputfile">
                                </label>
                            </div>
                            <div class="upload__img-wrap"></div>
                        </div>
                    </section>
                    {{--                   Product slider--}}
                    <section class="my-3">
                        {!! Form::label('title' , 'Title :' , ['class' => 'form-label mt-3 text-success']) !!}
                        {!! Form::text('title' , old('title') , ['class' => 'form-control text-success']) !!}
                    </section>
                    <section class="my-3">
                        {!! Form::label('price' , 'Price :' , ['class' => 'form-label mt-3 text-success']) !!}
                        {!! Form::text('price' , old('price') , ['class' => 'form-control text-success']) !!}
                    </section>
                    <section class="my-3">
                        {!! Form::label('category_id' , 'Category :' , ['class' => 'form-label mt-3 text-success']) !!}
                        {!! Form::select("category_id" , $category , old('size') , ['class' => 'form-select']) !!}
                    </section>
                    <fieldset class="fieldset p-3">
                        <leegend class="text-success"> Sizes:</leegend>
                        @forelse($sizes as $key => $val)
                            <section class="input-group mt-3">
                                <section class="form-floating mb-3 w-50">
                                    <input type="text" class="form-control text-success" placeholder="size"
                                           value="{{ $key }}">
                                    <label class="">Size</label>
                                </section>
                                <section class="form-floating mb-3 w-50">
                                    <input id="count" type="text" name="size[{{ $key }}]"
                                           class="form-control text-success" value="{{ $val }}" placeholder="count">
                                    <label for="count" class="">Count</label>
                                </section>
                            </section>
                        @empty
                            <section class="input-group mt-3">
                                <section class="form-floating mb-3 w-50">
                                    <input type="text" class="form-control text-success" placeholder="size">
                                    <label class="">Size</label>
                                </section>
                                <section class="form-floating mb-3 w-50">
                                    <input id="count" type="text" name="" class="form-control text-success"
                                           placeholder="count">
                                    <label for="count" class="">Count</label>
                                </section>
                            </section>
                        @endforelse
                        <section class="mx-auto text-center">
                            <a id="plus" class="btn btn-success shadow mt-3">
                                <i class="fas fa-plus"></i>
                            </a>
                        </section>
                    </fieldset>
                    <section class="my-3">
                        {!! Form::label('description' , 'Description :' , ['class' => 'form-label mt-3 text-success']) !!}
                        {!! Form::textarea('description' , old('description') , ['class' => 'form-control text-success' , 'rows' => '5']) !!}
                    </section>
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
                    {!! Form::submit('EDIT' , ['class' => 'file-upload-btn mt-4']) !!}
                </div>
                {!! Form::close() !!}
            </section>
        </section>
    </section>
@endsection

@section('js')
    <script src="{{ asset('back/js/jquery-3.6.0.min.js') }}"></script>

    <script>

        $('section.form-floating>input[placeholder="size"]').on('change', function (event) {
            let countInput = $(this).parent().siblings(0).children(0)[0];
            console.log(countInput)
            let name = event.target.value;
            countInput.name = `size[${name}]`
        })

        let node = $('fieldset>section.input-group').last().clone(true);
        console.log(node)

        $("a#plus").on('click', function (event) {
            let clone = node.clone(true)
            $('fieldset>section.input-group').last().after(clone);
            console.log(clone)
        })

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
