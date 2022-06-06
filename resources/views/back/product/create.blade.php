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
                        Add Product Image
                    </button>
                    <div class="image-upload-wrap">
                        <input class="file-upload-input" name="image" type='file' onchange="readURL(this);"
                               accept="image/*"/>
                        <div class="drag-text">
                            <h3>Drag and drop a file or select add Image</h3>
                        </div>
                    </div>
                    <div class="file-upload-content">
                        <img class="file-upload-image" style="width: 80% ; height: 100%" src="#" alt="your image"/>
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
                        <label for="title" class="form-label mt-3 text-success">Product Title:</label>
                        <input id="title" type="text" value="{{ old('title') }}" name="title" class="form-control text-success">
                    </section>
                    <section class="my-3">
                        <label for="price" class="form-label mt-3 text-success">Product Price:</label>
                        <input id="price" type="text" name="price" value="{{ old('price') }}" class="form-control text-success">
                    </section>
                    <fieldset class="fieldset p-3">
                        <leegend class="text-success">Product Sizes: </leegend>
                        <section class="input-group mt-3">
                            <section class="form-floating mb-3 w-50">
                                <input type="text" class="form-control text-success" placeholder="size">
                                <label class="">Size</label>
                            </section>
                            <section class="form-floating mb-3 w-50">
                                <input id="count" type="text" name="" class="form-control text-success" placeholder="count">
                                <label for="count" class="">Count</label>
                            </section>
                        </section>
                        <section class="mx-auto text-center">
                            <a id="plus" class="btn btn-success shadow mt-3">
                                <i class="fas fa-plus"></i>
                            </a>
                        </section>
                    </fieldset>
                    <section class="my-3">
                        <label for="description" class="form-label mt-3 text-success">Product Description:</label>
                        <textarea id="description" type="text" value="{{ old('description') }}" name="description" class="form-control text-success" rows="5"></textarea>
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
    <script src="{{ asset('back/js/jquery-3.6.0.min.js') }}"></script>

    <script>

        $('section.form-floating>input[placeholder="size"]').on('change' , function (event) {
            let countInput = $(this).parent().siblings(0).children(0)[0];
            console.log(countInput)
            let name = event.target.value;
            countInput.name = `size[${name}]`
        })

        let node = $('fieldset>section.input-group').clone(true);

        $("a#plus").on('click' , function (event) {
            let clone = node.clone(true).appendTo('fieldset>section.input-group');
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

    <script>
        jQuery(document).ready(function () {
            ImgUpload();
        });

        function ImgUpload() {
            var imgWrap = "";
            var imgArray = [];

            $('.upload__inputfile').each(function () {
                $(this).on('change', function (e) {
                    imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                    var maxLength = $(this).attr('data-max_length');

                    var files = e.target.files;
                    var filesArr = Array.prototype.slice.call(files);
                    var iterator = 0;
                    filesArr.forEach(function (f, index) {

                        if (!f.type.match('image.*')) {
                            return;
                        }

                        if (imgArray.length > maxLength) {
                            return false
                        } else {
                            var len = 0;
                            for (var i = 0; i < imgArray.length; i++) {
                                if (imgArray[i] !== undefined) {
                                    len++;
                                }
                            }
                            if (len > maxLength) {
                                return false;
                            } else {
                                imgArray.push(f);

                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    var html = "<div class='upload__img-box'><div style='border-radius: 4px;background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                    imgWrap.append(html);
                                    iterator++;
                                }
                                reader.readAsDataURL(f);
                            }
                        }
                    });
                });
            });

            $('body').on('click', ".upload__img-close", function (e) {
                var file = $(this).parent().data("file");
                for (var i = 0; i < imgArray.length; i++) {
                    if (imgArray[i].name === file) {
                        imgArray.splice(i, 1);
                        break;
                    }
                }
                $(this).parent().parent().remove();
            });
        }
    </script>
@endsection
