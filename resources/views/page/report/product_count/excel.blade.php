<table>
    @php
        $title_style = "text-align: center; background: #0B5394; color: #ffffff;font-size:12px;font-family:'Calibri';";
        $simple_text_style = "text-align: center; background: #ffffff; color: #000000;font-size:10px;border:1px solid #c5c5c5;font-family:'Calibri'";
        $total_style = "background: #ffc107; color:#ffffff;font-family:'Calibri'";
        $date_format = "d.m.Y";
    @endphp

    <tr><td colspan="8"></td></tr>
    <tr>
        <td colspan="8" style=" {{ $title_style }} ">
            {{ $title }}
        </td>
    </tr>

    {{-- Header information about report --}}
    <tr>
        <td style=" {{ $title_style }} ">Филиал:</td>
        <td colspan="7">
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
        <td colspan="7">
            {{ $user->name . ' (' . $user->getClearTypeName() . ')' }}
        </td>
    </tr>
    {{-- end Header about report --}}

    {{-- Table Order --}}
    {{-- @if($request->filtered && $request->filtered == 'true' )

        <tr>
            <td colspan="7" style=" {{ $title_style }} ">
                {{ $title }}
            </td>
        </tr>

        <tr>
            <td colspan="4" style=" {{ $title_style }} " > Филиал </td>
            <td colspan="3" style=" {{ $title_style }} " > Продавец данного филиала (роль) </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " width="20"> # </td>
            <td style=" {{ $title_style }} " width="20"> № Заказа </td>
            <td style=" {{ $title_style }} " width="20"> Дата </td>
            <td style=" {{ $title_style }} " width="20"> Клиент </td>
            <td style=" {{ $title_style }} " width="20"> Статус </td>
            <td style=" {{ $title_style }} " width="20"> Вид </td>
            <td style=" {{ $title_style }} " width="20" > Сумма </td>
        </tr>

        @php
            $p_total_sum = 0;
        @endphp

        @foreach ($managers as $manager)

        <tr><td colspan="7"></td></tr>

            <tr>
                <td colspan="4" style=" {{ $simple_text_style }} " > <b>{{ $manager->branch_id ? $ar_branch[$manager->branch_id] : $manager->relCompany->name }}</b> </td>
                <td colspan="3" style=" {{ $simple_text_style }} " > <b>{{$manager->name}} ({{ $manager->getClearTypeName() }})</b> </td>
            </tr>

            @foreach ($order_items as $oi)

                            @if ($oi->relCreatedUser->id == $manager->id)

                                @php
                                    $p_total_sum += $oi->status_id == $status_end ? $oi->total_sum : $oi->prepay_sum;
                                @endphp

                                <tr>
                                    <td style=" {{ $simple_text_style }} " >  #{{$loop->index + 1 }}  </td>
                                    <td style=" {{ $simple_text_style }} " >  Заказ №{{ $oi->id }}  </td>
                                    @php
                                        $order_date = new Date($oi->updated_at);
                                    @endphp
                                    <td style=" {{ $simple_text_style }} " >  {{ $order_date->format('d.m.Y') }} </td>
                                    <td style=" {{ $simple_text_style }} " >  {{ $oi->type_id == 1 ? $oi->relPersonCLient->name : ($oi->relCompanyCLient ? $oi->relCompanyCLient->name : '') }}  </td>
                                    <td style=" {{ $simple_text_style }} " >  {{ $oi->relStatus->name }}  </td>
                                    <td style=" {{ $simple_text_style }} " >  {{ $oi->status_id == $status_end ? 'Оплата заказа' : 'Предоплата' }}  </td>
                                    <td style=" {{ $simple_text_style }} " >  {{ $oi->status_id == $status_end ? $oi->total_sum : ($oi->prepay_sum != '' ? $oi->prepay_sum : '-') }}  </td>
                                </tr>

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
                <tr>
                    <td colspan="7" style=" {{ $simple_text_style }} " > У данного менеджера в промежутке {{ $request->created_at_first ? ($created_at_first->format($date_format) . ' - ' . $created_at_second->format($date_format)) : '' }} нет заказов </td>
                </tr>
            @endif

        @endforeach
        <tr>
            <td colspan="5" >  </td>
            <td style=" {{ $total_style }} " > Итог  </td>
            <td style=" {{ $total_style }} " >  {{ $p_total_sum }}  </td>
        </tr>


    @endif --}}
    {{-- End Order Positions Table --}}

    <tr>
        <td style="{{ $title_style }}" width="20">#</td>
        <td style="{{ $title_style }}" width="20">Категория</td>
        <td style="{{ $title_style }}" width="20">Наименование</td>
        <td style="{{ $title_style }}" width="20">Системный номер</td>

        <td style="{{ $title_style }}" width="20">Филиал</td>
        <td style="{{ $title_style }}" width="20">Кол-во на складе </td>
        <td style="{{ $title_style }}" width="20">Нужно на складе </td>
        <td style="{{ $title_style }}" width="20">Нужно докупить </td>
    </tr>

    @foreach ($items as $i)
        <tr>
            <td style="{{ $simple_text_style }}"> #{{ $loop->index + 1 }}</td>
            <td style="{{ $simple_text_style }}">{{ $i->relCategory->name }}</td>
            <td style="{{ $simple_text_style }}">{{ $i->name }} </td>
            <td style="{{ $simple_text_style }}">{{ $i->sys_num }}</td>

            <td style="{{ $simple_text_style }}"></td>
            <td style="{{ $simple_text_style }}"> </td>
            <td style="{{ $simple_text_style }}"> </td>
            <td style="{{ $simple_text_style }}"> </td>
        </tr>

        @php
            $has_el = false;
        @endphp

            @foreach ($ar_branch as $id=>$name)

                @if ($request->branch_name && $request->branch_name != $name)
                    @continue
                @endif

                @php
                    $count_pos = $i->relPositions->where('branch_id', $id)->where('status_id', App\Model\SysPositionStatus::ACTIVE)->count();
                    $balans = $count_pos - $i->min_stock_count;
                @endphp

                @if ($request->hidden_null && $count_pos == 0)
                    @continue
                @endif

                @if ($request->balans_diff == 'plus' && $balans < 0)
                    @continue
                @elseif ($request->balans_diff == 'minus' && $balans >= 0)
                    @continue
                @endif

                <tr>
                    <td colspan="4" style="{{ $simple_text_style }}"></td>

                    <td style="{{ $simple_text_style }}"> {{ $name }} </td>
                    <td style="{{ $simple_text_style }}"> {{ $count_pos }} </td>
                    <td style="{{ $simple_text_style }}"> {{ $i->min_stock_count }} </td>
                    <td style="{{ $simple_text_style }}"> {{ $balans >= 0 ? 'не нужно' :  -$balans }} </td>
                </tr>

                @php
                    $has_el = true;
                @endphp

            @endforeach

        @if (!$has_el)
            <tr>
                <td colspan="8" style="{{ $simple_text_style }}">
                    Нет элементов по выбранному запросу
                </td>
            </tr>
        @endif
    @endforeach

</table>
