@extends('home')

@section('content')
    <section class="container p-5">
        <h1 class="text-white">Profile</h1>
        <div class="bg-light rounded px-5 py-5">
            @include('logged.profile.forms.personal')

            @include('logged.profile.forms.email')

            @include('logged.profile.forms.password')
        </div>
    </section>
@endsection