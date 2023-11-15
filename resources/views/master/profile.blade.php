@extends('master.main')

@section('title', 'Profile settings')

@section('content')

    <div class="container">
        <div class="row bg-black">
            @include("includes.profile.menu")
        </div>
<div class="container">
    @yield("profile-content")
</div>

</div>


@stop