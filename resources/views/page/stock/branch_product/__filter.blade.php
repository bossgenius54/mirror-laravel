
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
                    <div class="form-group col-md-4">
                        <select name="name" class="form-control" >
                            <option value="">Наименование</option>
                            @foreach ($items as $pr)
                                <option value="{{ $pr->name }}" {{ $request->name == $pr->name ? 'selected' : '' }}>{{ $pr->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select name="cat_id" class="form-control" >
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
                    

                    <div class="form-group col-md-2">
                        <button class="btn btn-warning btn-block" type="submit">Отфильтровать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>