
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
                        <label>Компания</label>
                        <select name="company_id" class="form-control" required>
                            @foreach ($ar_lib['ar_company'] as $id => $name)
                                <option value="{{ $id }}" {{ $item->company_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Наименование</label>
                        <input type="text" class="form-control " name="name" value="{{ $item->name }}" required> 
                    </div>
                    <div class="form-group">
                        <label>Есть онлайн продажи</label>
                        <select name="has_onlain" class="form-control" required>
                            @foreach ($ar_lib['ar_bool'] as $id => $name)
                                <option value="{{ $id }}" {{ $item->has_onlain == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Телефон</label>
                        <input type="text" class="form-control " name="phone" value="{{ $data->phone }}" required> 
                    </div>
                    <div class="form-group">
                        <label>Сотовый</label>
                        <input type="text" class="form-control " name="mobile" value="{{ $data->mobile }}" required> 
                    </div>
                    <div class="form-group">
                        <label>Адрес</label>
                        <input type="text" class="form-control " name="address" value="{{ $data->address }}" required> 
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <input type="text" class="form-control " name="note" value="{{ $data->note }}" required> 
                    </div>
                    <button class="btn btn-info pull-right" type="submit">Сохранить</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection