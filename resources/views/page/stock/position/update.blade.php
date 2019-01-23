
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">{{ $title }}</h4>
            </div>
            <div class="card-body">
                <form class="form-material" action="{{ $action }}" method="post"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Себестоимость</label>
                        <input type="number" class="form-control " name="price_cost" value="{{ $item->price_cost }}" required> 
                    </div>
                    <div class="form-group">
                        <label>Срок годности</label>
                        <input type="date" class="form-control " name="expired_at" value="{{ $item->expired_at }}" required> 
                    </div>

                    <button class="btn btn-info pull-right" type="submit">Сохранить</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection