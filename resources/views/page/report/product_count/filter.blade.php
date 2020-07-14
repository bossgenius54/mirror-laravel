<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-warning">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Форма фильтрации</h4>
            </div>
            <div class="card-body">
                <form class="form-material row" >

                    <div class="col-md-10 row">
                        <div class="form-group col-md-4">
                            <select name="name" class="form-control" >
                                <option value="">Наименование</option>
                                @foreach ($filter_names as $pr)
                                    <option value="{{ $pr->name }}" {{ $request->name == $pr->name ? 'selected' : '' }}>{{ $pr->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select name="name" class="form-control" >
                                <option value="">Системный номер</option>
                                @foreach ($sys_nums as $pr)
                                    <option value="{{ $pr->name }}" {{ $request->sys_num == $pr->sys_num ? 'selected' : '' }}>{{ $pr->sys_num }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select name="cat_id" class="form-control category-select" >
                                <option value="">Категория</option>
                                @foreach ($ar_cat as $id => $name)
                                    <option value="{{ $id }}" {{ $request->cat_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <select name="branch_name" class="form-control" >
                                <option value="">Филиал</option>
                                @foreach ($ar_branch as $name)
                                    <option value="{{ $name }}" {{ $request->branch_name == $name ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="checkbox" id="hidden_null"  name="hidden_null" value="1" {{ $request->hidden_null ? 'checked' : '' }}/>
                            <label for="hidden_null">Скрыть нулевые значения</label>
                        </div>
                        <div class="form-group col-md-4">
                            <select name="balans_diff" class="form-control" >
                                <option value="">Разница</option>
                                <option value="plus"  {{ $request->balans_diff == 'plus' ? 'selected' : '' }}>Докупать не нужно</option>
                                <option value="minus"  {{ $request->balans_diff == 'minus' ? 'selected' : '' }}>Нужно докупить</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group col-md-2">
                        <button class="btn btn-warning btn-block" type="submit">Отфильтровать</button>
                        <a href="#" class="btn btn-warning btn-block reset">Сбросить</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@section('js_block')
    <script type="text/javascript">
        $(function () {
            $('.reset').on('click', function(e){
                e.preventDefault();
                console.log('clearing a filter ---');
                $('input').val('');
                $('select').children('option').attr('selected', false);
                $('select').children('option').first().attr('selected',true);
                $('.filter-checkbox').prop('checked', false);

                $('form').submit();
            });

        });
	</script>
@endsection
