
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
                    <h3 class="card-title">Правый глаз</h3>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>Сфера</label>
                            <input type="text" class="form-control " name="l_scope" > 
                        </div>
                        <div class="form-group col-md-2">
                            <label>Цил.</label>
                            <input type="text" class="form-control " name="l_cil" > 
                        </div>
                        <div class="form-group col-md-2">
                            <label>Ось</label>
                            <input type="text" class="form-control " name="l_os" > 
                        </div>
                        <div class="form-group col-md-2">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Призма оси</label>
                            <input type="text" class="form-control " name="l_prism_01" > 
                        </div>
                        <div class="form-group col-md-2">
                            <label>Призма оси</label>
                            <input type="text" class="form-control " name="l_prism_02" > 
                        </div>
                    </div>
                    <h3 class="card-title">Левый глаз</h3>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>Сфера</label>
                            <input type="text" class="form-control " name="r_scope" > 
                        </div>
                        <div class="form-group col-md-2">
                            <label>Цил.</label>
                            <input type="text" class="form-control " name="r_cil" > 
                        </div>
                        <div class="form-group col-md-2">
                            <label>Ось</label>
                            <input type="text" class="form-control " name="r_os" > 
                        </div>
                        <div class="form-group col-md-2">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Призма оси</label>
                            <input type="text" class="form-control " name="r_prism_01" > 
                        </div>
                        <div class="form-group col-md-2">
                            <label>Призма оси</label>
                            <input type="text" class="form-control " name="r_prism_02" > 
                        </div>
                    </div>
                    <div class="form-group">
                        @if ($type_id == $contact_type_id)
                            <label>Кривизна</label>
                        @else 
                            <label>Расстояние между центрами зрачков</label>
                        @endif
                        @if ($type_id == $contact_type_id)
                            <select name="len" class="form-control" required>
                                @for ($i = 10; $i >= -10; $i = round(($i - 0.1), 1))
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        @else 
                            <input type="text" class="form-control " name="len" > 
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Назначение</label>
                        <div class="demo-radio-button">
                            @foreach($ar_propose as $k=>$v)
                                <input name="purpose" type="radio" id="radio_{{ $k }}" {{ $k == 0 ? 'checked' : '' }} value="{{ $v }}">
                                <label for="radio_{{ $k }}">{{ $v }}</label>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Примечание</label>
                        <input type="text" class="form-control" name="note" > 
                    </div>
                    <div class="form-group">
                        <label>ФИО</label>
                        <input type="text" class="form-control" name="user_name" value="{{ $user->name }}" > 
                    </div>
                    <button class="btn btn-info pull-right" type="submit">Сохранить</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="type_id" value="{{ $type_id }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection