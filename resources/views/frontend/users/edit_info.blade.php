@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{asset('frontend/js/summernote/summernote-bs4.min.css')}}">
@endsection
@section('content')
    <div class="col-lg-9 col-12">
        <h3 class="mb-4">Update Information</h3>
        {!! Form::open( ['route' => ['users.update.info'], 'method' => 'post', 'files' => true,'class'=> 'update-info','id'=>'update-info']) !!}
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', old('name',auth()->user()->name), ['class' => 'form-control']) !!}
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', old('email',auth()->user()->email), ['class' => 'form-control']) !!}
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    {!! Form::label('mobile', 'Mobile') !!}
                    {!! Form::text('mobile', old('mobile',auth()->user()->mobile), ['class' => 'form-control']) !!}
                    @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    {!! Form::label('recevice_email', 'Receive email') !!}
                    {!! Form::select('recevice_email', ['1' => 'Yes', '0' => 'No'], old('recevice_email', auth()->user()->recevice_email), ['class' => 'form-control']) !!}
                    @error('recevice_email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    {!! Form::label('bio', 'Bio') !!}
                    {!! Form::textarea('bio', old('bio',auth()->user()->bio), ['class' => 'summernote']) !!}
                    @error('bio')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
        <div class="row">
            @if (auth()->user()->user_image != '')
                {{--             @if (auth()->user()->user_image != '')--}}
                <div class="col-12">
                    <p>user image</p>
                    <img src="{{asset('assets/users/'.auth()->user()->user_image)}}" alt="{{auth()->user()->name}}"
                         class="img-fluid" width="150px">
                </div>
            @else
                <div class="col-12">
                    {!! Form::label('user_image', 'User image') !!}
                    {!! Form::file('user_image', ['id' => 'user-image', 'class'=>'custom-file']) !!}
                </div>
            @endif

        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="form-group">
                    {!! Form::submit('Update information', ['name' => 'update_information', 'class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <hr>
        <h3 class="my-4">Update Password</h3>
        {!! Form::open( ['route' => ['users.update.password'], 'method' => 'post','class'=> 'update-password','id'=>'update-password']) !!}
        <div class="form-group">
            {!! Form::label('current_password', 'Current password') !!}
            {!! Form::password('current_password',  ['class' => 'form-control']) !!}
            @error('current_password')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            {!! Form::label('password', 'New password') !!}
            {!! Form::password('password',  ['class' => 'form-control']) !!}
            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            {!! Form::label('password_confirmation', 'Re Password') !!}
            {!! Form::password('password_confirmation',  ['class' => 'form-control']) !!}
            @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            {!! Form::submit('Update password', ['name' => 'update_password', 'class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    @include('partial.frontend.users.sidebar')

@endsection
@section('script')
    <script src="{{asset('frontend/js/summernote/summernote-bs4.min.js')}}"></script>
    <script>  $(function () {

            $('.summernote').summernote({
                placeholder: 'Hello stand alone ui',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            $('#user-image').fileinput({
                theme: "fa",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
            })
        });
    </script>
@endsection
