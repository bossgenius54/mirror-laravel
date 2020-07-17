@can('position', $item)
    @if ($user->type_id == App\Model\SysUserType::FIZ)
        <form class="form-material row" action="{{ action('Order\PositionOrderController@postAddProduct', $item) }}" method="post"  enctype="multipart/form-data" style="margin-top: 15px;">
            <div class="form-group col-md-4">
                <label>Продукция</label>
                <select name="product_id" class="form-control js_cant_max" id="product_id" required>
                    <option value=""></option>
                    @foreach ($products as $product)
                        @if (in_array($product->id, $ar_order_product))
                            @continue
                        @endif
                        @php
                            $position_count = $product->relPositions()->where('branch_id', $item->branch_id)->where('status_id', App\Model\SysPositionStatus::ACTIVE)->count();
                        @endphp

                        <option     value="{{ $product->id }}"
                                    data-count="{{ $position_count }}"
                                    data-price="{{ $item->is_retail ? $product->price_retail : $product->price_opt }}">
                            {{ $product->artikul }}|{{ $product->name }} ({{ $product->sys_num }}).
                            Цена {{ $item->is_retail ? $product->price_retail : $product->price_opt }}`
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label>Кол-во</label>
                <input type="number" class="form-control " name="pos_count" id="pos_count" value="1" max="5" required  >
            </div>
            <div class="form-check form-check-inline col-md-2">
                <input class="form-check-input filter-checkbox" type="checkbox" name="filter" id="filter" >
                <label class="form-check-label" for="filter">Фильтровать</label>
            </div>
            <div class="form-group col-md-3">
                <label>&nbsp;</label>
                <button class="btn btn-info btn-block" type="submit">Показать список</button>
            </div>
            <div class="col-md-12">



            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    @elseif ($user->type_id == App\Model\SysUserType::COMPANY_CLIENT)
        <form class="form-material row" action="{{ action('Order\PositionOrderController@postAddProduct', $item) }}" method="post"  enctype="multipart/form-data" style="margin-top: 15px;">
            <div class="form-group col-md-4">
                <label>Продукция</label>
                <select name="product_id" class="form-control {{ $item->is_retail ? 'js_cant_max' : '' }}" id="product_id" required>
                    <option value=""></option>
                    @foreach ($products as $product)
                        @if (in_array($product->id, $ar_order_product))
                            @continue
                        @endif
                        @php
                            $position_count = $product->relPositions()->where('branch_id', $item->branch_id)->where('status_id', App\Model\SysPositionStatus::ACTIVE)->count();
                        @endphp

                        <option     value="{{ $product->id }}"
                                    data-count="{{ $position_count }}"
                                    data-price="{{ $item->is_retail ? $product->price_retail : $product->price_opt }}">
                            {{ $product->artikul }}|{{ $product->name }} ({{ $product->sys_num }}).
                            Цена {{ $item->is_retail ? $product->price_retail : $product->price_opt }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label>Кол-во</label>
                <input type="number" class="form-control " name="pos_count" id="pos_count" value="1" max="5" required  >
            </div>
            <div class="form-check form-check-inline col-md-2">
                <input class="form-check-input filter-checkbox" type="checkbox" name="filter" id="filter" >
                <label class="form-check-label" for="filter">Фильтровать</label>
            </div>
            <div class="form-group col-md-3">
                <label>&nbsp;</label>
                <button class="btn btn-info btn-block" type="submit">Показать список</button>
            </div>
            <div class="col-md-12">



            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    @else
        <form class="form-material row" action="{{ action('Order\PositionOrderController@postAddProduct', $item) }}" method="post"  enctype="multipart/form-data" style="margin-top: 15px;">
            <div class="form-group col-md-4">
                <label>Продукция</label>
                <select name="product_id" class="form-control" id="product_id" required>
                    <option value=""></option>
                    @foreach ($products as $product)
                        @if (in_array($product->id, $ar_order_product))
                            @continue
                        @endif

                        @php
                            $position_count = $product->relPositions()->where('branch_id', $item->branch_id)->where('status_id', App\Model\SysPositionStatus::ACTIVE)->count();
                        @endphp


                        @if( $position_count > 0 )
                        <option     value="{{ $product->id }}"
                                    data-count="{{ $position_count }}"
                                    data-price="{{ $item->is_retail ? $product->price_retail : $product->price_opt }}">
                            {{ $product->artikul }}|{{ $product->name }} ({{ $product->sys_num }}). Есть {{ $position_count }} позиций.
                            Цена {{ $item->is_retail ? $product->price_retail : $product->price_opt }}
                        </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label>Кол-во</label>
                <input type="number" class="form-control " name="pos_count" id="pos_count" value="1" required  >
            </div>
            <div class="form-group col-md-2">
                <label>Цена за единицу</label>
                <input type="number" class="form-control" name="pos_cost" id="pos_cost"  required >
            </div>
            <div class="form-group col-md-2">
                <label>Общая сумма</label>
                <input type="number" class="form-control" id="pos_total_sum" readonly >
            </div>
            <div class="form-group col-md-2">
                <label>&nbsp;</label>
                <button class="btn btn-info btn-block" type="submit">Добавить</button>
            </div>

            <div class="form-group col-md-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input filter-checkbox" type="checkbox" name="filter" id="filter" >
                    <label class="form-check-label" for="filter">Фильтровать</label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="collapse" id="filterBlock">
                    <div class="card card-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="first_date">Срок годности</label>
                                <input type="date" class="form-control " id="expired_first" placeholder="Дата" name="expired_first" value="{{ $request->first_date }}" >
                                <a class="" data-toggle="collapse" href="#collapseSecondDate" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    Вторая дата
                                </a>
                            </div>

                            <div class="form-group col-md-3 collapse" id="collapseSecondDate">
                                <label for="second_date">Дата до</label>
                                <input type="date" class="form-control " id="second_date" placeholder="Дата" name="second_date" value="{{ $request->second_date }}" >
                            </div>

                            <div class="form-group col-md-3">
                                <label>&nbsp;</label>
                                <a href="#" class="btn btn-info btn-block filter-action">Показать список</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    @endif
@endcan
