
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

                    <form action="{{ action('Report\IncomeReturnedReportController@getExcel') }}" method="GET">
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
                        <div class="col-md-7 text-primary">
                            Филиал
                        </div>
                        <div class="col-md-5 text-primary">
                            Менеджеры данного филиала
                        </div>
                    </div>

                    <div class="row bg-info text-white text-center font-weight-bold">
                        <div class="col-md-7 row">
                            <div class="col-md-1 p-1"> # </div>
                            <div class="col-md-4 p-1"> Клиент </div>
                            <div class="col-md-4 p-1"> Создатель {Роль + ФИО} </div>
                            <div class="col-md-2 p-1"> № Заказа </div>
                            <div class="col-md-1 p-1"> От </div>
                        </div>

                        <div class="col-md-5 row">
                            <div class="col-md-3 p-1"> Дата продажи </div>
                            <div class="col-md-3 p-1"> Дата возврата </div>
                            <div class="col-md-3 p-1"> Общая сумма </div>
                            <div class="col-md-3 p-1"> Автор возврата </div>
                        </div>
                    </div>

                    <div class="row bg-info text-white text-center">
                        <div class="col-md-5 row">
                            <div class="col-md-1 p-1">  </div>
                            <div class="col-md-2 p-1"> Категория </div>
                            <div class="col-md-2 p-1"> Наименование </div>
                            <div class="col-md-4 p-1"> Системный номер </div>
                            <div class="col-md-2 p-1"> Кол-во </div>
                            <div class="col-md-1 p-1"> Цена розницы </div>
                        </div>

                        <div class="col-md-7 row">
                            <div class="col-md-3 p-1"> Оптовая цена </div>
                            <div class="col-md-6 p-1"> Тип продажи </div>
                            <div class="col-md-3 p-1"> Фактическая цена продажи </div>
                        </div>
                    </div>

                    <div class="row bg-info text-white text-center">
                        <div class="col-md-5 row">
                            <div class="col-md-8 p-1"> Услуга </div>
                            <div class="col-md-2 p-1"> Кол-во </div>
                            <div class="col-md-2 p-1"> Цена </div>
                        </div>

                        <div class="col-md-7 row">
                            <div class="col-md-3 p-1">  </div>
                            <div class="col-md-6 p-1">  </div>
                            <div class="col-md-3 p-1"> Фактическая цена продажи </div>
                        </div>
                    </div>

                    @php
                        $p_total_count = 0;
                        $s_total_count = 0;
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

                        @foreach ($income_items as $ii)

                            @if ($ii->user_id == $manager->id)

                                @php
                                    $p_total_count += $ii->relIncomePositions->count();
                                    $s_total_count += $ii->relIncomeService->count();
                                    $p_total_sum += $ii->related_cost;
                                @endphp

                                <div class="row text-center font-weight-bold">
                                    <div class="col-md-7 row">
                                        <div class="col-md-1 p-1"> #{{$loop->index + 1 }} </div>
                                        <div class="col-md-4 p-1"> {{ $ii->relFromUser ? $ii->relFromUser->name : $ii->relFromCompany->name }} </div>
                                        <div class="col-md-4 p-1"> {{ $ii->relCreatedUser->name . ' (' . $ii->relCreatedUser->getClearTypeName() . ')' }} </div>
                                        <div class="col-md-2 p-1"> № {{ $ii->order_id }} </div>
                                        <div class="col-md-1 p-1"> {{ $order_types[$ii->relOrder->type_id] }} </div>
                                    </div>

                                    <div class="col-md-5 row">
                                        @php
                                            $order_data = new Date($ii->relOrder->updated_at);
                                        @endphp
                                        <div class="col-md-3 p-1"> {{ $order_data->format('d.m.Y') }} </div>
                                        @php
                                            $returned_data = new Date($ii->created_at);
                                        @endphp
                                        <div class="col-md-3 p-1"> {{ $returned_data->format('d.m.Y') }} </div>
                                        <div class="col-md-3 p-1"> {{ $ii->related_cost }} </div>
                                        <div class="col-md-3 p-1"> {{ $ii->relCreatedUser->name . ' (' . $ii->relCreatedUser->getClearTypeName() . ')' }} </div>
                                    </div>
                                </div>

                                @foreach ($ii->relIncomePositions as $ip)
                                    <div class="row text-center">
                                        <div class="col-md-5 row">
                                            <div class="col-md-1 p-1">  </div>
                                            <div class="col-md-2 p-1"> {{ $ar_cat[$ip->relPosition->relProduct->cat_id] }} </div>
                                            <div class="col-md-2 p-1"> {{ $ip->relPosition->relProduct->name }} </div>
                                            <div class="col-md-4 p-1"> {{ $ip->relPosition->relProduct->sys_num }} </div>
                                            <div class="col-md-2 p-1"> 1 </div>
                                            <div class="col-md-1 p-1"> {{ $ip->relPosition->relProduct->price_retail }} </div>
                                        </div>

                                        <div class="col-md-7 row">
                                            <div class="col-md-3 p-1"> {{ $ip->relPosition->relProduct->price_opt }} </div>
                                            <div class="col-md-6 p-1"> {{ $ii->relOrder->is_retail ? 'Розница' : 'Оптом' }} </div>
                                            <div class="col-md-3 p-1">  </div>
                                        </div>
                                    </div>
                                @endforeach

                                @foreach ($ii->relIncomeService as $is)
                                    <div class="row text-center">
                                        <div class="col-md-5 row">
                                            <div class="col-md-8 p-1"> {{ $is->relService->name }} </div>
                                            <div class="col-md-2 p-1"> {{ $is->service_count }} шт </div>
                                            <div class="col-md-2 p-1"> {{ $is->relService->price }} тг </div>
                                        </div>

                                        <div class="col-md-7 row">
                                            <div class="col-md-3 p-1">  </div>
                                            <div class="col-md-6 p-1"> {{ $ii->relOrder->is_retail ? 'Розница' : 'Оптом' }}  </div>
                                            <div class="col-md-3 p-1"> {{ $is->total_sum }} </div>
                                        </div>
                                    </div>
                                @endforeach

                            @endif

                        @endforeach

                        @php
                            $empty_manager = false;

                            foreach($income_items as $inc){
                                if ($inc->relCreatedUser->id == $manager->id) {
                                    $empty_manager = true;
                                }
                            }
                        @endphp

                        @if ($empty_manager == false)
                            <div class="row text-center p-3" style="font-size: 12px;">
                                <div class="col-md-12 text-secondary">
                                    У данного пользователя на этот промежуток нет элементов возврата
                                </div>
                            </div>
                        @endif

                            <hr/>
                    @endforeach


                    <div class="row text-white text-center" style="border-bottom: 5px solid #1976d2;">
                        <div class="col-md-1 p-1">  </div>
                        <div class="col-md-1 p-1">  </div>
                        <div class="col-md-2 p-1">  </div>
                        <div class="col-md-2 p-1">  </div>
                        <div class="col-md-2 p-1">  </div>
                        <div class="col-md-1 p-1 bg-warning"> Итог: </div>
                        <div class="col-md-1 p-1 bg-warning"> {{ $p_total_count}} шт </div>
                        <div class="col-md-1 p-1 bg-warning"> {{ $s_total_count}} шт </div>
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
