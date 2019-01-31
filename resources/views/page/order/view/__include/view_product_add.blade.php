@can('position', $item)
    @if ($user->type_id == App\Model\SysUserType::FIZ)
        <form class="form-material row" action="{{ action('Order\PositionOrderController@postAddProduct', $item) }}" method="post"  enctype="multipart/form-data" style="margin-top: 15px;">
            <div class="form-group col-md-4">
                <label>Продукция</label>
                <select name="product_id" class="form-control js_cant_max" id="product_id" required>
                    <option value=""></option>
                    @foreach ($products as $product)
                        @php 
                            $position_count = $product->relPositions()->where('branch_id', $item->branch_id)->where('status_id', App\Model\SysPositionStatus::ACTIVE)->count();
                        @endphp
                        
                        <option     value="{{ $product->id }}"  
                                    data-count="{{ $position_count }}" 
                                    data-price="{{ $item->is_retail ? $product->price_retail : $product->price_opt }}">
                            {{ $product->name }} ({{ $product->sys_num }}). Есть {{ $position_count }} позиций. 
                            Цена {{ $item->is_retail ? $product->price_retail : $product->price_opt }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label>Кол-во</label>
                <input type="number" class="form-control " name="pos_count" id="pos_count" value="1" max="5" required  > 
            </div>
            <div class="form-group col-md-2">
                <label>Цена за единицу</label>
                <input type="number" class="form-control" name="pos_cost" id="pos_cost"  readonly > 
            </div>
            <div class="form-group col-md-2">
                <label>Общая сумма</label>
                <input type="number" class="form-control" id="pos_total_sum" readonly > 
            </div>
            <div class="form-group col-md-2">
                <label>&nbsp;</label>  
                <button class="btn btn-info btn-block" type="submit">Добавить</button>
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
                        @php 
                            $position_count = $product->relPositions()->where('branch_id', $item->branch_id)->where('status_id', App\Model\SysPositionStatus::ACTIVE)->count();
                        @endphp
                        
                        <option     value="{{ $product->id }}"  
                                    data-count="{{ $position_count }}" 
                                    data-price="{{ $item->is_retail ? $product->price_retail : $product->price_opt }}">
                            {{ $product->name }} ({{ $product->sys_num }}). Есть {{ $position_count }} позиций. 
                            Цена {{ $item->is_retail ? $product->price_retail : $product->price_opt }}
                        </option>
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
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    @endif
@endcan