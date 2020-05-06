
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-warning">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Форма фильтрации</h4>
            </div>
            <div class="card-body">
                <form class="form-material row filter" >

                    <div class="col-md-10 row">

                        <div class="form-group col-md-4">
                            <input type="text" class="form-control " placeholder="Номер рецепта" name="formula_id" value="{{ $request->formula_id }}" >
                        </div>

                        <div class="form-group col-md-4">
                            <input type="text" class="form-control " placeholder="ФИО клиента" name="client_name" value="{{ $request->client_name }}" >
                        </div>

                        <div class="form-group col-md-2">
                            <select name="type_id" class="form-control" >
                                <option value="">Тип линз</option>
                                <option value="{{ $simple_type_id }}" {{ $request->type_id == $simple_type_id ? 'selected' : '' }}>Очковые линзы</option>
                                <option value="{{ $contact_type_id }}" {{ $request->type_id == $contact_type_id ? 'selected' : '' }}>Контактные линзы</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <select name="created_user_id" class="form-control" >
                                <option value="">Врач</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ $request->created_user_id == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
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
