<table>
    @php
        $title_style = "text-align: center; background: #0B5394; color: #ffffff;font-size:12px;font-family:'Calibri';";
        $simple_text_style = "text-align: center; background: #ffffff; color: #000000;font-size:10px;border:1px solid #c5c5c5;font-family:'Calibri'";
        $total_style = "background: #ffc107; color:#ffffff;font-family:'Calibri'";
        $date_format = "d.m.Y";
    @endphp

    <tr><td colspan="9"></td></tr>
    <tr>
        <td colspan="9" style=" {{ $title_style }} ">
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
        <td colspan="8">{{ $request->created_at_first ? ($created_at_first->format($date_format) . ' - ' . $created_at_second->format($date_format)) : '' }}</td>
    </tr>
    <tr>
        <td style=" {{ $title_style }} ">Филиал:</td>
        <td colspan="8">
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
        <td colspan="8">
            {{ $user->name . ' (' . $user_roles[$user->type_id] . ')' }}
        </td>
    </tr>
    {{-- end Header about report --}}

    {{-- Table  --}}
    @if($request->filtered && $request->filtered == 'true' )

        <tr>
            <td colspan="9" style=" {{ $title_style }} ">
                {{ $title }}
            </td>
        </tr>

        <tr>
            <td colspan="5" style=" {{ $title_style }} " > Филиал </td>
            <td colspan="4" style=" {{ $title_style }} " > Автор </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " > # </td>
            <td style=" {{ $title_style }} " width="20"> № Оприходования </td>
            <td style=" {{ $title_style }} " width="20"> Дата </td>
            <td style=" {{ $title_style }} " width="20"> Заметка </td>
            <td style=" {{ $title_style }} " width="20"> Статус </td>
            <td style=" {{ $title_style }} " width="20"> Поставщик </td>
            <td style=" {{ $title_style }} " width="20"> Кол-во товаров </td>
            <td style=" {{ $title_style }} " width="20"> Общая сумма </td>
            <td style=" {{ $title_style }} " width="20"> Расчет с поставщиком </td>
        </tr>

        <tr>
            <td style=" {{ $title_style }} " >  </td>
            <td style=" {{ $title_style }} " > Категория </td>
            <td style=" {{ $title_style }} " > Наименование </td>
            <td colspan="2" style=" {{ $title_style }} " > Системный номер </td>
            <td style=" {{ $title_style }} " > Себестоимость </td>
            <td style=" {{ $title_style }} " > Шт </td>
            <td style=" {{ $title_style }} " > Себестоимость </td>
            <td style=" {{ $title_style }} " >  </td>
        </tr>


        @foreach ($managers as $manager)

            <tr><td colspan="7"></td></tr>

            <tr>
                <td colspan="5" style=" {{ $simple_text_style }} " > {{ $manager->branch_id ? $ar_branch[$manager->branch_id] : $manager->relCompany->name }} </td>
                <td colspan="4" style=" {{ $simple_text_style }} " > {{$manager->name}} ({{ $manager->getClearTypeName() }}) </td>
            </tr>

            @foreach ($income_items as $ii)

                @if ($ii->relCreatedUser->id == $manager->id )

                    <tr>
                        <td style=" {{ $simple_text_style }} " > {{ $loop->index + 1 }} </td>
                        <td style=" {{ $simple_text_style }} " width="20"> №{{ $ii->id}} </td>
                        @php
                            $created_at = new Date($ii->created_at);
                        @endphp
                        <td style=" {{ $simple_text_style }} " width="20"> {{ $created_at->format('d.m.Y') }}  </td>
                        <td style=" {{ $simple_text_style }} " width="20"> {{ $ii->note }} </td>
                        <td style=" {{ $simple_text_style }} " width="20"> {{ isset($ar_status[$ii->relPositions->first()->status_id]) ? $ar_status[$ii->relPositions->first()->status_id] : 'не указано' }} </td>
                        <td style=" {{ $simple_text_style }} " width="20"> {{ $ii->relFromCompany->name }} </td>
                        <td style=" {{ $simple_text_style }} " width="20"> {{ $ii->relIncomePositions->count() }} </td>
                        @php
                            $total_price_cost = 0;
                            foreach ($ii->relIncomePositions as $ip) {
                                $total_price_cost += $ip->relPosition->price_cost;
                            }
                        @endphp
                        <td style=" {{ $simple_text_style }} " width="20"> {{ $total_price_cost }} </td>
                        <td style=" {{ $simple_text_style }} " width="20"> - </td>
                    </tr>

                    @foreach ($ii->relIncomePositions as $ip)
                        <div class="row text-center ">
                            <div class="col-md-1 p-1 ">  </div>
                            <div class="col-md-2 p-1 "> {{ $ip->relPosition ? $ar_cat[$ip->relPosition->relProduct->cat_id] : 'не указано' }}  </div>
                            <div class="col-md-1 p-1 "> {{ $ip->relPosition ? $ip->relPosition->relProduct->name : 'не указано' }} </div>
                            <div class="col-md-2 p-1 ">  {{ $ip->relPosition ? $ip->relPosition->relProduct->sys_num : 'не указано' }}  </div>
                            <div class="col-md-2 p-1 "> {{ $ip->relPosition ? $ip->relPosition->price_cost : 'не указано' }}   </div>
                            <div class="col-md-1 p-1 "> 1 </div>
                            <div class="col-md-2 p-1 "> {{ $ip->relPosition ? $ip->relPosition->price_cost : 'не указано' }} </div>
                            <div class="col-md-1 p-1 ">  </div>
                        </div>
                        <tr>
                            <td style=" {{ $simple_text_style }} " >  </td>
                            <td style=" {{ $simple_text_style }} " > {{ $ip->relPosition ? $ar_cat[$ip->relPosition->relProduct->cat_id] : 'не указано' }} </td>
                            <td style=" {{ $simple_text_style }} " > {{ $ip->relPosition ? $ip->relPosition->relProduct->name : 'не указано' }}  </td>
                            <td colspan="2" style=" {{ $simple_text_style }} " > {{ $ip->relPosition ? $ip->relPosition->relProduct->sys_num : 'не указано' }} </td>
                            <td style=" {{ $simple_text_style }} " > {{ $ip->relPosition ? $ip->relPosition->price_cost : 'не указано' }} </td>
                            <td style=" {{ $simple_text_style }} " > 1 Шт </td>
                            <td style=" {{ $simple_text_style }} " > {{ $ip->relPosition ? $ip->relPosition->price_cost : 'не указано' }} </td>
                            <td style=" {{ $simple_text_style }} " >  </td>
                        </tr>
                    @endforeach

                @endif

            @endforeach


        @endforeach

    @endif
    {{-- End  Table --}}
</table>
