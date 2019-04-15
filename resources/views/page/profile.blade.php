
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
                        <input type="email" class="form-control "  value="{{ $user->email }}" readonly> 
                    </div>
                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" class="form-control"  name="password" placeholder="Новый пароль. если не указан, то будет старый" > 
                    </div>
                    <div class="form-group">
                        <label>ФИО</label>
                        <input type="text" class="form-control " name="name" value="{{ $user->name }}" required> 
                    </div>
                    <div class="form-group">
                        <label>ИИН</label>
                        <input type="text" class="form-control " name="iin" value="{{ $user->iin }}"> 
                    </div>
                    <div class="form-group">
                        <label>Сотовый</label>
                        <input type="text" class="form-control " name="phone" value="{{ $user->phone }}"> 
                    </div>
                    <div class="form-group">
                        <label>Дата рождения</label>
                        <input type="date" class="form-control " name="b_date" value="{{ $user->b_date }}"> 
                    </div>
                    <div class="form-group">
                        <label>Фото</label>
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput"> 
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> 
                                <span class="fileinput-filename">{{ $user->photo  }}</span>
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