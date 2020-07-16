
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

                    <form action="{{ action('Report\StaffReportController@getExcel') }}" method="GET">
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
                            Филиал
                        </div>
                    </div>

                    <div class="row bg-info text-white text-center font-weight-bold">
                        <div class="col-md-1 p-1"> # </div>
                        <div class="col-md-4 p-1"> Роль </div>
                        <div class="col-md-4 p-1"> ФИО </div>
                        <div class="col-md-2 p-1"> Общая сумма </div>
                        <div class="col-md-1 p-1"> Кол-во продаж </div>
                    </div>

                    <div class="row text-center font-weight-bold">
                        <div class="col-md-1 p-1 border border-info"> # </div>
                        <div class="col-md-2 p-1 border border-info"> № заказа </div>
                        <div class="col-md-2 p-1 border border-info"> Дата создания </div>
                        <div class="col-md-2 p-1 border border-info"> Статус </div>
                        <div class="col-md-2 p-1 border border-info"> Дата изменения </div>
                        <div class="col-md-2 p-1 border border-info"> Сумма </div>
                        <div class="col-md-1 p-1 border border-info">  </div>
                    </div>

                    @php
                        $p_total_sum = 0;
                        $p_total_count = 0;
                    @endphp

                    @foreach ($ar_branch as $id => $branch)

                        <br/>
                        <br/>

                        <div class="row text-center p-3" style="font-size: 12px;">
                            <div class="col-md-12 text-primary">
                                <b>{{ $branch }}</b>
                            </div>
                        </div>

                        @foreach ($managers as $manager)

                            @php
                                $empty_manager = false;

                                foreach($order_items as $inc){
                                    if ($inc->relCreatedUser->id == $manager->id && $inc->branch_id == $id) {
                                        $empty_manager = true;
                                    }
                                }
                            @endphp

                            @if ( $empty_manager )

                                <div class="row  text-center font-weight-bold">
                                    <div class="col-md-1 p-1"> <b>#{{ $loop->index + 1 }}</b> </div>
                                    <div class="col-md-4 p-1"> <b>{{ $manager->getClearTypeName() }}</b> </div>
                                    <div class="col-md-4 p-1"> <b>{{ $manager->name}} </b> </div>
                                    @php
                                        $count = 0;
                                        $total_sum = 0;
                                        foreach ($order_items as $oi) {
                                            if ($oi->relCreatedUser->id == $manager->id) {
                                                $count += 1;
                                                $total_sum += $oi->total_sum;
                                            }
                                        }
                                        $p_total_sum += $total_sum;
                                        $p_total_count += $count;
                                    @endphp
                                    <div class="col-md-2 p-1"> <b>{{ $total_sum }}</b> </div>
                                    <div class="col-md-1 p-1"> <b>{{ $count }}</b> </div>
                                </div>
                                <hr/>

                                @foreach ($order_items as $oi)
                                    @if ($manager->id == $oi->relCreatedUser->id && $oi->branch_id == $id )
                                        <div class="row text-center font-weight-bold">
                                            <div class="col-md-1 p-1 ">  </div>
                                            <div class="col-md-2 p-1 "> Заказ #{{ $oi->id }} </div>
                                            @php
                                                $created_at = new Date($oi->created_at);
                                                $updated_at = new Date($oi->updated_at);
                                            @endphp
                                            <div class="col-md-2 p-1 "> {{ $created_at->format('d.m.Y') }} </div>
                                            <div class="col-md-2 p-1 "> {{ $oi->relStatus->name }} </div>
                                            <div class="col-md-2 p-1 "> {{ $updated_at->format('d.m.Y') }} </div>
                                            <div class="col-md-2 p-1 "> {{ $oi->total_sum }} </div>
                                            <div class="col-md-1 p-1 ">  </div>
                                        </div>
                                    @endif

                                @endforeach

                                <hr/>
                            @endif

                        @endforeach

                    @endforeach


                    <div class="row text-white text-center" style="border-bottom: 5px solid #1976d2;">
                        <div class="col-md-7 p-1"> </div>

                        <div class="col-md-2 p-1"> Итого </div>
                        <div class="col-md-2 p-1"> {{ $p_total_sum }} </div>
                        <div class="col-md-1 p-1"> {{ $p_total_count }} </div>
                    </div>

                </div>
                @endif
                {{-- End Order Positions Table --}}


            </div>

        </div>
    </div>
</div>
@endsection
