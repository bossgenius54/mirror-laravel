@if ($products)
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Сводная по позициям</h4>
        </div>
        @php
            $total_count = 0;
            $total_summ = 0;
        @endphp
        <table class="table  table-hover color-table muted-table" >
            <thead>
                <tr>
                    <th>№</th>
                    <th>Продукция</th>
                    <th>Цена за единицу</th>
                    <th>Кол-во</th>
                    <th>Общая цена</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $i)
                    @php
                        $total_count += $i->product_count;
                        $total_summ += $i->product_sum;
                    @endphp
                    <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $i->relProduct ? $i->relProduct->name.' ('.$i->relProduct->sys_num.')' : '' }}</td> 
                        <td>{{ $i->price_after }}</td>
                        <td>{{ $i->product_count }}</td>
                        <td>{{ $i->product_sum }}</td>
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
    </div>
@endif