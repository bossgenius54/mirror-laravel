
@extends('layout')

@section('title', $title)

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-warning">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Форма фильтрации</h4>
            </div>
            <div class="card-body">
                <form class="form-material row" >
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control " placeholder="Категория" name="cat_name" value="{{ $request->cat_name }}" > 
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control " placeholder="Вид опции" name="type_name" value="{{ $request->type_name }}" > 
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control " placeholder="Наименование опции" name="option_name" value="{{ $request->option_name }}" > 
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control " placeholder="Значение опции" name="option_val" value="{{ $request->option_val }}" > 
                    </div>
                    
                    <div class="form-group col-md-2">
                        <button class="btn btn-warning btn-block" type="submit">Отфильтровать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}  
                    @can('create', App\Model\LibProductOption::class)
                        <a href="{{ action('Lib\LibProductOptionController@getCreate') }}" type="button" 
                            class="btn btn-sm btn-info btn-rounded pull-right" >
                            Добавить
                        </a>
                    @endcan
                </h4>
            </div>
            
            <table class="table  table-hover color-table muted-table" >
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Категория</th>
                        <th>Вид опции</th>
                        <th>Наименование опции</th>
                        <th>Значение опции</th>
                        <th>Изменен</th>
                        <th>Создан</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $i->id }}</td>
                            <td>{{ isset($ar_cat[$i->cat_id]) ? $ar_cat[$i->cat_id] : 'не указано' }}</td>
                            <td>{{ $i->label }}</td>
                            <td>{{ $i->option_name }}</td>
                            <td>{{ $i->option_val }}</td>
                            <td>{{ $i->updated_at }}</td>
                            <td>{{ $i->created_at }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('update', $i)
                                            <a class="dropdown-item" href="{{ action('Lib\LibProductOptionController@getUpdate', $i) }}">
                                                Изменить
                                            </a>
                                        @endcan
                                        @can('delete', $i)
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ action('Lib\LibProductOptionController@getDelete', $i) }}">
                                                Удалить
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            {!! $items->appends($request->all())->links() !!}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
