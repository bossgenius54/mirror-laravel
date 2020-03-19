
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
                        <label>Филиал</label>
                        <select name="branch_id" class="form-control" required>
                            @foreach ($ar_branch as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Тип</label>
                        <div class="demo-radio-button">
                            <input name="is_retail" type="radio" id="is_retail_0" class="with-gap radio-col-teal" value="0">
                            <label for="is_retail_0">Оптовая продажа</label>
                            <input name="is_retail" type="radio" id="is_retail_1" class="with-gap radio-col-teal" checked="" value="1">
                            <label for="is_retail_1">Розница</label>
                        </div>
                    </div>
                    @if ($type->id == App\Model\SysOrderType::PERSON)
                        <div class="form-group">
                            <label>Физ. лицо</label>
                            <select name="from_user_id" class="form-control" required>
                                @foreach ($individs as $k => $v)
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="form-group">
                            <label>Юр. лицо</label>
                            <select name="from_company_id" class="form-control" required>
                                @foreach ($companies as $k => $v)
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label>Заметка</label>
                        <input type="text" class="form-control" name="name" >
                    </div>
                    <button class="btn btn-info pull-right" type="submit">Далее</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
