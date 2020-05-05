@if ($products)
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Сводная по позициям</h4>
        </div>
        <form class="form-material" action="{{ action('Stock\IncomeFromCompanyController@postAdd', $item) }}" method="post"  enctype="multipart/form-data">
            <div class="row " style="   margin-right: 0;
                                        margin-left: 0;
                                        padding: 10px 0;" >
                <div class="form-group col-md-4">
                    <label>Ассортимент</label>
                    <select name="product_id" class="form-control " >
                        @foreach ($prods as $pr)
                            <option value="{{ $pr->id }}">{{ $pr->artikul }}|{{ $pr->name }} ({{ $pr->sys_num }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Кол-во</label>
                    <input name="product_count" type="number" class="form-control "  >
                </div>
                <div class="form-group col-md-2">
                    <label>Цена </label>
                    <input name="price_cost" type="number" class="form-control "  >
                </div>
                <div class="form-group col-md-4 ">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-warning btn-block " type="button">Добавить</button>
                </div>
            </div>
        </form>

        @php
            $total_count = 0;
            $total_summ = 0;
        @endphp
        <table class="table  table-hover color-table table-responsive" >
            <thead>
                <tr>
                    <th>№</th>
                    <th>Продукция</th>
                    <th>Дата</th>
                    <th>Цена за единицу</th>
                    <th>Кол-во</th>
                    <th>Общая цена</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $i)
                    @php
                        $total_count += $i->product_count;
                        $total_summ += $i->product_sum;
                    @endphp
                    <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $i->relProduct ? $i->relProduct->name.' ('.$i->relProduct->sys_num.')' : '' }}</td>
                        <td>
                            <input type="date" style="width:200px!important;" class="form-control js_change_position" data-hidden_input="expired_at_{{ $i->group_num }}" value="{{ $i->expired_at }}"  />
                        </td>
                        <td>
                            <input type="number" style="width:100px!important;" class="form-control js_change_position" data-hidden_input="price_cost_{{ $i->group_num }}" value="{{ $i->price_cost }}" />
                        </td>
                        <td>
                            <input type="number" style="width:100px!important;" class="form-control js_change_position" data-hidden_input="product_count_{{ $i->group_num }}" value="{{ $i->product_count }}" />
                        </td>
                        <td>{{ $i->product_sum }}</td>
                        <td>
                            <form class="form-material" action="{{ action('Stock\IncomeFromCompanyController@postChange', $item) }}" method="post"  enctype="multipart/form-data">
                                <button class="btn btn-warning  btn-sm" type="submit">Изменить</button>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="position_group_num" class="position_group_num_{{ $i->group_num }}" value="{{ $i->group_num }}">
                                <input type="hidden" name="product_id" value="{{ $i->product_id }}">
                                <input type="hidden" name="price_cost" class="price_cost_{{ $i->group_num }}" value="{{ $i->price_cost }}">
                                <input type="hidden" name="product_count" class="product_count_{{ $i->group_num }}" value="{{ $i->product_count }}">
                                <input type="hidden" name="expired_at" class="expired_at_{{ $i->group_num }}" value="{{ $i->expired_at }}">
                                <button class="btn btn-danger  btn-sm" type="submit" name="need_delete" value="1">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        Итого
                    </td>
                    <td>{{ $total_count }}</td>
                    <td colspan="2">{{ $total_summ }}</td>
                </tr>
            </tfoot>
        </table>
        <!-- <pre>
            {{print_r($products)}}
        </pre> -->
    </div>
@endif
