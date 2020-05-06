
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
                            <select name="type_id" class="form-control" >
                                <option value="">От</option>
                                @foreach ($ar_type as $id => $name)
                                    <option value="{{ $id }}" {{ $request->type_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <select name="status_id" class="form-control" >
                                <option value="">Статус</option>
                                @foreach ($ar_status as $id => $name)
                                    <option value="{{ $id }}" {{ $request->status_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <select name="is_retail" class="form-control" >
                                <option value="">Тип заказа</option>
                                <option value="{{ '1' }}" {{ $request->is_retail == 1 ? 'selected' : '' }}>Розничный заказ</option>
                                <option value="{{ '0' }}" {{ $request->is_retail != '' && $request->is_retail == 0 ? 'selected' : '' }}>Оптовый заказ</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <input type="text" class="form-control " placeholder="От клиента компании" name="from_company" value="{{ $request->from_company }}" >
                        </div>

                        <div class="form-group col-md-3">
                            <input type="text" class="form-control " placeholder="От клиента физ. лица" name="from_user" value="{{ $request->from_user }}" >
                        </div>

                        @can('filterManager','App\Model\Order')
                            <div class="form-group col-md-4">
                                <select name="created_user_id" class="form-control" >
                                    <option value="">Менеджера</option>
                                    @foreach ($ar_managers as $id => $name)
                                        <option value="{{ $id }}" {{ $request->status_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endcan

                        <div class="form-group col-md-4">
                            <select name="branch_id" class="form-control" >
                                <option value="">Филиалы</option>
                                @foreach ($ar_branch as $id => $name)
                                    <option value="{{ $id }}" {{ $request->branch_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="first_date">Дата</label>
                            <input type="date" class="form-control " id="first_date" placeholder="Дата" name="first_date" value="{{ $request->first_date }}" >
                            <a class="" data-toggle="collapse" href="#collapseSecondDate" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Вторая дата
                            </a>
                        </div>

                        <div class="form-group col-md-4 collapse {{ $request->second_date ? 'show' : '' }}" id="collapseSecondDate">
                            <label for="second_date">Дата до</label>
                            <input type="date" class="form-control " id="second_date" placeholder="Дата" name="second_date" value="{{ $request->second_date }}" >
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

                $('form').submit();
            });
        });
	</script>
@endsection
