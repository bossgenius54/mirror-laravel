
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
                            <input type="text" class="form-control " placeholder="Наименование" name="name" value="{{ $request->name }}" >
                        </div>

                        <div class="form-group col-md-8">
                            <input type="text" class="form-control " placeholder="Заметка" name="note" value="{{ $request->name }}" >
                        </div>

                        @can('filterStatus','App\Model\View\IncomeFromCompany')
                            <div class="form-group col-md-2">
                                <select name="status" class="form-control" >
                                    <option value="">Статус</option>
                                    <option value="{{ $in_income }}" {{ $request->status == $in_income ? 'selected' : '' }}>Оприходование не завершено</option>
                                    <option value="{{ $active }}" {{ $request->status == $active ? 'selected' : '' }}>Оприходование завершено</option>
                                </select>
                            </div>
                        @endcan

                        <div class="form-group col-md-4">
                            <select name="branch_id" class="form-control" >
                                <option value="">В Филиал</option>
                                @foreach ($ar_branch as $id => $name)
                                    <option value="{{ $id }}" {{ $request->branch_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <select name="company_id" class="form-control" >
                                <option value="">От Компании</option>
                                @foreach ($ar_company as $id => $name)
                                    <option value="{{ $id }}" {{ $request->company_id == $id ? 'selected' : '' }}>{{ $name }}</option>
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
