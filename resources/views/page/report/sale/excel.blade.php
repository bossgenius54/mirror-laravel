<table>

    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr>
        <td colspan="12" style="text-align: center; background: #1976d2; color: #ffffff; font-size:16px;">
            <b>{{ $title }}</b>
        </td>
    </tr>

    {{-- Header information about report --}}
    <tr>
        <td style=" background: #1976d2; color: #ffffff;"><b>Период:</b></td>
        <td>{{ $request->created_at_first ? ($request->created_at_first . ' - ' . $request->created_at_second) : '' }}</td>
    </tr>
    <tr>
        <td style=" background: #1976d2; color: #ffffff;"><b>Филиал:</b></td>
        @foreach($ar_branch as $id => $name)
            <td colspan="2">
                    @if($request->branch_id && $request->branch_id == $id)
                        <span style="background: #1976d2; color: #ffffff;"> {{ $name }} </span>
                    @elseif(!$request->branch_id)
                        <span style="background: #1976d2; color: #ffffff;"> {{ $name }} </span>
                    @endif
            </td>
        @endforeach

    </tr>
    <tr>
        <td style=" background: #1976d2; color: #ffffff;"><b>Создатель:</b></td>
        <td colspan="5">
            {{ $user->name . ' (' . $user_roles[$user->type_id] . ')' }}
        </td>

    </tr>
    {{-- end Header about report --}}

    {{-- Table Order Positions--}}
    @if($request->filtered && $request->filtered == 'true' )

        <tr>
            <td colspan="12" style="text-align: center; background: #1976d2; color: #ffffff;font-size:16px;">
                <b>По позициям</b>
            </td>
        </tr>

        <tr>
            <td style="text-align: center; background: #1976d2; color: #ffffff;"> <b>#</b> </td>
            <td style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Филиал</b> </td>
            <td colspan="2" style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Категория</b> </td>
            <td colspan="2" style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Ассортимент</b> </td>
            <td colspan="2" style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Системный номер</b> </td>
            <td style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Дата продажи</b> </td>
            <td style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Тип продаж</b> </td>
            <td style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Кол-во товара</b> </td>
            <td style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Сумма продаж</b> </td>
        </tr>
        @php
            $p_total_count = 0;
            $p_total_sum = 0;
        @endphp

        @foreach ($p_items as $pi)
            <tr><td></td></tr>

            <tr>
                <td style="text-align: center; background: #ffffff; color: #000;"> <b># {{$loop->index + 1}} </b></td>
                <td style="text-align: center; background: #ffffff; color: #000;">  </td>
                <td colspan="2" style="text-align: center; background: #ffffff; color: #000;"> <b>{{ $pi->relCategory->name }} </b></td>
                <td colspan="2" style="text-align: center; background: #ffffff; color: #000;"> <b>{{ $pi->name }} </b></td>
                <td colspan="2" style="text-align: center; background: #ffffff; color: #000;"> <b>{{ $pi->sys_num }}</b> </td>
                <td style="text-align: center; background: #ffffff; color: #000;"> <b>-</b> </td>
                <td style="text-align: center; background: #ffffff; color: #000;"> <b>-</b> </td>
                <td style="text-align: center; background: #ffffff; color: #000;">
                    @php
                        $pi_pos_count = 0;
                        foreach ($pi->relOrderPosition as $pi_opos) {
                            $pi_pos_count += $pi_opos->pos_count;
                        }
                        $p_total_count += $pi_pos_count;
                    @endphp
                    <b>{{ $pi_pos_count }}</b>
                </td>
                <td style="text-align: center; background: #ffffff; color: #000;">
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
                    <td style="text-align: center; background: #ffffff; color: #000;"> </td>
                    <td style="text-align: center; background: #ffffff; color: #000;"> {{ $ar_branch[$pi_opos->relOrder->branch_id] }} </td>

                    <td colspan="2" style="text-align: center; background: #ffffff; color: #000;"> </td>
                    <td colspan="2" style="text-align: center; background: #ffffff; color: #000;"> {{ $pi->name }} </td>
                    <td colspan="2" style="text-align: center; background: #ffffff; color: #000;"> {{ $pi->sys_num }} </td>
                    @php
                        $date = new Date($pi_opos->created_at);
                    @endphp
                    <td style="text-align: center; background: #ffffff; color: #000;"> {{ $date->format('d/m/Y') }} </td>
                    <td style="text-align: center; background: #ffffff; color: #000;"> {{ $pi_opos->relOrder->is_retail ? 'Розница' : 'Оптом' }} </td>
                    <td style="text-align: center; background: #ffffff; color: #000;"> {{ $pi_opos->pos_count }} </td>
                    <td style="text-align: center; background: #ffffff; color: #000;"> {{ $pi_opos->total_sum }} </td>
                </tr>
            @endforeach

        @endforeach
        <tr>
            <td colspan="9"></td>
            <td style="background: #ffc107; color:#ffffff;"> <b>Итог:</b> </td>
            <td style="background: #ffc107; color:#ffffff;"> {{ $p_total_count}} шт </td>
            <td style="background: #ffc107; color:#ffffff;"> {{ $p_total_sum }} тг. </td>
        </tr>

    @endif
    {{-- End Order Positions Table --}}

    <tr><td></td></tr>

    {{-- Table Order Service--}}
    @if($request->filtered && $request->filtered == 'true' )
        <tr>
            <td colspan="12" style="text-align: center; background: #1976d2; color: #ffffff;font-size:16px;">
                <b>По услугам</b>
            </td>
        </tr>

        <tr>
            <td style="text-align: center; background: #1976d2; color: #ffffff;"><b>#</b> </td>
            <td colspan="2" style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Филиал</b> </td>
            <td colspan="3" style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Услуга</b> </td>
            <td colspan="2" style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Стоимость услуги</b> </td>
            <td style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Дата продажи</b> </td>
            <td style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Тип продаж</b> </td>
            <td style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Кол-во</b> </td>
            <td style="text-align: center; background: #1976d2; color: #ffffff;"> <b>Сумма продаж</b> </td>
        </tr>
        @php
            $s_total_count = 0;
            $s_total_sum = 0;
        @endphp

        @foreach ($s_items as $si)
            <tr><td></td></tr>

            <tr style="text-align: center; background: #ffffff; color: #000000;">
                <td style="text-align: center; background: #ffffff; color: #000000;"> <b># {{$loop->index + 1}}</b> </td>
                <td colspan="2" style="text-align: center; background: #ffffff; color: #000000;">  </td>
                <td colspan="3" style="text-align: center; background: #ffffff; color: #000000;"> <b>{{ $si->name }}</b> </td>
                <td colspan="2" style="text-align: center; background: #ffffff; color: #000000;"> <b>{{ $si->price }}</b> </td>
                <td style="text-align: center; background: #ffffff; color: #000000;"> <b>-</b> </td>
                <td style="text-align: center; background: #ffffff; color: #000000;"> <b>-</b> </td>
                <td style="text-align: center; background: #ffffff; color: #000000;">
                    @php
                        $si_service_count = 0;
                        foreach ($si->relOrderService as $si_opos) {
                            $si_service_count += $si_opos->service_count;
                        }
                        $s_total_count += $si_service_count;
                    @endphp
                    <b>{{ $si_service_count }}</b>
                </td>
                <td style="text-align: center; background: #ffffff; color: #000000;">
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
                <tr style="text-align: center; background: #ffffff; color: #000;">
                    <td> </td>
                    <td colspan="2"> {{ $ar_branch[$pi_opos->relOrder->branch_id] }} </td>
                    <td colspan="3"> {{ $si->name }} </td>
                    <td colspan="2"> - </td>
                    @php
                        $date = new Date($pi_opos->created_at);
                    @endphp
                    <td> {{ $date->format('d/m/Y') }} </td>
                    <td> {{ $pi_opos->relOrder->is_retail ? 'Розница' : 'Оптом' }} </td>
                    <td> {{ $pi_opos->service_count }} </td>
                    <td> {{ $pi_opos->total_sum }} </td>

                </tr>
            @endforeach

        @endforeach
        <tr style="text-align: center;">
            <td colspan="9"></td>
            <td style="background: #ffc107; color:#ffffff;"><b> Итог: </b></td>
            <td style="background: #ffc107; color:#ffffff;"> {{ $s_total_count}} шт </td>
            <td style="background: #ffc107; color:#ffffff;"> {{ $s_total_sum }} тг. </td>
        </tr>

    @endif
    {{-- End Order Service Table --}}

    {{-- Summary --}}

    <tr><td></td></tr>

    <tr>
        <td colspan="8"></td>
        <td style="color: #1976d2; font-size: 14px;"> <b>Итог:</b> </td>
        <td style="color: #1976d2; font-size: 12px;"> Сумма продаж </td>
    </tr>

    <tr>
        <td colspan="8"></td>
        <td style="color: #1976d2; font-size: 12px;"> По позициям: </td>
        <td style="color: #1976d2;"> {{ $p_total_sum }} тг. </td>
    </tr>

    <tr>
        <td colspan="8"></td>
        <td style="color: #1976d2; font-size: 12px;"> По услугам: </td>
        <td style="color: #1976d2;"> {{ $s_total_sum }} тг. </td>
    </tr>

    <tr>
        <td colspan="8"></td>
        <td style="color: #1976d2; font-size: 14px;"> <b>Общая сумма:</b> </td>
        <td style="color: #1976d2;"> {{ $p_total_sum + $s_total_sum }} тг. </td>
    </tr>
    {{-- End Summary --}}

</table>
