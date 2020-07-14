
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

                    <form action="{{ action('Report\CashReportController@getExcel') }}" method="GET">
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

                    <div class="row text-center p-3">
                        <div class="col-md-6 text-primary">
                            Филиал
                        </div>
                        <div class="col-md-6 text-primary">
                            Менеджеры данного филиала
                        </div>
                    </div>

                    <div class="row bg-info text-white text-center font-weight-bold">
                        <div class="col-md-1 p-1"> # </div>
                        <div class="col-md-2 p-1"> № Заказа </div>
                        <div class="col-md-3 p-1"> Дата </div>
                        <div class="col-md-3 p-1"> Клиент </div>
                        <div class="col-md-1 p-1"> Статус </div>
                        <div class="col-md-1 p-1"> Вид </div>
                        <div class="col-md-1 p-1"> Сумма </div>
                    </div>

                    @php
                        $p_total_sum = 0;
                    @endphp

                    @foreach ($managers as $manager)
                        <div class="row text-center p-3" style="font-size: 12px;">
                            <div class="col-md-7 text-primary">
                                {{ $manager->branch_id ? $ar_branch[$manager->branch_id] : $manager->relCompany->name }}
                            </div>
                            <div class="col-md-5 text-primary">
                                {{$manager->name}} ({{ $manager->getClearTypeName() }})
                            </div>
                        </div>

                        @foreach ($order_items as $oi)

                            @if ($oi->relCreatedUser->id == $manager->id)

                                @php
                                    $p_total_sum += $oi->status_id == $status_end ? $oi->total_sum : $oi->prepay_sum;
                                @endphp

                                <div class="row text-center font-weight-bold">
                                    <div class="col-md-1 p-1"> {{ $loop->index + 1 }} </div>
                                    <div class="col-md-2 p-1"> Заказ №{{ $oi->id }} </div>
                                    @php
                                        $order_date = new Date($oi->updated_at);
                                    @endphp
                                    <div class="col-md-3 p-1"> {{ $order_date->format('d.m.Y') }} </div>
                                    <div class="col-md-3 p-1"> {{ $oi->type_id == 1 ? $oi->relPersonCLient->name : ($oi->relCompanyCLient ? $oi->relCompanyCLient->name : '') }} </div>
                                    <div class="col-md-1 p-1"> {{ $oi->relStatus->name }} </div>
                                    <div class="col-md-1 p-1"> {{ $oi->status_id == $status_end ? 'Оплата заказа' : 'Предоплата' }} </div>
                                    <div class="col-md-1 p-1"> {{ $oi->status_id == $status_end ? $oi->total_sum : ($oi->prepay_sum != '' ? $oi->prepay_sum : '-') }} </div>
                                </div>

                            @endif

                        @endforeach

                        @php
                            $empty_manager = false;

                            foreach($order_items as $inc){
                                if ($inc->relCreatedUser->id == $manager->id) {
                                    $empty_manager = true;
                                }
                            }
                        @endphp

                        @if ($empty_manager == false)
                            <div class="row text-center p-3" style="font-size: 12px;">
                                <div class="col-md-12 text-secondary">
                                    У данного пользователя на этот промежуток нет элементов заказа
                                </div>
                            </div>
                        @endif

                            <hr/>
                    @endforeach


                    <div class="row text-white text-center" style="border-bottom: 5px solid #1976d2;">
                        <div class="col-md-10 p-1"> </div>

                        <div class="col-md-1 p-1"> Итого </div>
                        <div class="col-md-1 p-1"> {{ $p_total_sum }} </div>
                    </div>

                </div>
                @endif
                {{-- End Order Positions Table --}}


            </div>

        </div>
    </div>
</div>
@endsection
