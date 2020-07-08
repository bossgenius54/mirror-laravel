<table>
    @php
        $title_style = "text-align: center; background: #0B5394; color: #ffffff;font-size:12px;font-family:'Calibri';";
        $simple_text_style = "text-align: center; background: #ffffff; color: #000000;font-size:10px;border:1px solid #c5c5c5;font-family:'Calibri'";
        $total_style = "background: #ffc107; color:#ffffff;font-family:'Calibri'";
        $date_format = "d.m.Y";
    @endphp

    <tr><td></td></tr>
    <tr><td></td></tr>
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
                По позициям
            </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " width="20"> # </td>
            <td style=" {{ $title_style }} " width="20"> Филиал </td>
            <td colspan="2" style=" {{ $title_style }} " width="20"> Категория </td>
            <td colspan="2" style=" {{ $title_style }} " width="20"> Ассортимент </td>
            <td colspan="2" style=" {{ $title_style }} " width="20"> Системный номер </td>
            <td style=" {{ $title_style }} " width="20"> Дата продажи </td>
            <td style=" {{ $title_style }} " width="20"> Тип продаж </td>
            <td style=" {{ $title_style }} " width="20"> Кол-во товара </td>
            <td style=" {{ $title_style }} " width="20"> Сумма продаж </td>
        </tr>
        @php
            $p_total_count = 0;
            $p_total_sum = 0;
        @endphp

        @foreach ($p_items as $pi)
            <tr><td colspan="12"></td></tr>

            <tr>
                <td style=" {{ $simple_text_style }} "> <b># {{$loop->index + 1}}</b> </td>
                <td style=" {{ $simple_text_style }} ">  </td>
                <td colspan="2" style=" {{ $simple_text_style }} "> <b>{{ $pi->relCategory->name }}</b> </td>
                <td colspan="2" style=" {{ $simple_text_style }} "> <b>{{ $pi->name }}</b> </td>
                <td colspan="2" style=" {{ $simple_text_style }} "> <b>{{ $pi->sys_num }}</b> </td>
                <td style=" {{ $simple_text_style }} "> <b>-</b> </td>
                <td style=" {{ $simple_text_style }} "> <b>-</b> </td>
                <td style=" {{ $simple_text_style }} ">
                    @php
                        $pi_pos_count = 0;
                        foreach ($pi->relOrderPosition as $pi_opos) {
                            $pi_pos_count += $pi_opos->pos_count;
                        }
                        $p_total_count += $pi_pos_count;
                    @endphp
                    <b>{{ $pi_pos_count }}</b>
                </td>
                <td style=" {{ $simple_text_style }} ">
                    @php
                        $total_pi_sum = 0;
                        foreach ($pi->relOrderPosition as $pi_opos) {
                            $total_pi_sum += $pi_opos->total_sum;
                        }
                        $p_total_sum += $total_pi_sum;
                    @endphp
                    <b>{{ $total_pi_sum }}</b>
                </td>

            </tr>

            @foreach ($pi->relOrderPosition as $pi_opos)
                <tr>
                    <td style=" {{ $simple_text_style }} "> </td>
                    <td style=" {{ $simple_text_style }} "> {{ $ar_branch[$pi_opos->relOrder->branch_id] }} </td>

                    <td colspan="2" style=" {{ $simple_text_style }} "> </td>
                    <td colspan="2" style=" {{ $simple_text_style }} "> {{ $pi->name }} </td>
                    <td colspan="2" style=" {{ $simple_text_style }} "> {{ $pi->sys_num }} </td>
                    @php
                        $date = new Date($pi_opos->created_at);
                    @endphp
                    <td style=" {{ $simple_text_style }} "> {{ $date->format($date_format) }} </td>
                    <td style=" {{ $simple_text_style }} "> {{ $pi_opos->relOrder->is_retail ? 'Розница' : 'Оптом' }} </td>
                    <td style=" {{ $simple_text_style }} "> {{ $pi_opos->pos_count }} </td>
                    <td style=" {{ $simple_text_style }} "> {{ $pi_opos->total_sum }} </td>
                </tr>
            @endforeach

        @endforeach
        <tr>
            <td colspan="9"></td>
            <td style=" {{ $total_style }} "> Итог: </td>
            <td style=" {{ $total_style }} "> {{ $p_total_count}} шт </td>
            <td style=" {{ $total_style }} "> {{ $p_total_sum }} тг. </td>
        </tr>

    @endif
    {{-- End Order Positions Table --}}

    <tr><td colspan="12"></td></tr>

    {{-- Table Order Service--}}
    @if($request->filtered && $request->filtered == 'true' )
        <tr>
            <td colspan="12" style=" {{ $title_style }} ">
                По услугам
            </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} "># </td>
            <td colspan="2" style=" {{ $title_style }} "> Филиал </td>
            <td colspan="3" style=" {{ $title_style }} "> Услуга </td>
            <td colspan="2" style=" {{ $title_style }} "> Стоимость услуги </td>
            <td style=" {{ $title_style }} "> Дата продажи </td>
            <td style=" {{ $title_style }} "> Тип продаж </td>
            <td style=" {{ $title_style }} "> Кол-во </td>
            <td style=" {{ $title_style }} "> Сумма продаж </td>
        </tr>
        @php
            $s_total_count = 0;
            $s_total_sum = 0;
        @endphp

        @foreach ($s_items as $si)
            <tr><td colspan="12"></td></tr>

            <tr style=" {{ $simple_text_style }} ">
                <td style=" {{ $simple_text_style }} "> <b># {{$loop->index + 1}}</b> </td>
                <td colspan="2" style=" {{ $simple_text_style }} ">  </td>
                <td colspan="3" style=" {{ $simple_text_style }} "> <b>{{ $si->name }}</b> </td>
                <td colspan="2" style=" {{ $simple_text_style }} "> <b>{{ $si->price }}</b> </td>
                <td style=" {{ $simple_text_style }} "> <b>-</b> </td>
                <td style=" {{ $simple_text_style }} "> <b>-</b> </td>
                <td style=" {{ $simple_text_style }} ">
                    @php
                        $si_service_count = 0;
                        foreach ($si->relOrderService as $si_opos) {
                            $si_service_count += $si_opos->service_count;
                        }
                        $s_total_count += $si_service_count;
                    @endphp
                    <b>{{ $si_service_count }}</b>
                </td>
                <td style=" {{ $simple_text_style }} ">
                    @php
                        $total_si_sum = 0;
                        foreach ($si->relOrderService as $si_opos) {
                            $total_si_sum += $si_opos->total_sum;
                        }
                        $s_total_sum += $total_si_sum;
                    @endphp
                    <b>{{ $total_si_sum }}</b>
                </td>

            </tr>

            @foreach ($si->relOrderService as $pi_opos)
                <tr style=" {{ $simple_text_style }} ">
                    <td> </td>
                    <td colspan="2" style=" {{ $simple_text_style }} "> {{ $ar_branch[$pi_opos->relOrder->branch_id] }} </td>
                    <td colspan="3" style=" {{ $simple_text_style }} "> {{ $si->name }} </td>
                    <td colspan="2" style=" {{ $simple_text_style }} "> - </td>
                    @php
                        $date = new Date($pi_opos->created_at);
                    @endphp
                    <td style=" {{ $simple_text_style }} "> {{ $date->format($date_format) }} </td>
                    <td style=" {{ $simple_text_style }} "> {{ $pi_opos->relOrder->is_retail ? 'Розница' : 'Оптом' }} </td>
                    <td style=" {{ $simple_text_style }} "> {{ $pi_opos->service_count }} </td>
                    <td style=" {{ $simple_text_style }} "> {{ $pi_opos->total_sum }} </td>

                </tr>
            @endforeach

        @endforeach
        <tr style="text-align: center;">
            <td colspan="9"></td>
            <td style=" {{ $total_style }} "> Итог: </td>
            <td style=" {{ $total_style }} "> {{ $s_total_count}} шт </td>
            <td style=" {{ $total_style }} "> {{ $s_total_sum }} тг. </td>
        </tr>

    @endif
    {{-- End Order Service Table --}}

    {{-- Summary --}}

    <tr><td colspan="12"></td></tr>

    <tr>
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
    </tr>
    {{-- End Summary --}}

</table>
