@extends('layouts.dashboard')

@section('css')
    <link href="{{ asset('back/css/slider/slider.css') }}" rel="stylesheet"/>
    <link href="{{ asset('back/css/calendar/persian-datepicker.min.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <section class="container-fluid">
        <section class="row m-0 p-0">
            <section class="col-10 offset-1 mt-5">
                {!! Form::open(['route' => 'banner.store' , 'method' => 'POST' , 'files' => true , 'class' => 'mb-5']) !!}
                <div class="file-upload mt-5 shadow">
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

                    <label for="product" class="mt-3 text-success">Product :</label>
                    <div class="form-floating mb-3">
                        <input id="product" value="{{ old('product') }}" type="text" name="product" class="form-control text-success"
                               placeholder="search">
                        <small id="emailHelp" class="form-text text-muted">chose one of the products.</small>
                        <label for="product" class="text-success"><i class="fa fa-search" aria-hidden="true"></i>
                        </label>
                        <section class="box p-2">
                            <table class="text-center table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 25%">Image</th>
                                        <th scope="col" style="width: 15%">Title</th>
                                        <th scope="col" style="width: 15%">Category</th>
                                        <th scope="col" style="width: 5%">price</th>
                                        <th scope="col" style="width: 40%">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr>
                                            <td style="width: 25%">
                                                <img class="mx-auto" style="height: 90px; width: 100%;"
                                                     class="img-thumbnail shadow rounded d-block"
                                                     src="{{ asset('images/product/'.$product->image) }}" alt="your post">
                                            </td>
                                            <td style="width: 15%">
                                                {{$product->title}}
                                            </td>
                                            <td style="width: 15%">
                                                {{$product->category->title}}
                                            </td>
                                            <td style="width: 5%">
                                                {{$product->price}}
                                            </td>
                                            <td style="font-size: 12px">
                                                {{ $product->description }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">NO DATA</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </section>
                    </div>

                    <label for="persianDatapicker" class="form-label mt-3 text-success">discount deadline :</label>
                    <input id="persianDatapicker" type="text" name="persianDatapicker"
                           class="form-control text-success">

                    <label for="title" class="form-label mt-3 text-success">Title :</label>
                    <input id="title" value="{{ old('title') }}" type="text" name="title" class="form-control text-success">

                    <label for="lastPrice" class="form-label mt-3 text-success">last price :</label>
                    <input id="lastPrice"value="{{ old('lastPrice') }}" type="text" name="lastPrice" class="form-control text-success" disabled>

                    <label for="newPrice" class="form-label mt-3 text-success">new price :</label>
                    <input id="newPrice"value="{{ old('newPrice') }}" type="text" name="newPrice" class="form-control text-success" disabled>


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
                    <button class="file-upload-btn mt-4" type="submit">CREATE</button>
                </div>
                {!! Form::close() !!}
            </section>
        </section>
    </section>
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

@section('js')
    <script src="{{ asset('back/js/calendar/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('back/js/calendar/persian-date.min.js') }}"></script>
    <script src="{{ asset('back/js/calendar/persian-datepicker.min.js') }}"></script>
    <script src="{{ asset('back/js/calendar/app.js') }}"></script>

    <script>

        if($('input[name="lastPrice"]').val() !== null && $('input[name="lastPrice"]').val() !== '') {
            $('input[name="lastPrice"]').attr('disabled' , false)
            $('input[name="newPrice"]').attr('disabled' , false)
        }

        $('input[name="product"]').on('focus' , function (event) {
            $('section.box').slideDown()
        }).on('blur' , function (event) {
            $('section.box').slideUp()
        })

        $('table>tbody>tr').on('click' , function (event) {
            let titleTd = $(this).children('td').eq(1);
            let priceTd = $(this).children('td').eq(2)
            let title = titleTd.text().trim()
            let price = priceTd.text().trim()
            console.log(title)
            $('input[name="product"]').val(title)
            $('input[name="lastPrice"]').attr('disabled' , false)
            $('input[name="lastPrice"]').val(price)
            $('input[name="newPrice"]').attr('disabled' , false)
        })

        $('input[name="product"]').on('keyup' , function (event) {
            let value = $(this).val().toLowerCase()
            $('table>tbody>tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            })
        })
    </script>
@endsection
