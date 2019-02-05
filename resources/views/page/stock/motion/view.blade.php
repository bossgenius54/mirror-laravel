
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-md-8">
        @include('page.stock.motion.__include.view_service')
        @include('page.stock.motion.__include.view_position')
    </div>
    <div class="col-md-4">
        @include('page.stock.motion.__include.view_main')
    </div>
</div>
@endsection
