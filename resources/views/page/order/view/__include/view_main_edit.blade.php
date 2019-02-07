@can('update', $item)
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Форма редактирования заказа</h4>
        </div>
        <div class="card-body">
            <form class="form-material row" action="{{ $action }}" method="post"  enctype="multipart/form-data">
                <div class="form-group col-md-2">
                    <label>Дата изготовления</label>
                    <input type="date" class="form-control {{ $item->may_finish_at }}" name="may_finish_at" value="{{ $item->may_finish_at }}" > 
                </div>
                <div class="form-group col-md-2">
                    <label>Предолата</label>
                    <input type="number" class="form-control " name="prepay_sum" value="{{ $item->prepay_sum }}" > 
                </div>
                <div class="form-group col-md-6">
                    <label>Заметка</label>
                    <input type="text" class="form-control" name="name" value="{{ $item->name }}" > 
                </div>
                <div class="form-group col-md-2">
                    <label>&nbsp;</label>  
                    <button class="btn btn-info btn-block" type="submit">Сохранить</button>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>
@endcan