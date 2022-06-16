@extends('layouts.dashboard')

@section('css')
    <link href="{{ asset('back/css/slider/toastr.min.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    <section class="container-fluid">
        <section class="row m-0 p-0">
            <section class="col-10 offset-1 mt-5">
                <table class="text-center table table-hover table-bordered mt-5">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Entry Date</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
{{--                            {{ dd($user->roles()->first()->id) }}--}}
                            <tr>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>{{$user->email}}</td>
                                <td>
                                    {!! Form::open(['route'=>['authorize.update' , $user->id] , 'method' => 'POST' , 'id' => 'index-form-'.$user->id , 'class' => 'text-center']) !!}

                                    {!! Form::select('role', \App\Models\Role::all()->pluck('role' , 'id') , $user->roles()->first()->id, [ 'class' => 'form-select']) !!}

{{--                                    <select id="role-select-{{ $user->id }}" select-id="{{ $user->id }}"--}}
{{--                                            name="role" class="form-select">--}}
{{--                                        @for($i = 1 ; $i <= $userCount ; $i++)--}}
{{--                                            <option autocomplete="off"--}}
{{--                                                    value="{{ $i }}" {{ $user->roles() === $i ? "selected" : "" }}>{{ $i }}</option>--}}
{{--                                        @endfor--}}
{{--                                    </select>--}}
                                    <input type="hidden" name="previous">
                                    {!! Form::close() !!}
                                </td>
                                <td>{{ new \Hekmatinasser\Verta\Verta($user->created_at)}}</td>
{{--                                <td><a href="{{ route('authorize.edit' , ['id' => $user->id]) }}">--}}
{{--                                        <i class="far fa-edit text-info btn"></i>--}}
{{--                                    </a>--}}
{{--                                </td>--}}
                                <td>
                                    <a mark href="{{ route('authorize.destroy' , $user->id) }}">
                                        <i class="far fa-trash-alt text-danger btn"></i>
                                    </a>
                                    {!! Form::open(['route' => ['authorize.destroy' , $user->id] , 'method' => 'DELETE']) !!}
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
                    <a href="{{ route('register') }}" class="btn btn-success shadow mt-3">
                        <i class="fas fa-user-plus"></i>
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
        $('td>a[mark]').on('click', function (event) {
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
            // $('td>form>select').toArray().forEach((select) => {
            //     if (value != 0 && select.value == value && select != event.target) {
            //         select.value = old
            //     }
            // })
            // event.target.value = value
            let url = $(this).parent().attr('action');
            axios.post(url, {
                '_token': $('input[name="_token"]').val(),
                '_method': 'PUT',
                'role': parseInt(value),
                'previous': parseInt(old)
            }, {
                'Content-Type': 'application/json'
            }).then((response) => {
                console.log(response)
                toastr.success('data change successfully', 'success')
            }).catch((error) => {
                console.log(error)
                toastr.error('something wrong', 'error')
            })
        })
    </script>
@endsection
