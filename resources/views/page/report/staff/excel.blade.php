<table>
    @php
        $title_style = "text-align: center; background: #0B5394; color: #ffffff;font-size:12px;font-family:'Calibri';";
        $simple_text_style = "text-align: center; background: #ffffff; color: #000000;font-size:10px;border:1px solid #c5c5c5;font-family:'Calibri'";
        $total_style = "background: #ffc107; color:#ffffff;font-family:'Calibri'";
        $date_format = "d.m.Y";
    @endphp

    <tr><td colspan="7"></td></tr>
    <tr>
        <td colspan="7" style=" {{ $title_style }} ">
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
        <td colspan="6">{{ $request->created_at_first ? ($created_at_first->format($date_format) . ' - ' . $created_at_second->format($date_format)) : '' }}</td>
    </tr>
    <tr>
        <td style=" {{ $title_style }} ">Филиал:</td>
        <td colspan="6">
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
        <td colspan="6">
            {{ $user->name . ' (' . $user_roles[$user->type_id] . ')' }}
        </td>
    </tr>
    {{-- end Header about report --}}

    {{-- Table  --}}
    @if($request->filtered && $request->filtered == 'true' )

        <tr>
            <td colspan="7" style=" {{ $title_style }} ">
                {{ $title }}
            </td>
        </tr>

        <tr>
            <td colspan="7" style=" {{ $title_style }} " > Филиал </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " > # </td>
            <td colspan="2" style=" {{ $title_style }} " > Роль </td>
            <td colspan="2" style=" {{ $title_style }} " > ФИО </td>
            <td style=" {{ $title_style }} " > Общая сумма </td>
            <td style=" {{ $title_style }} " > Кол-во продаж </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " width="20">  </td>
            <td style=" {{ $title_style }} " width="20"> № заказа </td>
            <td style=" {{ $title_style }} " width="20"> Дата создания </td>
            <td style=" {{ $title_style }} " width="20"> Статус </td>
            <td style=" {{ $title_style }} " width="20"> Дата изменения </td>
            <td style=" {{ $title_style }} " width="20"> Сумма </td>
            <td style=" {{ $title_style }} " width="20">  </td>
        </tr>

        @php
            $p_total_sum = 0;
            $p_total_count = 0;
        @endphp

        @foreach ($ar_branch as $id => $branch)

            <tr><td colspan="7"></td></tr>

            <tr>
                <td colspan="7" style=" {{ $simple_text_style }} " > <b>{{ $branch }}</b> </td>
            </tr>

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

                    <tr>
                        <td style=" {{ $simple_text_style }} " > <b>#{{ $loop->index + 1 }}</b> </td>
                        <td colspan="2" style=" {{ $simple_text_style }} " > <b>{{ $manager->getClearTypeName() }}</b> </td>
                        <td colspan="2" style=" {{ $simple_text_style }} " > <b>{{ $manager->name}} </b> </td>
                        <td style=" {{ $simple_text_style }} " >  <b>{{ $total_sum }}</b>  </td>
                        <td style=" {{ $simple_text_style }} " > <b>{{ $count }}</b>  </td>
                    </tr>

                    @foreach ($order_items as $oi)
                        @if ($manager->id == $oi->relCreatedUser->id && $oi->branch_id == $id )

                            @php
                                $created_at = new Date($oi->created_at);
                                $updated_at = new Date($oi->updated_at);
                            @endphp
                            <tr>
                                <td style=" {{ $simple_text_style }} " >  </td>
                                <td style=" {{ $simple_text_style }} " > Заказ #{{ $oi->id }}  </td>
                                <td style=" {{ $simple_text_style }} " > {{ $created_at->format('d.m.Y') }}  </td>
                                <td style=" {{ $simple_text_style }} " > {{ $oi->relStatus->name }} </td>
                                <td style=" {{ $simple_text_style }} " > {{ $updated_at->format('d.m.Y') }}  </td>
                                <td style=" {{ $simple_text_style }} " > {{ $oi->total_sum }} </td>
                                <td style=" {{ $simple_text_style }} " >  </td>
                            </tr>
                        @endif

                    @endforeach

                @endif

            @endforeach

        @endforeach

        <tr>
            <td colspan="4" >  </td>
            <td style=" {{ $total_style }} " > Итог  </td>
            <td style=" {{ $total_style }} " >  {{ $p_total_sum }}  </td>
            <td style=" {{ $total_style }} " >  {{ $p_total_count }}  </td>
        </tr>

    @endif
    {{-- End  Table --}}

</table>
