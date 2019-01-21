
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
                        <label>Вид опции</label>
                        <select  class="form-control" disabled>
                            @foreach ($ar_type as $id => $name)
                                <option value="{{ $id }}" {{ $item->type_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Наименование опции</label>
                        <input type="text" class="form-control " name="option_name" value="{{ $item->option_name }}" required> 
                    </div>
                    <div class="form-group">
                        <label>Значение опции</label>
                        <input type="text" class="form-control " name="option_val" value="{{ $item->option_val }}" required> 
                    </div>

                    <button class="btn btn-info pull-right" type="submit">Сохранить</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection