<table>
    @php
        $title_style = "text-align: center; background: #0B5394; color: #ffffff;font-size:12px;font-family:'Calibri';";
        $simple_text_style = "text-align: center; background: #ffffff; color: #000000;font-size:10px;border:1px solid #c5c5c5;font-family:'Calibri'";
        $total_style = "background: #ffc107; color:#ffffff;font-family:'Calibri'";
        $date_format = "d.m.Y";
    @endphp

    <tr><td colspan="11"></td></tr>
    <tr>
        <td colspan="11" style=" {{ $title_style }} ">
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
        <td colspan="10">{{ $request->created_at_first ? ($created_at_first->format($date_format) . ' - ' . $created_at_second->format($date_format)) : '' }}</td>
    </tr>
    <tr>
        <td style=" {{ $title_style }} ">Филиал:</td>
        <td colspan="10">
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
        <td colspan="10">
            {{ $user->name . ' (' . $user_roles[$user->type_id] . ')' }}
        </td>
    </tr>
    {{-- end Header about report --}}

    {{-- Table Order --}}
    @if($request->filtered && $request->filtered == 'true' )

        <tr>
            <td colspan="11" style=" {{ $title_style }} ">
                {{ $title }}
            </td>
        </tr>

        <tr>
            <td colspan="11" style=" {{ $title_style }} " > Из филиала </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " width="20"> # </td>
            <td style=" {{ $title_style }} " width="20"> № перемещения </td>
            <td style=" {{ $title_style }} " width="20"> Наименование </td>
            <td style=" {{ $title_style }} " width="20"> Статус </td>
            <td style=" {{ $title_style }} " width="20"> В филиал </td>
            <td style=" {{ $title_style }} " width="25"> Создатель {Роль + ФИО} </td>
            <td style=" {{ $title_style }} " width="20"> Дата создания </td>
            <td style=" {{ $title_style }} " width="20"> Автор подтверждения </td>
            <td style=" {{ $title_style }} " width="20"> Дата подтверждения </td>
            <td style=" {{ $title_style }} " width="20"> Общее кол-во </td>
            <td style=" {{ $title_style }} " width="20"> Сумма себестоимости </td>
        </tr>
        <tr>
            <td style=" {{ $title_style }} " >  </td>
            <td style=" {{ $title_style }} " > Категория  </td>
            <td style=" {{ $title_style }} " > Наименование </td>
            <td colspan="2" style=" {{ $title_style }} " > Системный номер	 </td>
            <td colspan="2" style=" {{ $title_style }} " > № оприходования	 </td>
            <td style=" {{ $title_style }} " > Дата оприходования </td>
            <td style=" {{ $title_style }} " > Себестоимость </td>
            <td colspan="2" style=" {{ $title_style }} " > Статус товара после перемещения	 </td>
        </tr>

        @php
            $p_total_count = 0;
            $p_total_price_cost = 0;
        @endphp


        @foreach ($ar_branch as $id => $branch)

            <tr><td colspan="11"></td></tr>

            <tr>
                <td colspan="11" style=" {{ $simple_text_style }} " > <b>{{ $branch }}</b> </td>
            </tr>

            @foreach ($motion_items as $oi)

                @if ($oi->from_branch_id == $id)
                    @php
                        $p_total_count += $oi->relMotionPosition->count();
                    @endphp

                    <tr><td colspan="11"></td></tr>
                    <tr>
                        <td style=" {{ $simple_text_style }} " > <b>{{ $loop->index + 1 }}</b> </td>
                        <td style=" {{ $simple_text_style }} " > <b>№{{ $oi->id }}</b> </td>
                        <td style=" {{ $simple_text_style }} " > <b>{{ $oi->name }}</b> </td>
                        <td style=" {{ $simple_text_style }} " > <b>{{ $oi->relStatus->name }}</b> </td>
                        <td style=" {{ $simple_text_style }} " > <b>{{ $oi->relToBranch->name }}</b> </td>
                        <td style=" {{ $simple_text_style }} " > <b>{{ $oi->relCreatedUser->name . ' (' . $oi->relCreatedUser->getClearTypeName() . ')'}}</b> </td>
                        @php
                            $created_at = new Date($oi->created_at);
                        @endphp
                        <td style=" {{ $simple_text_style }} " > <b>{{ $created_at->format('d.m.Y')  }}</b> </td>
                        <td style=" {{ $simple_text_style }} " > <b>-</b> </td>
                        @php
                            $confirmed = $oi->status_id == 4 ? (new Date($oi->updated_at)) : '' ;
                        @endphp
                        <td style=" {{ $simple_text_style }} " > <b>{{ $confirmed != '' ? ($confirmed->format('d.m.Y')) : 'не подтвержден' }}</b> </td>
                        <td style=" {{ $simple_text_style }} " > <b>{{ $oi->relMotionPosition->count() }}</b> </td>
                        @php
                            $price_cost = 0;
                            // dd($oi);
                            foreach($oi->relMotionPosition as $mp){
                                $price_cost += $mp->relPosition ? $mp->relPosition->price_cost : 0;
                            }
                            $p_total_price_cost += $price_cost;
                        @endphp
                        <td style=" {{ $simple_text_style }} " > <b>{{ $price_cost }}</b> </td>
                    </tr>

                    @foreach ($oi->relMotionPosition as $mp)
                        <tr>
                            <td style=" {{ $simple_text_style }} " >  </td>
                            <td style=" {{ $simple_text_style }} " > {{ $mp->relPosition ? ($ar_cat[$mp->relPosition->relProduct->cat_id]) : '' }}  </td>
                            <td style=" {{ $simple_text_style }} " > {{ $mp->relPosition ? $mp->relPosition->relProduct->name : '' }} </td>
                            <td colspan="2" style=" {{ $simple_text_style }} " > {{ $mp->relPosition ? $mp->relPosition->relProduct->sys_num : '' }} </td>
                            <td colspan="2" style=" {{ $simple_text_style }} " > {{ $mp->relPosition ? ('№' . $mp->relPosition->income_id) : '' }} </td>
                            @php
                                $created_income = $mp->relPosition ? (new Date($mp->relPosition->relIncome->created_at)) : '';
                            @endphp
                            <td style=" {{ $simple_text_style }} " > {{ $created_income != '' ? $created_income->format('d.m.Y') : '' }} </td>
                            <td style=" {{ $simple_text_style }} " > {{ $mp->relPosition ? $mp->relPosition->price_cost : '' }} </td>
                            <td colspan="2" style=" {{ $simple_text_style }} " > {{ $mp->relPosition ? $mp->relPosition->relStatus->name : '' }} </td>
                        </tr>
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
                <tr>
                    <td colspan="11" style=" {{ $simple_text_style }} " >
                        Из данного филиала нет перемещении на период {{ $request->created_at_first ? ($request->created_at_first . ' - ' . $request->created_at_second) : '' }}
                    </td>
                </tr>
            @endif

        @endforeach

        <tr>
            <td colspan="8" ></td>
            <td style=" {{ $total_style }} " > Итог  </td>
            <td style=" {{ $total_style }} " >  {{ $p_total_count }}  </td>
            <td style=" {{ $total_style }} " >  {{ $p_total_price_cost }}  </td>
        </tr>


    @endif
    {{-- End Order Positions Table --}}

</table>
