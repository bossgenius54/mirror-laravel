
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

                    <form action="{{ action('Report\ProfitReportController@getExcel') }}" method="GET">
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
                            <h4 class="text-primary">Отчет о прибыли</h4>
                        </div>
                    </div>

                    <div class="row text-center p-3">
                        <div class="col-md-5 text-primary">
                            Филиал
                        </div>
                        <div class="col-md-7 text-primary">
                            Менеджеры данного филиала
                        </div>
                    </div>

                    <div class="row bg-info text-white text-center font-weight-bold">
                        <div class="col-md-5 row">
                            <div class="col-md-2 p-1"> # </div>
                            <div class="col-md-4 p-1"> Категория товара </div>
                            <div class="col-md-2 p-1"> Наименование </div>
                            <div class="col-md-4 p-1"> Системный номера </div>
                        </div>

                        <div class="col-md-7 row">
                            <div class="col-md-1 p-1"> Кол-во товаров </div>
                            <div class="col-md-2 p-1"> Общая себестоимость </div>
                            <div class="col-md-2 p-1">  </div>
                            <div class="col-md-2 p-1">  </div>
                            <div class="col-md-2 p-1"> Общая сумма продажи </div>
                            <div class="col-md-3 p-1"> Сумма прибыли </div>
                        </div>

                    </div>

                    <div class="row bg-info text-white text-center">
                        <div class="col-md-5 row">
                            <div class="col-md-2 p-1">  </div>
                            <div class="col-md-2 p-1"> № оприходования </div>
                            <div class="col-md-1 p-1"> № заказа </div>
                            <div class="col-md-1 p-1"> Дата продажи </div>
                            <div class="col-md-2 p-1"> Наименование </div>
                            <div class="col-md-4 p-1"> Системный номера </div>
                        </div>

                        <div class="col-md-7 row">
                            <div class="col-md-1 p-1"> Кол-во </div>
                            <div class="col-md-2 p-1"> Cебестоимость </div>
                            <div class="col-md-2 p-1"> Вид продажи </div>
                            <div class="col-md-2 p-1"> Стоимость </div>
                            <div class="col-md-2 p-1"> Сумма продажи </div>
                            <div class="col-md-3 p-1"> Сумма прибыли </div>
                        </div>
                    </div>

                    @php
                        $p_total_count = 0;
                        $p_total_price_cost = 0;
                        $p_total_sum = 0;
                    @endphp

                    @foreach ($managers as $manager)
                        <div class="row text-center p-3" style="font-size: 12px;">
                            <div class="col-md-5 text-primary">
                                {{ $manager->branch_id ? $ar_branch[$manager->branch_id] : $manager->relCompany->name }}
                            </div>
                            <div class="col-md-7 text-primary">
                                {{$manager->name}} ({{ $manager->getClearTypeName() }})
                            </div>
                        </div>

                        @foreach ($p_items as $pi)

                            @php

                                $allow_product_count = false;
                                foreach ($pi->relOrderPosition as $op) {
                                    $allow_product_count = $op->relOrder->created_user_id == $manager->id ? true : false;

                                    if ($allow_product_count == true)
                                        break;
                                }
                            @endphp

                            @if ($allow_product_count)

                            <div class="row text-center font-weight-bold" style="font-size: 12px;">
                                <div class="col-md-5 row">
                                    <div class="col-md-2 p-1"> # {{$loop->index + 1}} </div>
                                    <div class="col-md-4 p-1"> {{ $pi->relCategory->name }} </div>
                                    <div class="col-md-2 p-1"> {{ $pi->name }} </div>
                                    <div class="col-md-4 p-1"> {{ $pi->sys_num }} </div>
                                </div>


                                <div class="col-md-7 row">
                                    <div class="col-md-1 p-1">
                                        @php
                                            $pi_pos_count = 0;
                                            foreach ($pi->relOrderPosition as $pi_opos) {
                                                if($pi_opos->relOrder->created_user_id == $manager->id)
                                                    $pi_pos_count += $pi_opos->pos_count;
                                            }
                                            $p_total_count += $pi_pos_count;
                                        @endphp
                                        {{ $pi_pos_count }}
                                    </div>
                                    <div class="col-md-2 p-1">
                                        @php
                                            $pi_price_cost = 0;
                                            $watched_orders = [];
                                            foreach ($pi->relOrderPosition as $pi_op) {

                                                if (in_array($pi_op->order_id, $watched_orders)) {
                                                    continue;
                                                }

                                                if($pi_op->relOrder->created_user_id != $manager->id)
                                                    continue;

                                                foreach ($pi_op->relOrder->relPositions as $p) {
                                                    $pi_price_cost += $p->price_cost;
                                                }

                                                array_push($watched_orders, $pi_op->order_id);

                                            }
                                            $p_total_price_cost += $pi_price_cost;
                                        @endphp
                                        {{ $pi_price_cost }}
                                    </div>
                                    <div class="col-md-2 p-1">  </div>
                                    <div class="col-md-2 p-1">  </div>
                                    <div class="col-md-2 p-1">
                                        @php
                                            $pi_profit = 0;
                                            foreach ($pi->relOrderPosition as $pi_opos) {
                                                if($pi_opos->relOrder->created_user_id == $manager->id)
                                                    $pi_profit += $pi_opos->total_sum;
                                            }
                                            $p_total_sum += $pi_profit;
                                        @endphp
                                        {{ $pi_profit }}
                                    </div>
                                    <div class="col-md-3 p-1"> {{ $pi_profit - $pi_price_cost }} </div>
                                </div>

                            </div>

                            @foreach ($pi->relOrderPosition as $rop)
                                @if ($rop->relOrder->created_user_id == $manager->id)
                                    <div class="row text-center">
                                        <div class="col-md-5 row">
                                            <div class="col-md-2 p-1">  </div>
                                            <div class="col-md-2 p-1"> Оприходования #{{$rop->relOrder->relPositions->first()->income_id}} </div>
                                            <div class="col-md-1 p-1"> Заказ #{{$rop->order_id}} </div>
                                            @php
                                                $date = new Date($rop->created_at);
                                            @endphp
                                            <div class="col-md-1 p-1"> {{ $date->format('d.m.Y') }} </div>
                                            <div class="col-md-2 p-1"> {{ $pi->name }} </div>
                                            <div class="col-md-4 p-1"> {{ $pi->sys_num }} </div>
                                        </div>

                                        <div class="col-md-7 row">
                                            <div class="col-md-1 p-1"> {{ $rop->pos_count }} </div>
                                            <div class="col-md-2 p-1"> {{$rop->relOrder->relPositions->first()->price_cost}} </div>
                                            <div class="col-md-2 p-1"> {{$rop->relOrder->is_retail ? 'Розница' : 'Оптом'}} </div>
                                            <div class="col-md-2 p-1"> {{ $rop->pos_cost }} </div>
                                            <div class="col-md-2 p-1"> {{ $rop->total_sum }} </div>
                                            <div class="col-md-3 p-1"> {{ $rop->total_sum - ($rop->relOrder->relPositions->first()->price_cost * $rop->pos_count) }} </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <hr/>
                            @endif

                            {{-- @foreach ($pi->relOrderPosition as $pi_opos)
                                <div class="row text-center">
                                    <div class="col-md-1 p-1"> </div>

                                    @if ( strlen($ar_branch[$pi_opos->relOrder->branch_id]) > 20 )
                                        <div class="col-md-1 p-1" title="{{$ar_branch[$pi_opos->relOrder->branch_id]}}"> {{ substr( $ar_branch[$pi_opos->relOrder->branch_id], 0, 13 ) . '...' }} </div>
                                    @else
                                        <div class="col-md-1 p-1"> {{ $ar_branch[$pi_opos->relOrder->branch_id] }} </div>
                                    @endif

                                    <div class="col-md-2 p-1"> </div>
                                    <div class="col-md-2 p-1"> {{ $pi->name }} </div>
                                    <div class="col-md-2 p-1"> {{ $pi->sys_num }} </div>
                                    @php
                                        $date = new Date($pi_opos->created_at);
                                    @endphp
                                    <div class="col-md-1 p-1"> {{ $date->format("d.m.Y") }} </div>
                                    <div class="col-md-1 p-1"> {{ $pi_opos->relOrder->is_retail ? 'Розница' : 'Оптом' }} </div>
                                    <div class="col-md-1 p-1"> {{ $pi_opos->pos_count }} </div>
                                    <div class="col-md-1 p-1"> {{ $pi_opos->total_sum }} </div>

                                </div>
                            @endforeach --}}


                        @endforeach

                    @endforeach


                    <div class="row text-white text-center" style="border-bottom: 5px solid #1976d2;">
                        <div class="col-md-1 p-1">  </div>
                        <div class="col-md-1 p-1">  </div>
                        <div class="col-md-2 p-1">  </div>
                        <div class="col-md-2 p-1">  </div>
                        <div class="col-md-2 p-1">  </div>
                        <div class="col-md-1 p-1">  </div>
                        <div class="col-md-1 p-1 bg-warning"> Итог: </div>
                        <div class="col-md-1 p-1 bg-warning"> {{ $p_total_count}} шт </div>
                        <div class="col-md-1 p-1 bg-warning"> {{ $p_total_sum }} тг. </div>

                    </div>

                </div>
                @endif
                {{-- End Order Positions Table --}}


            </div>

        </div>
    </div>
</div>
@endsection
