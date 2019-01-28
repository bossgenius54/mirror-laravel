
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}  
                    @can('create', App\Model\View\OfflineOrder::class)
                        <div class="btn-group btn-group-sm pull-right">
                            <button type="button" class="btn btn-info btn-rounde dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Добавить
                            </button>
                            <div class="dropdown-menu">
                                @foreach ($ar_type as $k=>$v)
                                    <a href="{{ action('Order\OfflineOrderController@getCreate', $k) }}" 
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
                        <th>Тип</th>
                        <th>Статус</th>
                        <th>Филиал</th>
                        <th>Клиент</th>
                        <th>Наименование</th>
                        <th>Общая сумма</th>
                        <th>Предоплата</th>
                        <th>Создатель</th>
                        <th>Изменен</th>
                        <th>Создан</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $i->id }}</td>
                            <td>{{ isset($ar_type[$i->type_id]) ? $ar_type[$i->type_id] : 'не указано' }}</td>
                            <td>{{ isset($ar_status[$i->status_id]) ? $ar_status[$i->status_id] : 'не указано' }}</td>
                            <td>{{ $i->getClient() ? $i->getClient()->name : 'не указано' }}</td>
                            <td>{{ $i->name }}</td>
                            <td>{{ $i->total_sum }}</td>
                            <td>{{ $i->prepay_sum }}</td>
                            <td>{{ $i->relCreatedUser ? $i->relCreatedUser->name : 'не указано'  }}</td>
                            <td>{{ $i->updated_at }}</td>
                            <td>{{ $i->created_at }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings"></i>
                                    </button>
                                    <div class="dropdown-menu">

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
