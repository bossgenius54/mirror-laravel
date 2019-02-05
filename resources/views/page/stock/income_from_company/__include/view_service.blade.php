
@if ($services->count() > 0)
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Позиции приемки</h4>
        </div>
        @php
            $total_count = 0;
            $total_summ = 0;
        @endphp
        <table class="table  table-hover color-table muted-table" >
            <thead>
                <tr>
                    <th>№</th>
                    <th>Услуга</th>
                    <th>Цена ед. </th>
                    <th>Кол-во</th>
                    <th>Общая сумма</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $i)
                    @php
                        $total_count += $i->service_count;
                        $total_summ += $i->total_sum;
                    @endphp
                    <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $i->relService ? $i->relService->name : '' }}</td>
                        <td>{{ $i->service_cost }}</td>
                        <td>{{ $i->service_count }}</td>
                        <td>{{ $i->total_sum }}</td>
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