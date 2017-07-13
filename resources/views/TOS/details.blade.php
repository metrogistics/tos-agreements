@extends('layouts.app')

@section('content')

    <div class="container">

        <h1 class="page-header">Terms of Service Agreement for {{ $name }} </h1>

        <h5>Last Modified: {{ $date }}</h5>

        <a href="{{ $url }}" class="btn btn-primary">View PDF</a>

    </div>


@endsection