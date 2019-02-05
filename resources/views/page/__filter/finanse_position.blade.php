
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-warning">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Форма фильтрации</h4>
            </div>
            <div class="card-body">
                <form class="form-material row" >
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control " placeholder="Филиал" name="b_name" value="{{ $request->b_name }}" > 
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control " placeholder="Продукция" name="p_name" value="{{ $request->p_name }}" > 
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control " placeholder="Системный номер" name="position_sys_num" value="{{ $request->position_sys_num }}" > 
                    </div>
                    <div class="form-group col-md-2">
                        <button class="btn btn-warning btn-block" type="submit">Отфильтровать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>