
@extends('layout')

@section('title', $title)

@section('content')

@include('page.stock.branch_product.__filter')

<div class="row">
    <div class="col-12">
        <div class="card table-responsive-lg">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}
                </h4>
            </div>

            <div class="container-fluid">
                <div class="row bg-info text-white">
                    <div class="col-4">Продукт</div>

                    <div class="row col-8">
                        <div class="col-6">Филиал</div>
                        <div class="col-2">Кол-во на складе</div>
                        <div class="col-2">Нужно на складе</div>
                        <div class="col-2">Кол-во докупить</div>
                    </div>

                </div>
                <div class="row">

                    @foreach ($items as $i)
                        <div class="card col-12" style="box-shadow:0px 5px 20px rgba(0, 0, 0, 0.2)">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-4">
                                        {{ $i->name }} ({{ $i->sys_num }})
                                    </div>

                                    @php
                                        $has_el = false;
                                    @endphp

                                    <div class="col-8">
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

                                            <div class="row" style="background-color:{{ $balans >= 0 ? '#c3e6cb' : '#f5c6cb' }};border-bottom: solid 1px #fff; padding:5px;">
                                                <div class="col-6">{{ $name }}</div>
                                                <div class="col-2 text-center" title="Кол-во на складе">{{ $count_pos }}</div>
                                                <div class="col-2 text-center" title="Нужно на складе">{{ $i->min_stock_count }}</div>
                                                <div class="col-2 text-center" title="Кол-во докупить">{{ $balans >= 0 ? 'не нужно' :  -$balans }}</div>
                                            </div>

                                            @php
                                                $has_el = true;
                                            @endphp

                                        @endforeach
                                    </div>

                                @if (!$has_el)
                                    <div class="row">
                                        <div class="col-8 text-center">Нет элементов по выбранному запросу</div>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="row">
                    <div class="col-4">
                        {!! $items->appends($request->all())->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
