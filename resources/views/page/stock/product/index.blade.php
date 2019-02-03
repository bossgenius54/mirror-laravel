
@extends('layout')

@section('title', $title)

@section('content')

@include($filter_block)

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}  
                    @can('create', App\Model\Product::class)
                        
                        <div class="btn-group btn-group-sm pull-right">
                            <button type="button" class="btn btn-info btn-rounde dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Добавить
                            </button>
                            <div class="dropdown-menu">
                                @foreach ($ar_cat as $k=>$v)
                                    <a href="{{ action('Stock\ProductController@getCreate', $k) }}" 
                                        class="dropdown-item " >
                                        Добавить "{{ $v }}"
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endcan
                </h4>
            </div>
            
            <table class="table  table-hover color-table muted-table" >
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Категория</th>
                        <th>Системный номер</th>
                        <th>Артикул</th>
                        <th>Наименование</th>
                        <th>Цена розницы</th>
                        <th>Цена оптов.</th>
                        <th>Мин. кол-во на складе</th>
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
                            <td>{{ $i->sys_num }}</td>
                            <td>{{ $i->artikul }}</td>
                            <td>{{ $i->name }}</td>
                            <td>{{ $i->price_retail }}</td>
                            <td>{{ $i->price_opt }}</td>
                            <td>{{ $i->min_stock_count }}</td>
                            <td>{{ $i->updated_at }}</td>
                            <td>{{ $i->created_at }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ action('Stock\PositionController@getIndex', ['product_id' => $i->id]) }}">
                                            Позиции/Товары
                                        </a>
                                        @can('update', $i)
                                            <a class="dropdown-item" href="{{ action('Stock\ProductController@getUpdate', $i) }}">
                                                Изменить
                                            </a>
                                        @endcan
                                        @can('delete', $i)
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ action('Stock\ProductController@getDelete', $i) }}">
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
