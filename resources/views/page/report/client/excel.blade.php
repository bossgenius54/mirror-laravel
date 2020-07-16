<table>
    @php
        $title_style = "text-align: center; background: #0B5394; color: #ffffff;font-size:12px;font-family:'Calibri';";
        $simple_text_style = "text-align: center; background: #ffffff; color: #000000;font-size:10px;border:1px solid #c5c5c5;font-family:'Calibri'";
        $total_style = "background: #ffc107; color:#ffffff;font-family:'Calibri'";
        $date_format = "d.m.Y";
    @endphp

    <tr><td colspan="5"></td></tr>
    <tr>
        <td colspan="5" style=" {{ $title_style }} ">
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
        <td colspan="4">{{ $request->created_at_first ? ($created_at_first->format($date_format) . ' - ' . $created_at_second->format($date_format)) : '' }}</td>
    </tr>
    <tr>
        <td style=" {{ $title_style }} ">Филиал:</td>
        <td colspan="4">
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
        <td colspan="4">
            {{ $user->name . ' (' . $user_roles[$user->type_id] . ')' }}
        </td>
    </tr>
    {{-- end Header about report --}}

    {{-- Table  --}}
    @if($request->filtered && $request->filtered == 'true' )

        <tr>
            <td colspan="5" style=" {{ $title_style }} ">
                {{ $title }}
            </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " > # </td>
            <td colspan="2" style=" {{ $title_style }} " > Клиент </td>
            <td style=" {{ $title_style }} " > Кол-во заказов </td>
            <td style=" {{ $title_style }} " > Общая сумма </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " width="20">  </td>
            <td style=" {{ $title_style }} " width="20"> Филиал </td>
            <td style=" {{ $title_style }} " width="20"> Дата </td>
            <td style=" {{ $title_style }} " width="20"> № заказа </td>
            <td style=" {{ $title_style }} " width="20"> Сумма </td>
        </tr>


        @foreach ($clients as $c)
            <tr><td colspan="7"></td></tr>

            <tr>
                <td style=" {{ $simple_text_style }} " > <b>{{ $loop->index + 1 }}</b> </td>
                <td colspan="2" style=" {{ $simple_text_style }} " > <b>{{ $c->name }}</b> </td>
                <td style=" {{ $simple_text_style }} " > <b>{{ $c->relOrder->count() }}</b> </td>
                @php
                    $total_sum = 0;
                    foreach ($c->relOrder as $order) {
                        $total_sum += $order->total_sum;
                    }
                @endphp
                <td style=" {{ $simple_text_style }} " > <b>{{ $total_sum }}</b> </td>
            </tr>

            @foreach ($c->relOrder as $order)
                <tr>
                    <td style=" {{ $simple_text_style }} " >  </td>
                    <td style=" {{ $simple_text_style }} " > {{ $order->relBranch->name}} </td>
                    @php
                        $date = new Date($order->created_at);
                    @endphp
                    <td style=" {{ $simple_text_style }} " > {{ $date->format('d.m.Y') }}  </td>
                    <td style=" {{ $simple_text_style }} " > Заказ №{{ $order->id}}  </td>
                    <td style=" {{ $simple_text_style }} " > {{ $order->total_sum }} </td>
                </tr>
            @endforeach

        @endforeach
    @endif
    {{-- End  Table --}}

</table>
