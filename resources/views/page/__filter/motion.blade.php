
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-warning">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Форма фильтрации</h4>
            </div>
            <div class="card-body">
                <form class="form-material row filter" >
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control " placeholder="Наименование" name="name" value="{{ $request->name }}" >
                    </div>
                    <div class="form-group col-md-2">
                        <select name="status_id" class="form-control" >
                            <option value="">Статус</option>
                            @foreach ($ar_status as $id => $name)
                                <option value="{{ $id }}" {{ $request->status_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select name="from_branch_id" class="form-control" >
                            <option value="">От филиала</option>
                            @foreach ($ar_branch as $id => $name)
                                <option value="{{ $id }}" {{ $request->from_branch_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select name="to_branh_id" class="form-control" >
                            <option value="">К филиалу</option>
                            @foreach ($ar_branch as $id => $name)
                                <option value="{{ $id }}" {{ $request->to_branh_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
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
