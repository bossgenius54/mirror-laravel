
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
                        <label>Почтовый адрес</label>
                        <input type="email" class="form-control " value="{{ $item->email }}"  readonly> 
                    </div>
                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" class="form-control"  name="password" placeholder="Новый пароль. если не указан, то будет старый" > 
                    </div>
                    <div class="form-group">
                        <label>Филиал</label>
                        <select name="branch_id" class="form-control" required>
                            @foreach ($ar_branch as $id => $name)
                                <option value="{{ $id }}" {{ $item->branch_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ФИО</label>
                        <input type="text" class="form-control " name="name" value="{{ $item->name }}" required> 
                    </div>
                    <div class="form-group">
                        <label>ИИН</label>
                        <input type="text" class="form-control " name="iin" value="{{ $item->iin }}" required> 
                    </div>
                    <div class="form-group">
                        <label>Телефон</label>
                        <input type="text" class="form-control " name="phone" value="{{ $item->phone }}" required> 
                    </div>
                    <div class="form-group">
                        <label>Фото</label>
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput"> 
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> 
                                <span class="fileinput-filename">{{ $item->photo }}</span>
                            </div> 
                            <span class="input-group-addon btn btn-default btn-file"> 
                                <span class="fileinput-new">Выбрать файл</span> 
                                <span class="fileinput-exists">Изменить</span>
                                <input type="hidden">
                                <input type="file" name="photo"> 
                            </span> 
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Убрать</a> 
                        </div>
                    </div>
                    <button class="btn btn-info pull-right" type="submit">Сохранить</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection