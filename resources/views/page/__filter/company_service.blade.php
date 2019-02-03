
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-warning">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Форма фильтрации</h4>
            </div>
            <div class="card-body">
                <form class="form-material row" >
                    <div class="form-group col-md-7">
                        <input type="text" class="form-control " placeholder="Наименование" name="name" value="{{ $request->name }}" > 
                    </div>
                    <div class="form-group col-md-3">
                        <input type="number" class="form-control " placeholder="Цена" name="price" value="{{ $request->price }}"> 
                    </div>
                    
                    <div class="form-group col-md-2">
                        <button class="btn btn-warning btn-block" type="submit">Отфильтровать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>