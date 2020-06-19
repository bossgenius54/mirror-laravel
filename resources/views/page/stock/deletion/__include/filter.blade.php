
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-warning">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Форма фильтрации</h4>
            </div>
            <div class="card-body">
                <form class="form-material row" >

                    <div class="col-md-10 row">

                        <div class="form-group col-md-3">
                            <select name="name" class="form-control" >
                                <option value="">Наименование</option>
                                @foreach ($product_names as $id => $in)
                                    <option value="{{ $in->id }}" {{ $request->name == $in->id ? 'selected' : '' }}>{{ $in->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select name="sys_num" class="form-control" >
                                <option value="">Системный номер</option>
                                @foreach ($product_sys_num as $id => $in)
                                    <option value="{{ $in->id }}" {{ $request->sys_num == $in->id ? 'selected' : '' }}>{{ $in->sys_num }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select name="status_id" class="form-control" >
                                <option value="">Статус позиции</option>
                                @foreach ($ar_status as $status)
                                    <option value="{{ $status->id }}" {{ $request->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select name="income_id" class="form-control" >
                                <option value="">Оприхование</option>
                                @foreach ($ar_incomes as $id => $in)
                                    <option value="{{ $in->id }}" {{ $request->income_id == $in->id ? 'selected' : '' }}>{{ $in->note.' #'.$in->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select name="branch_id" class="form-control" >
                                <option value="">Филиал</option>
                                @foreach ($ar_branch as $id => $name)
                                    <option value="{{ $id }}" {{ $request->branch_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="expired_first">Срок годности</label>
                            <input type="date" class="form-control " id="expired_first" placeholder="Дата" name="expired_first" value="{{ $request->expired_first }}" >
                            <a class="" data-toggle="collapse" href="#collapseSecondDate" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Вторая дата
                            </a>
                        </div>

                        <div class="form-group col-md-4 collapse {{ $request->second_date ? 'show' : '' }}" id="collapseSecondDate">
                            <label for="expired_second">Дата до</label>
                            <input type="date" class="form-control " id="expired_second" placeholder="Дата" name="expired_second" value="{{ $request->expired_second }}" >
                        </div>

                        <div class="form-group col-md-3">
                            <select name="cat_id" class="form-control category-select" >
                                <option value="">Категория</option>
                                @foreach ($ar_cat as $id => $name)
                                    <option value="{{ $id }}" {{ $request->cat_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12 product-option">

                            @foreach($p_options as $po)

                                <div class="collapse " id="p-option-{{$po->id}}" >
                                    <h5>Выберите опции</h5>
                                    <hr/>
                                    <div class="card card-body">
                                        @if( $po->relProductOptions->count() == 0 )
                                            У данной категории товара отсутствуют опции
                                        @endif

                                        @php
                                            $last_opt_type_id = 0;
                                            $first = true;
                                        @endphp

                                        @foreach($po->relProductOptions as $option)

                                            @if( $last_opt_type_id != $option->type_id && $first == false )
                                                <hr/>
                                                </div>
                                                @php
                                                    $first = true;
                                                @endphp
                                            @endif

                                            @if( $option->type_id != $last_opt_type_id && $first == true)

                                                <div class="form-group">
                                                    <h6>{{$option->label}}</h6>

                                                @php
                                                    $first = false;
                                                @endphp

                                            @endif

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="option[]" id="option-{{$option->id}}" value="{{$option->id}}" {{ $request->option != null ? ( in_array($option->id, $request->option) ? 'checked=true' : '' ) : '' }} >
                                                <label class="form-check-label" for="option-{{$option->id}}">{{$option->option_name}}</label>
                                            </div>


                                            @php
                                                $last_opt_type_id = $option->type_id;
                                            @endphp

                                        @endforeach

                                        @if( $po->relProductOptions->count() > 0 )
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>

                    <div class="form-group col-md-2">
                        <button class="btn btn-warning btn-block" type="submit">Отфильтровать</button>
                        <a href="#" class="btn btn-warning btn-block reset">Сбросить</a> <!-- Функционал сброса расположен в JS block в index странице -->
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
