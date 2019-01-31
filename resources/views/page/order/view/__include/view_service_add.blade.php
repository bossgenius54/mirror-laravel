@can('service', $item)
    @if ($user->type_id == App\Model\SysUserType::FIZ)
        <form class="form-material row" action="{{ action('Order\ServiceOrderController@postAddService', $item) }}" method="post" style="margin-top: 15px;" enctype="multipart/form-data">
            <div class="form-group col-md-4">
                <label>Услуга</label>
                <select name="service_id" class="form-control" id="service_id" required>
                    <option value=""></option>
                    @foreach ($services as $s)
                        <option value="{{ $s->id }}" data-price="{{ $s->price }}">{{ $s->name }}. Цена {{ $s->price }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label>Кол-во</label>
                <input type="number" class="form-control " name="service_count" id="service_count" value="1" required  > 
            </div>
            <div class="form-group col-md-2">
                <label>Цена за единицу</label>
                <input type="number" class="form-control" name="service_cost" id="service_cost"  readonly > 
            </div>
            <div class="form-group col-md-2">
                <label>Общая сумма</label>
                <input type="number" class="form-control" id="service_total_sum" readonly > 
            </div>
            <div class="form-group col-md-2">
                <label>&nbsp;</label>  
                <button class="btn btn-info btn-block" type="submit">Добавить</button>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    @else 
        <form class="form-material row" action="{{ action('Order\ServiceOrderController@postAddService', $item) }}" method="post" style="margin-top: 15px;" enctype="multipart/form-data">
            <div class="form-group col-md-4">
                <label>Услуга</label>
                <select name="service_id" class="form-control" id="service_id" required>
                    <option value=""></option>
                    @foreach ($services as $s)
                        <option value="{{ $s->id }}" data-price="{{ $s->price }}">{{ $s->name }}. Цена {{ $s->price }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label>Кол-во</label>
                <input type="number" class="form-control " name="service_count" id="service_count" value="1" required  > 
            </div>
            <div class="form-group col-md-2">
                <label>Цена за единицу</label>
                <input type="number" class="form-control" name="service_cost" id="service_cost"  required > 
            </div>
            <div class="form-group col-md-2">
                <label>Общая сумма</label>
                <input type="number" class="form-control" id="service_total_sum" readonly > 
            </div>
            <div class="form-group col-md-2">
                <label>&nbsp;</label>  
                <button class="btn btn-info btn-block" type="submit">Добавить</button>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    @endif
@endcan