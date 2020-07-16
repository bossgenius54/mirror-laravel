
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

                    <form action="{{ action('Report\IncomeFromCompanyReportController@getExcel') }}" method="GET">
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
                        <div class="col-md-6 p-1"> Филиал </div>
                        <div class="col-md-6 p-1"> Автор </div>
                    </div>

                    <div class="row bg-info text-white text-center font-weight-bold">
                        <div class="col-md-1 p-1"> # </div>
                        <div class="col-md-2 p-1"> № Оприходования </div>
                        <div class="col-md-1 p-1"> Дата </div>
                        <div class="col-md-1 p-1"> Заметка </div>
                        <div class="col-md-1 p-1"> Статус </div>
                        <div class="col-md-3 p-1"> Поставщик </div>
                        <div class="col-md-1 p-1"> Кол-во товаров </div>
                        <div class="col-md-1 p-1"> Общая сумма </div>
                        <div class="col-md-1 p-1"> Расчет с поставщиком </div>
                    </div>

                    <div class="row text-center font-weight-bold">
                        <div class="col-md-1 p-1 border border-info">  </div>
                        <div class="col-md-2 p-1 border border-info"> Категория  </div>
                        <div class="col-md-1 p-1 border border-info"> Наименование </div>
                        <div class="col-md-2 p-1 border border-info"> Системный номер </div>
                        <div class="col-md-2 p-1 border border-info"> Себестоимость </div>
                        <div class="col-md-1 p-1 border border-info"> Шт </div>
                        <div class="col-md-2 p-1 border border-info"> Себестоимость </div>
                        <div class="col-md-1 p-1 border border-info">  </div>
                    </div>

                    @foreach ($managers as $manager)

                        <br/>
                        <br/>

                        <div class="row text-center p-3" style="font-size: 12px;">
                            <div class="col-md-6 text-primary">
                                {{ $manager->branch_id ? $ar_branch[$manager->branch_id] : $manager->relCompany->name }}
                            </div>
                            <div class="col-md-6 text-primary">
                                {{$manager->name}} ({{ $manager->getClearTypeName() }})
                            </div>
                        </div>

                        @foreach ($income_items as $ii)

                            @if ($ii->relCreatedUser->id == $manager->id )
                                <div class="row  text-center font-weight-bold">
                                    <div class="col-md-1 p-1"> {{ $loop->index + 1 }} </div>
                                    <div class="col-md-2 p-1"> №{{ $ii->id}} </div>
                                    @php
                                        $created_at = new Date($ii->created_at);
                                    @endphp
                                    <div class="col-md-1 p-1"> {{ $created_at->format('d.m.Y') }} </div>
                                    <div class="col-md-1 p-1"> {{ $ii->note }} </div>
                                    <div class="col-md-1 p-1"> {{ isset($ar_status[$ii->relPositions->first()->status_id]) ? $ar_status[$ii->relPositions->first()->status_id] : 'не указано' }} </div>
                                    <div class="col-md-3 p-1"> {{ $ii->relFromCompany->name }} </div>
                                    <div class="col-md-1 p-1"> {{ $ii->relIncomePositions->count() }} </div>
                                    @php
                                        $total_price_cost = 0;
                                        foreach ($ii->relIncomePositions as $ip) {
                                            $total_price_cost += $ip->relPosition->price_cost;
                                        }
                                    @endphp
                                    <div class="col-md-1 p-1"> {{ $total_price_cost }} </div>
                                    <div class="col-md-1 p-1"> - </div>
                                </div>

                                @foreach ($ii->relIncomePositions as $ip)
                                    <div class="row text-center ">
                                        <div class="col-md-1 p-1 ">  </div>
                                        <div class="col-md-2 p-1 "> {{ $ip->relPosition ? $ar_cat[$ip->relPosition->relProduct->cat_id] : 'не указано' }}  </div>
                                        <div class="col-md-1 p-1 "> {{ $ip->relPosition ? $ip->relPosition->relProduct->name : 'не указано' }} </div>
                                        <div class="col-md-2 p-1 ">  {{ $ip->relPosition ? $ip->relPosition->relProduct->sys_num : 'не указано' }}  </div>
                                        <div class="col-md-2 p-1 "> {{ $ip->relPosition ? $ip->relPosition->price_cost : 'не указано' }}   </div>
                                        <div class="col-md-1 p-1 "> 1 </div>
                                        <div class="col-md-2 p-1 "> {{ $ip->relPosition ? $ip->relPosition->price_cost : 'не указано' }} </div>
                                        <div class="col-md-1 p-1 ">  </div>
                                    </div>
                                @endforeach

                            @endif

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
