
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-warning">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Форма фильтрации</h4>
            </div>
            <div class="card-body">
                <form class="form-material row" >
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
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control " placeholder="Филиал" name="branch" value="{{ $request->branch }}" > 
                    </div>
                    <div class="form-group col-md-5">
                        <input type="text" class="form-control " placeholder="От клиента компании" name="from_company" value="{{ $request->from_company }}" > 
                    </div>
                    <div class="form-group col-md-5">
                        <input type="text" class="form-control " placeholder="От клиента физ. лица" name="from_user" value="{{ $request->from_user }}" > 
                    </div>
                 

                    
                    
                    <div class="form-group col-md-2">
                        <button class="btn btn-warning btn-block" type="submit">Отфильтровать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>