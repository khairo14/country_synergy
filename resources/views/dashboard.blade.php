@extends('layouts.app')

@section('content')
    <div class="container">
        this display dashboard

        <form action="/sign-out" method="post">
            @csrf
            <button type="submit">
                sign out
            </button>

        </form>

    </div>
@endsection
