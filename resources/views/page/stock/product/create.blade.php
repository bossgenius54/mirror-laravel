
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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Артикул</label>
                                <input type="text" class="form-control " name="artikul" required> 
                            </div>
                            <div class="form-group">
                                <label>Наименование</label>
                                <input type="text" class="form-control " name="name" required> 
                            </div>
                            <div class="form-group">
                                <label>Цена розницы</label>
                                <input type="number" class="form-control " name="price_retail" required> 
                            </div>
                            <div class="form-group">
                                <label>Цена оптов.</label>
                                <input type="number" class="form-control " name="price_opt" required> 
                            </div>
                            <div class="form-group">
                                <label>Мин. кол-во на складе</label>
                                <input type="number" class="form-control " name="min_stock_count" required> 
                            </div>  
                        </div>
                        <div class="col-md-8">
                            @foreach ($types as $type) 
                                <div class="form-group">
                                    <label>{{ $type->name }}</label>
                                    <div class="demo-radio-button">
                                        <input name="option[{{ $type->id }}]" type="radio" id="radio_{{ $type->id }}_0" checked value="0" />
                                        <label for="radio_{{ $type->id }}_0">Не указан</label>
                                        @foreach ($type->relOptions as $option)
                                            <input name="option[{{ $type->id }}]" type="radio" id="radio_{{ $type->id }}_{{ $option->id }}" value="{{ $option->id }}" />
                                            <label for="radio_{{ $type->id }}_{{ $option->id }}">{{ $option->option_name }} </label>
                                        @endforeach
                                    </div>
                                </div>  
                            @endforeach
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