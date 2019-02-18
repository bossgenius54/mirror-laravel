
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
                        <label>Категория</label>
                        <select  class="form-control" disabled>
                            @foreach ($ar_cat as $id => $name)
                                <option value="{{ $id }}" {{ $item->cat_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Наименование</label>
                        <input type="text" class="form-control " name="name" value="{{ $item->name }}" required> 
                    </div>
                    <div class="form-group">
                        <label>Участвует в форм. номера</label>
                        <select name="need_in_generate" class="form-control" >
                            <option value="0" value="{{ !$item->need_in_generate ? 'selected' : '' }}" >Нет</option>
                            <option value="1" value="{{ $item->need_in_generate ? 'selected' : '' }}" >Да</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cист. номер</label>
                        <input type="number" class="form-control " name="sys_num" value="{{ $item->sys_num }}" required> 
                    </div>
                    <button class="btn btn-info pull-right" type="submit">Сохранить</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection