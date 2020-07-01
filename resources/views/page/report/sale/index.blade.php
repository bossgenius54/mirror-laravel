
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

                    <form action="{{ action('Report\SaleReportController@getExcel') }}" method="GET">
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
                <div class="container-fluid">
                    <div class="row text-center p-3">
                        <div class="col-md-12">
                            <h4 class="text-primary">По позициям</h4>
                        </div>
                    </div>

                    <div class="row bg-info text-white text-center">
                        <div class="col-md-1 p-1"> # </div>
                        <div class="col-md-1 p-1"> Филиал </div>
                        <div class="col-md-2 p-1"> Категория </div>
                        <div class="col-md-2 p-1"> Ассортимент </div>
                        <div class="col-md-2 p-1"> Системный номер </div>
                        <div class="col-md-1 p-1"> Дата продажи </div>
                        <div class="col-md-1 p-1"> Тип продаж </div>
                        <div class="col-md-1 p-1"> Кол-во товара </div>
                        <div class="col-md-1 p-1"> Сумма продаж </div>

                    </div>
                    @php
                        $p_total_count = 0;
                        $p_total_sum = 0;
                    @endphp

                    @foreach ($p_items as $pi)
                        <div class="row text-center font-weight-bold">
                            <div class="col-md-1 p-1"> # {{$loop->index + 1}} </div>
                            <div class="col-md-1 p-1">  </div>
                            <div class="col-md-2 p-1"> {{ $pi->relCategory->name }} </div>
                            <div class="col-md-2 p-1"> {{ $pi->name }} </div>
                            <div class="col-md-2 p-1"> {{ $pi->sys_num }} </div>
                            <div class="col-md-1 p-1"> - </div>
                            <div class="col-md-1 p-1"> - </div>
                            <div class="col-md-1 p-1">
                                @php
                                    $pi_pos_count = 0;
                                    foreach ($pi->relOrderPosition as $pi_opos) {
                                        $pi_pos_count += $pi_opos->pos_count;
                                    }
                                    $p_total_count += $pi_pos_count;
                                @endphp
                                {{ $pi_pos_count }}
                            </div>
                            <div class="col-md-1 p-1">
                                @php
                                    $total_pi_sum = 0;
                                    foreach ($pi->relOrderPosition as $pi_opos) {
                                        $total_pi_sum += $pi_opos->total_sum;
                                    }
                                    $p_total_sum += $total_pi_sum;
                                @endphp
                                {{ $total_pi_sum }}
                            </div>

                        </div>

                        @foreach ($pi->relOrderPosition as $pi_opos)
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
                                <div class="col-md-1 p-1"> {{ $date->format('d/m/Y') }} </div>
                                <div class="col-md-1 p-1"> {{ $pi_opos->relOrder->is_retail ? 'Розница' : 'Оптом' }} </div>
                                <div class="col-md-1 p-1"> {{ $pi_opos->pos_count }} </div>
                                <div class="col-md-1 p-1"> {{ $pi_opos->total_sum }} </div>

                            </div>
                        @endforeach

                        <hr/>

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

                {{-- Table Order Service--}}
                @if($request->filtered && $request->filtered == 'true' )
                <div class="container-fluid">
                    <div class="row text-center p-3">
                        <div class="col-md-12">
                            <h4 class="text-primary">По услугам</h4>
                        </div>
                    </div>

                    <div class="row bg-info text-white text-center">
                        <div class="col-md-1 p-1"> # </div>
                        <div class="col-md-2 p-1"> Филиал </div>
                        <div class="col-md-3 p-1"> Услуга </div>
                        <div class="col-md-2 p-1"> Стоимость услуги </div>
                        <div class="col-md-1 p-1"> Дата продажи </div>
                        <div class="col-md-1 p-1"> Тип продаж </div>
                        <div class="col-md-1 p-1"> Кол-во </div>
                        <div class="col-md-1 p-1"> Сумма продаж </div>

                    </div>
                    @php
                        $s_total_count = 0;
                        $s_total_sum = 0;
                    @endphp

                    @foreach ($s_items as $si)
                        <div class="row text-center font-weight-bold">
                            <div class="col-md-1 p-1"> # {{$loop->index + 1}} </div>
                            <div class="col-md-2 p-1">  </div>
                            <div class="col-md-3 p-1"> {{ $si->name }} </div>
                            <div class="col-md-2 p-1"> {{ $si->price }} </div>
                            <div class="col-md-1 p-1"> - </div>
                            <div class="col-md-1 p-1"> - </div>
                            <div class="col-md-1 p-1">
                                @php
                                    $si_service_count = 0;
                                    foreach ($si->relOrderService as $si_opos) {
                                        $si_service_count += $si_opos->service_count;
                                    }
                                    $s_total_count += $si_service_count;
                                @endphp
                                {{ $si_service_count }}
                            </div>
                            <div class="col-md-1 p-1">
                                @php
                                    $total_si_sum = 0;
                                    foreach ($si->relOrderService as $si_opos) {
                                        $total_si_sum += $si_opos->total_sum;
                                    }
                                    $s_total_sum += $total_si_sum;
                                @endphp
                                {{ $total_si_sum }}
                            </div>

                        </div>

                        @foreach ($si->relOrderService as $pi_opos)
                            <div class="row text-center">
                                <div class="col-md-1 p-1"> </div>
                                @if ( strlen($ar_branch[$pi_opos->relOrder->branch_id]) > 20 )
                                    <div class="col-md-2 p-1" title="{{$ar_branch[$pi_opos->relOrder->branch_id]}}"> {{ substr( $ar_branch[$pi_opos->relOrder->branch_id], 0, 13 ) . '...' }} </div>
                                @else
                                    <div class="col-md-2 p-1"> {{ $ar_branch[$pi_opos->relOrder->branch_id] }} </div>
                                @endif
                                <div class="col-md-3 p-1"> {{ $si->name }} </div>
                                <div class="col-md-2 p-1"> - </div>
                                @php
                                    $date = new Date($pi_opos->created_at);
                                @endphp
                                <div class="col-md-1 p-1"> {{ $date->format('d/m/Y') }} </div>
                                <div class="col-md-1 p-1"> {{ $pi_opos->relOrder->is_retail ? 'Розница' : 'Оптом' }} </div>
                                <div class="col-md-1 p-1"> {{ $pi_opos->service_count }} </div>
                                <div class="col-md-1 p-1"> {{ $pi_opos->total_sum }} </div>

                            </div>
                        @endforeach

                        <hr/>

                    @endforeach
                    <div class="row text-white text-center" style="border-bottom: 5px solid #1976d2;">
                        <div class="col-md-1 p-1">  </div>
                        <div class="col-md-1 p-1">  </div>
                        <div class="col-md-2 p-1">  </div>
                        <div class="col-md-2 p-1">  </div>
                        <div class="col-md-2 p-1">  </div>
                        <div class="col-md-1 p-1">  </div>
                        <div class="col-md-1 p-1 bg-warning"> Итог: </div>
                        <div class="col-md-1 p-1 bg-warning"> {{ $s_total_count}} шт </div>
                        <div class="col-md-1 p-1 bg-warning"> {{ $s_total_sum }} тг. </div>

                    </div>

                </div>
                @endif
                {{-- End Order Service Table --}}

            </div>

        </div>
    </div>
</div>
@endsection
