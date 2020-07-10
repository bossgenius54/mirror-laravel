<table>
    @php
        $title_style = "text-align: center; background: #0B5394; color: #ffffff;font-size:12px;font-family:'Calibri';";
        $simple_text_style = "text-align: center; background: #ffffff; color: #000000;font-size:10px;border:1px solid #c5c5c5;font-family:'Calibri'";
        $total_style = "background: #ffc107; color:#ffffff;font-family:'Calibri'";
        $date_format = "d.m.Y";
    @endphp

    <tr><td colspan="12"></td></tr>
    <tr>
        <td colspan="12" style=" {{ $title_style }} ">
            {{ $title }}
        </td>
    </tr>

    {{-- Header information about report --}}
    <tr>
        <td style=" {{ $title_style }} ">Период:</td>
        @php
            $created_at_first = $request->created_at_first ? (new Date($request->created_at_first)) : '';
            $created_at_second = $request->created_at_second ? (new Date($request->created_at_second)) : '';
        @endphp
        <td colspan="9">{{ $request->created_at_first ? ($created_at_first->format($date_format) . ' - ' . $created_at_second->format($date_format)) : '' }}</td>
    </tr>
    <tr>
        <td style=" {{ $title_style }} ">Филиал:</td>
        <td colspan="11">
            @foreach($ar_branch as $id => $name)
                        @if($request->branch_id && $request->branch_id == $id)
                            {{ $name }}
                        @elseif(!$request->branch_id)
                            @if ($loop->last)
                                {{ $name }}
                                @continue
                            @endif
                            {{ $name }},
                        @endif
            @endforeach
        </td>

    </tr>
    <tr>
        <td style=" {{ $title_style }} ">Создатель:</td>
        <td colspan="11">
            {{ $user->name . ' (' . $user_roles[$user->type_id] . ')' }}
        </td>
    </tr>
    {{-- end Header about report --}}

    {{-- Table Order Positions--}}
    @if($request->filtered && $request->filtered == 'true' )

        <tr>
            <td colspan="12" style=" {{ $title_style }} ">
                {{ $title }}
            </td>
        </tr>

        <tr>
            <td colspan="6" style=" {{ $title_style }} " > Филиал </td>
            <td colspan="6" style=" {{ $title_style }} " > Продавец данного филиала (роль) </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " > # </td>
            <td colspan="3" style=" {{ $title_style }} " > Категория товара </td>
            <td style=" {{ $title_style }} " > Наименование </td>
            <td style=" {{ $title_style }} " > Системный номер </td>
            <td style=" {{ $title_style }} " > Кол-во товаров </td>
            <td style=" {{ $title_style }} " > Общая себестоимость </td>
            <td style=" {{ $title_style }} " >  </td>
            <td style=" {{ $title_style }} " >  </td>
            <td style=" {{ $title_style }} " > Общая сумма продажи </td>
            <td style=" {{ $title_style }} " > Сумма прибыли </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " width="20"> # </td>
            <td style=" {{ $title_style }} " width="20"> № оприходования </td>
            <td style=" {{ $title_style }} " width="20"> № заказа </td>
            <td style=" {{ $title_style }} " width="20"> Дата продажи </td>
            <td style=" {{ $title_style }} " width="20"> Наименование </td>
            <td style=" {{ $title_style }} " width="25"> Системный номер </td>
            <td style=" {{ $title_style }} " width="20"> Кол-во товаров </td>
            <td style=" {{ $title_style }} " width="20"> Cебестоимость </td>
            <td style=" {{ $title_style }} " width="20"> Вид продажи </td>
            <td style=" {{ $title_style }} " width="20"> Стоимость </td>
            <td style=" {{ $title_style }} " width="20"> Сумма продажи </td>
            <td style=" {{ $title_style }} " width="20"> Сумма прибыли </td>
        </tr>

        {{-- @php
            $p_total_count = 0;
            $p_total_price_cost = 0;
            $p_total_sum = 0;
        @endphp --}}

        @foreach ($managers as $manager)

            <tr>
                <td colspan="12" > </td>
            </tr>
            <tr>
                <td colspan="6" style=" {{ $simple_text_style }} " > <b>{{ $manager->branch_id ? $ar_branch[$manager->branch_id] : $manager->relCompany->name }}</b> </td>
                <td colspan="6" style=" {{ $simple_text_style }} " > <b>{{$manager->name}} ({{ $manager->getClearTypeName() }})</b> </td>
            </tr>

            @php
                $p_total_count = 0;
                $p_total_price_cost = 0;
                $p_total_sum = 0;
                $p_total_profit = 0;
            @endphp

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

                <tr>
                    <td style=" {{ $simple_text_style }} " >  <b># {{$loop->index + 1}}</b>  </td>
                    <td colspan="3" style=" {{ $simple_text_style }} " > <b>{{ $pi->relCategory->name }}</b> </td>
                    <td style=" {{ $simple_text_style }} " > <b>{{ $pi->name }}</b> </td>
                    <td style=" {{ $simple_text_style }} " > <b>{{ $pi->sys_num }}</b> </td>

                    <td style=" {{ $simple_text_style }} " >
                        @php
                            $pi_pos_count = 0;
                            foreach ($pi->relOrderPosition as $pi_opos) {
                                if($pi_opos->relOrder->created_user_id == $manager->id)
                                    $pi_pos_count += $pi_opos->pos_count;
                            }
                            $p_total_count += $pi_pos_count;
                        @endphp
                        <b>{{ $pi_pos_count }}</b>
                    </td>
                    <td style=" {{ $simple_text_style }} " >
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
                        <b>{{ $pi_price_cost }}</b>
                    </td>
                    <td style=" {{ $simple_text_style }} " >  </td>
                    <td style=" {{ $simple_text_style }} " >  </td>
                    <td style=" {{ $simple_text_style }} " >
                        @php
                            $pi_profit = 0;
                            foreach ($pi->relOrderPosition as $pi_opos) {
                                if($pi_opos->relOrder->created_user_id == $manager->id)
                                    $pi_profit += $pi_opos->total_sum;
                            }
                            $p_total_sum += $pi_profit;
                        @endphp
                        <b>{{ $pi_profit }}</b>
                    </td>
                    @php
                        $p_total_profit += $pi_profit - $pi_price_cost;
                    @endphp
                    <td style=" {{ $simple_text_style }} " > <b>{{ $p_total_profit }}</b> </td>
                </tr>

                @foreach ($pi->relOrderPosition as $rop)
                    @if ($rop->relOrder->created_user_id == $manager->id)

                        <tr>
                            <td style=" {{ $simple_text_style }} " > </td>
                            <td style=" {{ $simple_text_style }} " > Оприходования #{{$rop->relOrder->relPositions->first()->income_id}} </td>
                            <td style=" {{ $simple_text_style }} " > Заказ #{{$rop->order_id}}  </td>
                            @php
                                $date = new Date($rop->created_at);
                            @endphp
                            <td style=" {{ $simple_text_style }} " > {{ $date->format('d.m.Y') }} </td>
                            <td style=" {{ $simple_text_style }} " >  {{ $pi->name }}  </td>
                            <td style=" {{ $simple_text_style }} " > {{ $pi->sys_num }} </td>
                            <td style=" {{ $simple_text_style }} " > {{ $rop->pos_count }} </td>
                            <td style=" {{ $simple_text_style }} " > {{$rop->relOrder->relPositions->first()->price_cost}} </td>
                            <td style=" {{ $simple_text_style }} " > {{$rop->relOrder->is_retail ? 'Розница' : 'Оптом'}} </td>
                            <td style=" {{ $simple_text_style }} " >  {{ $rop->pos_cost }}  </td>
                            <td style=" {{ $simple_text_style }} " > {{ $rop->total_sum }} </td>
                            <td style=" {{ $simple_text_style }} " >  {{ $rop->total_sum - ($rop->relOrder->relPositions->first()->price_cost * $rop->pos_count) }}  </td>
                        </tr>
                    @endif
                @endforeach

                @endif

            @endforeach


            @if ($p_total_count != 0 )
                <tr>
                    <td colspan="5"></td>
                    <td style=" {{ $total_style }} "> Итог: </td>
                    <td style=" {{ $total_style }} "> {{ $p_total_count }} шт </td>
                    <td style=" {{ $total_style }} "> {{ $p_total_price_cost}} тг </td>


                    <td style=" {{ $total_style }} ">  </td>
                    <td style=" {{ $total_style }} ">  </td>

                    <td style=" {{ $total_style }} "> {{ $p_total_sum }} тг. </td>
                    <td style=" {{ $total_style }} "> {{ $p_total_profit }} тг. </td>
                </tr>
            @else
                <tr>
                    <td colspan="12" style=" {{ $simple_text_style }} " > У данного менеджера в промежутке {{ $request->created_at_first ? ($created_at_first->format($date_format) . ' - ' . $created_at_second->format($date_format)) : '' }} нет оформленных заказов </td>
                </tr>
            @endif

        @endforeach


    @endif
    {{-- End Order Positions Table --}}

    <tr><td colspan="12"></td></tr>

    {{-- Summary --}}
    <tr><td colspan="12"></td></tr>

    {{-- <tr>
        <td colspan="8"></td>
        <td style="color: #0B5394; font-size: 12px;"> <b>Итог:</b> </td>
        <td style="color: #0B5394; font-size: 10px;"> Сумма продаж </td>
    </tr>

    <tr>
        <td colspan="8"></td>
        <td style="color: #0B5394; font-size: 10px;"> По позициям: </td>
        <td style="color: #0B5394; font-size: 10px;"> {{ $p_total_sum }} тг. </td>
    </tr>

    <tr>
        <td colspan="8"></td>
        <td style="color: #0B5394; font-size: 10px;"> По услугам: </td>
        <td style="color: #0B5394; font-size: 10px;"> {{ $s_total_sum }} тг. </td>
    </tr>

    <tr>
        <td colspan="8"></td>
        <td style="color: #0B5394; font-size: 12px;"> <b>Общая сумма:</b> </td>
        <td style="color: #0B5394; font-size: 10px;"> <b>{{ $p_total_sum + $s_total_sum }} тг.</b> </td>
    </tr> --}}
    {{-- End Summary --}}

</table>
