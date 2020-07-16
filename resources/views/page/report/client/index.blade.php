
@extends('layout')

@section('title', $title)

@section('content')

@include($filter_block)

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">
                    {{ $title }}

                    <form action="{{ action('Report\ClientReportController@getExcel') }}" method="GET">
                        <input type="hidden" name="filtered" value="{{$request->filtered}}" />
                        <input type="hidden" name="name" value="{{$request->name}}" />
                        <input type="hidden" name="sys_num" value="{{$request->sys_num}}" />
                        <input type="hidden" name="branch_id" value="{{$request->branch_id}}" />
                        <input type="hidden" name="created_at_first" value="{{$request->created_at_first}}" />
                        <input type="hidden" name="created_at_second" value="{{$request->created_at_second}}" />
                        <input type="hidden" name="cat_id" value="{{$request->cat_id}}" />

                        <button type="submit"
                                {{$request->filtered && $request->filtered == 'true' ? '' : 'disabled'  }}
                                {{!$request->filtered && $request->filtered != 'true' ? ("title=\"Отфильтруйте!\"") : ''  }}
                                class="btn btn-sm btn-success btn-rounded pull-right" >
                            Загрузить Excel
                        </button>
                    </form>
                </h3>

                {{-- Header information about report --}}
                <div class="row">
                    <div class="col-6">
                        <h5>Период</h5>
                        <p>{{ $request->created_at_first ? ($request->created_at_first . ' - ' . $request->created_at_second) : '' }}</p>

                        <h5>Филиал</h5>
                        <p>
                            @foreach($ar_branch as $id => $name)
                                @if($request->branch_id && $request->branch_id == $id)
                                    <span style="border-radius:30px; background-color: #1976d2; padding: 5px 10px; display:inline-block; margin:5px; color: #fff;"> {{ $name }} </span>
                                @elseif(!$request->branch_id)
                                    <span style="border-radius:30px; background-color: #1976d2; padding: 5px 10px; display:inline-block; margin:5px; color: #fff;"> {{ $name }} </span>
                                @endif
                            @endforeach
                        </p>

                    </div>
                </div>
                {{-- end Header about report --}}

                {{-- Table Order Positions--}}
                @if($request->filtered && $request->filtered == 'true' )

                <div class="container-fluid" style="font-size: 12px;">
                    <div class="row text-center p-3">
                        <div class="col-md-12">
                            <h4 class="text-primary">{{ $title }}</h4>
                        </div>
                    </div>

                    <div class="row bg-info text-white text-center font-weight-bold">
                        <div class="col-md-1 p-1"> # </div>
                        <div class="col-md-6 p-1"> Клиент </div>
                        <div class="col-md-2 p-1"> Кол-во заказов </div>
                        <div class="col-md-3 p-1"> Общая сумма </div>
                    </div>

                    <div class="row text-center font-weight-bold">
                        <div class="col-md-1 p-1 border border-info">  </div>
                        <div class="col-md-3 p-1 border border-info"> Филиал </div>
                        <div class="col-md-3 p-1 border border-info"> Дата </div>
                        <div class="col-md-2 p-1 border border-info"> № заказа </div>
                        <div class="col-md-3 p-1 border border-info"> Сумма </div>
                    </div>

                    @foreach ($clients as $c)

                        <div class="row text-center p-3 font-weight-bold" style="font-size: 12px;">
                            <div class="col-md-1 p-1"> {{ $loop->index + 1 }} </div>
                            <div class="col-md-6 p-1"> {{ $c->name }} </div>
                            <div class="col-md-2 p-1"> {{ $c->relOrder->count() }} </div>
                            @php
                                $total_sum = 0;
                                foreach ($c->relOrder as $order) {
                                    $total_sum += $order->total_sum;
                                }
                            @endphp
                            <div class="col-md-3 p-1"> {{ $total_sum }} </div>
                        </div>

                        @foreach ($c->relOrder as $order)
                            <div class="row text-center">
                                <div class="col-md-1 p-1 ">  </div>
                                <div class="col-md-3 p-1 "> {{ $order->relBranch->name}} </div>
                                @php
                                    $date = new Date($order->created_at);
                                @endphp
                                <div class="col-md-3 p-1 "> {{ $date->format('d.m.Y') }} </div>
                                <div class="col-md-2 p-1 "> Заказ №{{ $order->id}} </div>
                                <div class="col-md-3 p-1 "> {{ $order->total_sum }} </div>
                            </div>
                        @endforeach

                    @endforeach


                </div>
                @endif
                {{-- End Order Positions Table --}}


            </div>

        </div>
    </div>
</div>
@endsection
