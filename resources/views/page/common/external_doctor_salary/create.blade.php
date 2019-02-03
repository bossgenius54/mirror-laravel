
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
                        <label>Заказ</label>
                        <select name="order_id" class="form-control" required>
                            @foreach ($orders as $id => $name)
                                <option value="{{ $id }}">Заказ "{{ $name }}"" № {{ $id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Врач</label>
                        <select name="doctor_id" class="form-control" required>
                            @foreach ($doctors as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Сумма</label>
                        <input type="number" class="form-control " name="salary" required> 
                    </div>
                    
                    <button class="btn btn-info pull-right" type="submit">Сохранить</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection