
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-warning">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Форма фильтрации</h4>
            </div>
            <div class="card-body">
                <form class="form-material row" >
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control " placeholder="Системный номер" name="sys_num" value="{{ $request->sys_num }}" > 
                    </div>
                    <div class="form-group col-md-5">
                        <input type="text" class="form-control " placeholder="Наименование" name="name" value="{{ $request->name }}" > 
                    </div>
                    <div class="form-group col-md-3">
                        <select name="income_id" class="form-control" >
                            <option value="">Оприхование</option>
                            @foreach ($incomes as $id => $in)
                                <option value="{{ $in->id }}" {{ $request->income_id == $in->id ? 'selected' : '' }}>{{ $in->note.' #'.$in->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select name="cat_id" class="form-control" >
                            <option value="">Категория</option>
                            @foreach ($ar_cat as $id => $name)
                                <option value="{{ $id }}" {{ $request->cat_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select name="status_id" class="form-control" >
                            <option value="">Статус</option>
                            @foreach ($ar_status as $id => $name)
                                <option value="{{ $id }}" {{ $request->status_id == $id ? 'selected' : '' }}>{{ $name }}</option>
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
                    
                    <div class="form-group col-md-2">
                        <button class="btn btn-warning btn-block" type="submit">Отфильтровать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>