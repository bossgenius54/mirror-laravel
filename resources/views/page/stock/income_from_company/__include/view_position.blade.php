
@if ($positions && $positions->count() > 0)
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Услуги отгрузки</h4>
        </div>
        @php
            $total_summ = 0;
        @endphp
        <table class="table  table-hover color-table muted-table" >
            <thead>
                <tr>
                    <th>№</th>
                    <th>Продукция</th>
                    <th>Цена </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($positions as $i)
                    @php
                        $total_summ += $i->price_before;
                    @endphp
                    <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $i->relProduct ? $i->relProduct->name.' ('.$i->relProduct->sys_num.')' : '' }}</td> 
                        <td>{{ $i->price_before }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        Итого
                    </td>
                    <td colspan="1">{{ $total_summ }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endif