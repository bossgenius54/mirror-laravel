@if ($order_products->count() > 0)
    @php
        $total_count = 0;
        $total_summ = 0;
    @endphp
    <table class="table  table-hover color-table muted-table" >
        <thead>
            <tr>
                <th>№</th>
                <th>Продукция</th>
                <th>Цена ед. </th>
                <th>Кол-во</th>
                <th>Общая сумма</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order_products as $i)
                @php
                    $total_count += $i->pos_count;
                    $total_summ += $i->total_sum;
                @endphp

                <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $i->relProduct ? $i->relProduct->name.' ('.$i->relProduct->sys_num.')' : '' }}</td> 
                    <td>{{ $i->pos_cost }}</td>
                    <td>{{ $i->pos_count }}</td>
                    <td>{{ $i->total_sum }}</td>
                    <td>
                        @can('position', $item)
                            <a href="{{ action('Order\PositionOrderController@getDeleteProduct', [$item, $i]) }}" class="btn btn-danger btn-sm">
                                Убрать
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    Итого
                </td>
                <td>{{ $total_count }}</td>
                <td colspan="2">{{ $total_summ }}</td>
            </tr>
        </tfoot>
        
    </table>
@endif