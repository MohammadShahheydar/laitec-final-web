@extends('layouts.dashboard')

@section('css')
    <link href="{{ asset('back/css/slider/toastr.min.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @php
        $sliderCount = $sliders->count();
    @endphp
    <section class="container-fluid">
        <section class="row m-0 p-0">
            <section class="col-10 offset-1 mt-5">
                <table class="text-center table table-hover table-bordered mt-5">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Alt</th>
                            <th scope="col">Index</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $slider)
                            <tr>
                                <td>
                                    <img style="height: 200px; width: 100%;"
                                         class="img-thumbnail shadow rounded d-block"
                                         src="{{ asset('images/slider/'.$slider->image->image) }}" alt="{{ $slider->alt }}">
                                </td>
                                <td>{{$slider->alt}}</td>
                                <td>
                                    {!! Form::open(['route'=>['ajax-index' , $slider->id] , 'method' => 'POST' , 'id' => 'index-form-'.$slider->id , 'class' => 'text-center']) !!}
                                    <select id="index-select-{{ $slider->id }}" select-id="{{ $slider->id }}"
                                            name="index" class="form-select">
                                        <option autocomplete="off"
                                                value="0" {{ is_null($slider->index) ? "selected" : ""}}>inactive
                                        </option>
                                        @for($i = 1 ; $i <= $sliderCount ; $i++)
                                            <option autocomplete="off"
                                                    value="{{ $i }}" {{ $slider->index === $i ? "selected" : "" }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <input type="hidden" name="previous">
                                    {!! Form::close() !!}
                                </td>
                                <td><a href="{{ route('slider.edit' , ['id' => $slider->id]) }}">
                                        <i class="far fa-edit text-info btn"></i>
                                    </a>
                                </td>
                                <td>
                                    <a mark href="{{ route('slider.destroy' , $slider->id) }}">
                                        <i class="far fa-trash-alt text-danger btn"></i>
                                    </a>
                                    {!! Form::open(['route' => ['slider.destroy' , $slider->id] , 'method' => 'DELETE']) !!}
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
                <section class="mx-auto text-center">
                    <a href="{{ route('slider.create') }}" class="btn btn-success shadow mt-3">
                        <i class="fas fa-plus"></i>
                    </a>
                </section>
            </section>
        </section>
    </section>
@endsection

@section('js')
    <script src="{{ asset('back/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('back/js/axios.min.js') }}"></script>
    <script src="{{ asset('back/js/toastr.min.js') }}"></script>
    <script>
        $('td>a[mark]').on('click' , function (event) {
            event.preventDefault()
            $(this).siblings()[0].submit()
        })
        // document.getElementById('destroy').addEventListener('click', function (e) {
        //     document.getElementById('form-destroy').submit()
        // })
    </script>
    <script>
        let old
        $('td>form>select').on('click', function (event) {
            old = event.target.value;
        }).change(async function (event) {

            let value = event.target.value;
            $('td>form>select').toArray().forEach((select) => {
                if (value != 0 && select.value == value && select != event.target) {
                    select.value = old
                }
            })
            event.target.value = value
            let url = $(this).parent().attr('action');
            axios.post(url, {
                '_token': $('input[name="_token"]').val(),
                'index': parseInt(value),
                'previous': parseInt(old)
            }, {
                'Content-Type': 'application/json'
            }).then((response) => {
                console.log(response)
                toastr.success('data change successfully', 'success')
            }).catch((error) => {
                console.log(error)
                toastr.success('something wrong', 'error')
            })
        })
    </script>
@endsection
