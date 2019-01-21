
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
                        <label>Форма собственности </label>
                        <select name="cat_id" class="form-control" required>
                            @foreach ($ar_cat as $id => $name)
                                <option value="{{ $id }}" {{ $item->cat_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Наименование опции</label>
                        <input type="text" class="form-control " name="name" value="{{ $item->name }}" required> 
                    </div>
                    <div class="form-group">
                        <label>БИН</label>
                        <input type="text" class="form-control " name="bin" value="{{ $data->bin }}" required> 
                    </div>
                    <div class="form-group">
                        <label>БИК</label>
                        <input type="text" class="form-control " name="bik" value="{{ $data->bik }}" required> 
                    </div>
                    <div class="form-group">
                        <label>Банк</label>
                        <input type="text" class="form-control " name="bank" value="{{ $data->bank }}" required> 
                    </div>
                    <div class="form-group">
                        <label>Номер счета</label>
                        <input type="text" class="form-control " name="account_num" value="{{ $data->account_num }}"  required> 
                    </div>
                    <div class="form-group">
                        <label>Юридический адрес</label>
                        <input type="text" class="form-control " name="ur_address" value="{{ $data->ur_address }}"  required> 
                    </div>
                    <div class="form-group">
                        <label>Фактический адрес</label>
                        <input type="text" class="form-control " name="fact_address" value="{{ $data->fact_address }}"  required> 
                    </div>

                    <button class="btn btn-info pull-right" type="submit">Сохранить</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection