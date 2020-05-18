
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    @can('cancel', $item)
        <div class="col-md-6">
            <a class="btn btn-danger btn-block" href="{{ action('Stock\MotionController@getCanceled', $item) }}">
                Отменить
            </a>
        </div>
    @endcan
    @can('finish', $item)

        @if( $item->to_branh_id == $user->branch_id || in_array($user->type_id, [ App\Model\SysUserType::DIRECTOR, App\Model\SysUserType::STOCK_MANAGER ]) )

            <div class="col-md-6" style="margin-bottom: 10px;">
                <a class="btn btn-success btn-block" href="{{ action('Stock\MotionController@getFinish', $item) }}">
                    Завершить
                </a>
            </div>

        @endif

    @endcan
    @can('update', $item)

        @if( $item->status_id == App\Model\SysMotionStatus::IN_WORK && ( $item->from_branch_id == $user->branch_id || in_array($user->type_id, [ App\Model\SysUserType::DIRECTOR, App\Model\SysUserType::STOCK_MANAGER ]) ) )
            <div class="col-md-6" style="margin-bottom: 10px;">
                <a class="btn btn-success btn-block" href="{{ action('Stock\MotionController@getConfirm', $item) }}">
                    Подтвердить и отправить
                </a>
            </div>
        @endif

    @endcan

    <div class="col-sm-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Перемещение № {{ $item->id }}</h4>
            </div>
            <div class="card-body ">

                <h3 class="card-title">Данные перемещения</h3>
                <div class="row">
                    <div class="form-group col-md-4" >
                        <label>Наименование</label>
                        <input type="text" class="form-control " name="name" value="{{ $item->name }}" disabled>
                    </div>
                    <div class="form-group col-md-4">
                        <label>От филиала</label>
                        <select name="from_branch_id" class="form-control" disabled>
                            @foreach ($ar_branch as $id => $name)
                                <option value="{{ $id }}" {{ $item->from_branch_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>К филиалу </label>
                        <select name="to_branh_id" class="form-control" disabled>
                            @foreach ($ar_branch as $id => $name)
                                <option value="{{ $id }}" {{ $item->to_branh_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h3 class="card-title">Форма прикрепления позиций/товаров</h3>
                <form class="form-material row" action="{{ $action }}" method="post"  enctype="multipart/form-data">
                    <div class="form-group col-md-4">
                        <label>Ассортимент</label>
                        <select name="product_id" id="product_id" class="form-control" required>
                            <option value="">Выберите ассортимент</option>
                            @foreach ($products as $product)
                                @php
                                    $position_count = $product->relPositions()->where('branch_id', $item->from_branch_id)->where('status_id', $pos_status)->count();
                                @endphp
                                <option value="{{ $product->id }}" data-count="{{ $position_count }}">{{ $product->artikul }}|{{ $product->name }} ({{ $product->sys_num }}). Есть {{ $position_count }} позиций</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Единиц</label>
                        <input type="number" class="form-control " name="count_position" id="count_position" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp; </label>
                        <button class="btn btn-info btn-block" type="submit">Прикрепить</button>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>

                <h3 class="card-title">Список прикрепленных позиций/товаров</h3>

                @php
                    $total_count = 0;
                    $total_sum = 0;
                @endphp

                @foreach ($motion_products as $i)
                    <div class="form-material row" >
                        <div class="form-group col-md-4">
                            <label>Ассортимент</label>
                            <input type="text" class="form-control" value="{{ $i->relProduct->name }} ({{ $i->relProduct->sys_num }})" disabled>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Цена за единицу</label>
                            <input type="text" class="form-control" value="{{ $i->relProduct->price_retail }}" disabled>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Единиц</label>
                            <input type="text" class="form-control" value="{{ $i->count_position }}" disabled>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Общая цена</label>
                            <input type="text" class="form-control" value="{{ $i->relProduct->price_retail * $i->count_position }}" disabled>
                        </div>
                        <div class="form-group col-md-2">
                            <label>&nbsp; </label>
                            <a href="{{ action('Stock\MotionController@getUnsetProduct', [$item, $i]) }}" class="btn btn-danger btn-block" >Открепить</a>
                        </div>
                    </div>

                    @php
                        $total_count += $i->count_position;
                        $total_sum += $i->relProduct->price_retail * $i->count_position;
                    @endphp

                @endforeach

                <div class="form-material row" >
                    <div class="form-group col-md-6">
                        <h4>Итог</h4>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Общее количество</label>
                        <input type="text" class="form-control" value="{{ $total_count }}" disabled>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Общая сумма</label>
                        <input type="text" class="form-control" value="{{ $total_sum }}" disabled>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection


@section('js_block')
    <script type="text/javascript">
        $(function () {
            $(document).on('change', '#product_id', function() {
                let max_position = $( "#product_id option:selected" ).data('count');
                $('#count_position').attr( "max",  max_position);
                $('#count_position').val('');
            });
        });
	</script>
@endsection
