
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

                    <form action="{{ action('Report\MotionReportController@getExcel') }}" method="GET">
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

                    <div class="row bg-info text-white text-center p-3">
                        <div class="col-md-12 ">
                            Из Филиала
                        </div>
                    </div>

                    <div class="row bg-info text-white text-center font-weight-bold">
                        <div class="col-md-1 p-1"> # </div>
                        <div class="col-md-1 p-1"> № перемещения </div>
                        <div class="col-md-1 p-1"> Наименование </div>
                        <div class="col-md-1 p-1"> Статус </div>
                        <div class="col-md-1 p-1"> В филиал </div>
                        <div class="col-md-2 p-1"> Создатель {Роль + ФИО} </div>
                        <div class="col-md-1 p-1"> Дата создания </div>
                        <div class="col-md-1 p-1"> Автор подтверждения </div>
                        <div class="col-md-1 p-1"> Дата подтверждения </div>
                        <div class="col-md-1 p-1"> Общее кол-во </div>
                        <div class="col-md-1 p-1"> Сумма себестоимости </div>
                    </div>

                    <div class="row  text-center font-weight-bold">
                        <div class="col-md-1 p-1 border border-info">  </div>
                        <div class="col-md-1 p-1 border border-info"> Категория  </div>
                        <div class="col-md-1 p-1 border border-info"> Наименование </div>
                        <div class="col-md-2 p-1 border border-info"> Системный номер	 </div>
                        <div class="col-md-3 p-1 border border-info"> № оприходования	 </div>
                        <div class="col-md-1 p-1 border border-info"> Дата оприходования </div>
                        <div class="col-md-1 p-1 border border-info"> Себестоимость </div>
                        <div class="col-md-2 p-1 border border-info"> Статус товара после перемещения	 </div>
                    </div>

                    @php
                        $p_total_sum = 0;
                    @endphp

                    @foreach ($ar_branch as $id => $branch)
                        <br/>

                        <div class="card">
                            <div class="card-body">

                                <div class="row text-center p-3" style="font-size: 12px;">
                                    <div class="col-md-12 text-primary">
                                        {{ $branch }}
                                    </div>
                                </div>

                                @foreach ($motion_items as $oi)

                                    @if ($oi->from_branch_id == $id)
                                        @php
                                            // $p_total_sum += $oi->status_id == $status_end ? $oi->total_sum : $oi->prepay_sum;
                                        @endphp

                                        <br/>
                                        <br/>
                                        <br/>

                                        <div class="row text-center font-weight-bold">
                                            <div class="col-md-1 p-1"> {{ $loop->index + 1 }} </div>
                                            <div class="col-md-1 p-1"> №{{ $oi->id }} </div>
                                            <div class="col-md-1 p-1"> {{ $oi->name }} </div>
                                            <div class="col-md-1 p-1"> {{ $oi->relStatus->name }} </div>
                                            <div class="col-md-1 p-1"> {{ $oi->relToBranch->name }} </div>
                                            <div class="col-md-2 p-1"> {{ $oi->relCreatedUser->name . ' (' . $oi->relCreatedUser->getClearTypeName() . ')'}} </div>
                                            @php
                                                $created_at = new Date($oi->created_at);
                                            @endphp
                                            <div class="col-md-1 p-1"> {{ $created_at->format('d.m.Y')  }} </div>
                                            <div class="col-md-1 p-1"> Автор подтверждения </div>
                                            @php
                                                $confirmed = $oi->status_id == 4 ? (new Date($oi->updated_at)) : '' ;
                                            @endphp
                                            <div class="col-md-1 p-1"> {{ $confirmed != '' ? ($confirmed->format('d.m.Y')) : 'не подтвержден' }} </div>
                                            <div class="col-md-1 p-1"> {{ $oi->relMotionPosition->count() }} </div>
                                            @php
                                                $price_cost = 0;
                                                // dd($oi);
                                                foreach($oi->relMotionPosition as $mp){
                                                    $price_cost += $mp->relPosition ? $mp->relPosition->price_cost : 0;
                                                }
                                            @endphp
                                            <div class="col-md-1 p-1"> {{ $price_cost }} </div>
                                        </div>

                                        @foreach ($oi->relMotionPosition as $mp)
                                            <div class="row text-center" style="background-color: #ededed">
                                                <div class="col-md-1 p-1">  </div>
                                                <div class="col-md-1 p-1"> {{ $mp->relPosition ? ($ar_cat[$mp->relPosition->relProduct->cat_id]) : '' }}  </div>
                                                <div class="col-md-1 p-1"> {{ $mp->relPosition ? $mp->relPosition->relProduct->name : '' }} </div>
                                                <div class="col-md-2 p-1"> {{ $mp->relPosition ? $mp->relPosition->relProduct->sys_num : '' }} </div>
                                                <div class="col-md-3 p-1"> {{ $mp->relPosition ? ('№' . $mp->relPosition->income_id) : '' }} </div>
                                                @php
                                                    $created_income = $mp->relPosition ? (new Date($mp->relPosition->relIncome->created_at)) : '';
                                                @endphp
                                                <div class="col-md-1 p-1"> {{ $created_income != '' ? $created_income->format('d.m.Y') : '' }} </div>
                                                <div class="col-md-1 p-1"> {{ $mp->relPosition ? $mp->relPosition->price_cost : '' }} </div>
                                                <div class="col-md-2 p-1"> {{ $mp->relPosition ? $mp->relPosition->relStatus->name : '' }}	 </div>
                                            </div>
                                        @endforeach

                                    @endif

                                @endforeach

                                @php
                                    $empty_manager = false;

                                    foreach($motion_items as $oi){
                                        if ($oi->from_branch_id == $id) {
                                            $empty_manager = true;
                                        }
                                    }
                                @endphp

                                @if ($empty_manager == false)
                                    <div class="row text-center p-3" style="font-size: 12px;">
                                        <div class="col-md-12 text-secondary">
                                            Из данного филиала нет перемещении на период {{ $request->created_at_first ? ($request->created_at_first . ' - ' . $request->created_at_second) : '' }}
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
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
