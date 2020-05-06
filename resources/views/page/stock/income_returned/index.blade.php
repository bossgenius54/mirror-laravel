
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
                </h4>
            </div>

            <table class="table  table-hover color-table muted-table" >
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Тип</th>
                        <th>Филиал</th>
                        <th>Номер заказа</th>
                        <th>Сумма</th>
                        <th>Заметка</th>
                        <th>Изменен</th>
                        <th>Создан</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $i->id }}</td>
                            <th>{{ isset($ar_type[$i->type_id]) ? $ar_type[$i->type_id] : '' }}</th>
                            <td>{{ $i->relBranch ? $i->relBranch->name : '' }}</td>
                            <td>
                                @if( $i->order_id )
                                    @php
                                        $url = url("/order/item/view/{$i->order_id}");
                                    @endphp

                                    <a href="{{ $url }}"> № {{ $i->order_id }} </a>
                                @endif
                            </td>
                            <td>{{ $i->related_cost }}</td>
                            <td>{{ $i->note }}</td>
                            <td>{{ $i->updated_at }}</td>
                            <td>{{ $i->created_at }}</td>
                            <td>
                                @can('view', $i)
                                    <a class="btn btn-info btn-sm" href="{{ action('Stock\IncomeReturnedController@getView', $i) }}">
                                        Детально
                                    </a>
                                @endcan
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
