<table>
    @php
        $title_style = "text-align: center; background: #0B5394; color: #ffffff;font-size:12px;font-family:'Calibri';";
        $simple_text_style = "text-align: center; background: #ffffff; color: #000000;font-size:10px;border:1px solid #c5c5c5;font-family:'Calibri'";
        $total_style = "background: #ffc107; color:#ffffff;font-family:'Calibri'";
        $date_format = "d.m.Y";
    @endphp

    <tr><td colspan="10"></td></tr>
    <tr>
        <td colspan="10" style=" {{ $title_style }} ">
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
        <td colspan="9">
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
        <td colspan="9">
            {{ $user->name . ' (' . $user_roles[$user->type_id] . ')' }}
        </td>
    </tr>
    {{-- end Header about report --}}

    {{-- Table Order Positions--}}
    @if($request->filtered && $request->filtered == 'true' )

        <tr>
            <td colspan="10" style=" {{ $title_style }} ">
                {{ $title }}
            </td>
        </tr>

        <tr>
            <td colspan="5" style=" {{ $title_style }} " > Филиал </td>
            <td colspan="5" style=" {{ $title_style }} " > Продавец данного филиала (роль) </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " > # </td>
            <td colspan="2" style=" {{ $title_style }} " > Клиент </td>
            <td style=" {{ $title_style }} " > Создатель {Роль + ФИО} </td>
            <td style=" {{ $title_style }} " > № Заказа </td>
            <td style=" {{ $title_style }} " > От </td>
            <td style=" {{ $title_style }} "  > Дата продажи </td>
            <td style=" {{ $title_style }} " width="20" > Дата возврата </td>
            <td style=" {{ $title_style }} " width="20" > Общая сумма </td>
            <td style=" {{ $title_style }} " > Автор возврата </td>һ
        </tr>

        <tr>
            <td style=" {{ $title_style }} " width="20">  </td>
            <td style=" {{ $title_style }} " width="20"> Категория </td>
            <td style=" {{ $title_style }} " width="20"> Наименование </td>
            <td style=" {{ $title_style }} " width="25"> Системный номер </td>
            <td style=" {{ $title_style }} " width="20"> Кол-во </td>
            <td style=" {{ $title_style }} " width="20"> Цена розницы </td>
            <td style=" {{ $title_style }} " width="20"> Оптовая цена </td>
            <td colspan="2" style=" {{ $title_style }} " > Тип продажи </td>
            <td style=" {{ $title_style }} " width="20"> Фактическая цена продажи </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " >  </td>
            <td colspan="3" style=" {{ $title_style }} " > Услуга </td>
            <td style=" {{ $title_style }} " > Кол-во </td>
            <td colspan="2" style=" {{ $title_style }} " > Цена </td>
            <td colspan="2" style=" {{ $title_style }} " >  </td>
            <td style=" {{ $title_style }} " > Фактическая цена	 </td>
        </tr>

        @php
            $p_total_count = 0;
            $s_total_count = 0;
            $p_total_sum = 0;
        @endphp

        @foreach ($managers as $manager)

            <tr>
                <td colspan="6" style=" {{ $simple_text_style }} " > {{ $manager->branch_id ? $ar_branch[$manager->branch_id] : $manager->relCompany->name }} </td>
                <td colspan="4" style=" {{ $simple_text_style }} " > {{$manager->name}} ({{ $manager->getClearTypeName() }}) </td>
            </tr>

            @foreach ($income_items as $ii)

                @if ($ii->user_id == $manager->id)

                    @php
                        $p_total_count += $ii->relIncomePositions->count();
                        $s_total_count += $ii->relIncomeService->count();
                        $p_total_sum += $ii->related_cost;
                    @endphp

                    <tr>
                        <td style=" {{ $simple_text_style }} " >  #{{$loop->index + 1 }}  </td>
                        <td colspan="2" style=" {{ $simple_text_style }} " > {{ $ii->relFromUser ? $ii->relFromUser->name : $ii->relFromCompany->name }} </td>
                        <td style=" {{ $simple_text_style }} " > {{ $ii->relCreatedUser->name . ' (' . $ii->relCreatedUser->getClearTypeName() . ')' }} </td>
                        <td style=" {{ $simple_text_style }} " > № {{ $ii->order_id }} </td>
                        <td style=" {{ $simple_text_style }} " > {{ $order_types[$ii->relOrder->type_id] }}  </td>
                        @php
                            $order_data = new Date($ii->relOrder->updated_at);
                        @endphp
                        <td style=" {{ $simple_text_style }} "  > {{ $order_data->format('d.m.Y') }}  </td>
                        @php
                            $returned_data = new Date($ii->created_at);
                        @endphp
                        <td style=" {{ $simple_text_style }} " width="20" > {{ $returned_data->format('d.m.Y') }} </td>
                        <td style=" {{ $simple_text_style }} " width="20" > {{ $ii->related_cost }} </td>
                        <td style=" {{ $simple_text_style }} " > {{ $ii->relCreatedUser->name . ' (' . $ii->relCreatedUser->getClearTypeName() . ')' }} </td>һ
                    </tr>


                    @foreach ($ii->relIncomePositions as $ip)
                        <tr>
                            <td style=" {{ $simple_text_style }} " >  </td>
                            <td style=" {{ $simple_text_style }} " > {{ $ar_cat[$ip->relPosition->relProduct->cat_id] }} </td>
                            <td style=" {{ $simple_text_style }} " > {{ $ip->relPosition->relProduct->name }} </td>
                            <td style=" {{ $simple_text_style }} " > {{ $ip->relPosition->relProduct->sys_num }} </td>
                            <td style=" {{ $simple_text_style }} " > 1 </td>
                            <td style=" {{ $simple_text_style }} " > {{ $ip->relPosition->relProduct->price_retail }}  </td>
                            <td style=" {{ $simple_text_style }} " > {{ $ip->relPosition->relProduct->price_opt }} </td>
                            <td colspan="2" style=" {{ $simple_text_style }} " >  {{ $ii->relOrder->is_retail ? 'Розница' : 'Оптом' }}  </td>
                            <td style=" {{ $simple_text_style }} " >  </td>
                        </tr>
                    @endforeach

                    @foreach ($ii->relIncomeService as $is)
                        <tr>
                            <td style=" {{ $simple_text_style }} " >  </td>
                            <td colspan="3" style=" {{ $simple_text_style }} " > {{ $is->relService->name }} </td>
                            <td style=" {{ $simple_text_style }} " > {{ $is->service_count }} </td>
                            <td colspan="2" style=" {{ $simple_text_style }} " > {{ $is->relService->price }} </td>
                            <td colspan="2" style=" {{ $simple_text_style }} " > {{ $ii->relOrder->is_retail ? 'Розница' : 'Оптом' }} </td>
                            <td style=" {{ $simple_text_style }} " > {{ $is->total_sum }}	 </td>
                        </tr>
                    @endforeach

                @endif

            @endforeach

            @php
                $empty_manager = false;

                foreach($income_items as $inc){
                    if ($inc->relCreatedUser->id == $manager->id) {
                        $empty_manager = true;
                    }
                }
            @endphp

            @if ($empty_manager == false)
                <tr>
                    <td colspan="10" style=" {{ $simple_text_style }} " > У данного менеджера в промежутке {{ $request->created_at_first ? ($created_at_first->format($date_format) . ' - ' . $created_at_second->format($date_format)) : '' }} нет возвратов </td>
                </tr>
            @endif

        @endforeach


    @endif
    {{-- End Order Positions Table --}}

    <tr><td colspan="12"></td></tr>

    {{-- Summary --}}
    <tr><td colspan="12"></td></tr>

    <tr>
        <td colspan="7"></td>
        <td style="color: #0B5394; font-size: 12px;"> <b>Общее кол-во возвратов позиции</b> </td>
        <td style="color: #0B5394; font-size: 12px;"> <b>Общее кол-во возвратов услуг</b> </td>
        <td style="color: #0B5394; font-size: 12px;"> Общая сумма возврата </td>
    </tr>

    <tr>
        <td colspan="6"></td>
        <td style="color: #0B5394; font-size: 12px;"> Итого: </td>
        <td style="color: #0B5394; font-size: 10px;"> {{ $p_total_count }} </td>
        <td style="color: #0B5394; font-size: 10px;"> {{ $s_total_count }} </td>
        <td style="color: #0B5394; font-size: 10px;"> {{ $p_total_sum }} тг. </td>
    </tr>
    {{-- End Summary --}}

</table>
