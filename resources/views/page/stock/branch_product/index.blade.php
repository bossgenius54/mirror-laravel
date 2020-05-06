
@extends('layout')

@section('title', $title)

@section('content')

@include('page.stock.branch_product.__filter')

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
                        <th>Филиал</th>
                        <th>Кол-во на складе</th>
                        <th>Нужно на складе</th>
                        <th>Кол-во докупить</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)

                        <tr class=" footable-odd" >
                            <td colspan="4" class="text-center" >{{ $i->name }} ({{ $i->sys_num }})</td>
                        </tr>

                        @php
                            $has_el = false;
                        @endphp

                        @foreach ($ar_branch as $id=>$name)

                            @if ($request->branch_name && $request->branch_name != $name)
                                @continue
                            @endif

                            @php
                                $count_pos = $i->relPositions()->where('branch_id', $id)->where('status_id', App\Model\SysPositionStatus::ACTIVE)->count();
                                $balans = $count_pos - $i->min_stock_count;
                            @endphp

                            @if ($request->hidden_null && $count_pos == 0)
                                @continue
                            @endif

                            @if ($request->balans_diff == 'plus' && $balans < 0)
                                @continue
                            @elseif ($request->balans_diff == 'minus' && $balans >= 0)
                                @continue
                            @endif

                            <tr class="footable-even {{ $balans >= 0 ? 'table-success' : 'table-danger' }}">
                                <td >{{ $name }}</td>
                                <td>{{ $count_pos }}</td>
                                <td>{{ $i->min_stock_count }}</td>
                                <td>{{ $balans >= 0 ? 'не нужно' :  -$balans }}</td>
                            </tr>

                            @php
                                $has_el = true;
                            @endphp

                        @endforeach

                        @if (!$has_el)
                            <tr class="footable-even table-info">
                                <td colspan="4" class="text-center" >Нет элементов по выбранному запросу</td>
                            </tr>
                        @endif

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
