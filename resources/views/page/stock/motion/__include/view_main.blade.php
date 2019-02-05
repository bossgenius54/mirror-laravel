<div class="card card-outline-info">
    <div class="card-header">
        <h4 class="m-b-0 text-white">Основные данные перемещения № {{ $item->id }}</h4>
    </div>
    <div class="card-body">
        <small class="text-muted">Статус</small>
        <h6>{{ isset($ar_status[$item->status_id]) ? $ar_status[$item->status_id] : '' }}</h6>
        <small class="text-muted">От филиала</small>
        <h6>{{ $item->relFromBranch ? $item->relFromBranch->name : '' }}</h6>
        <small class="text-muted">К филиалу</small>
        <h6>{{ $item->relToBranch ? $item->relToBranch->name : '' }}</h6>
        
      
        <small class="text-muted">Наименование</small>
        <h6>{{ $item->name }}</h6>
        <small class="text-muted">Создано</small>
        <h6>{{ $item->created_at }}</h6>
        <small class="text-muted">Изменено</small>
        <h6>{{ $item->updated_at }}</h6>
    </div>
</div>