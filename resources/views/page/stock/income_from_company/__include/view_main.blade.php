<div class="card card-outline-info">
    <div class="card-header">
        <h4 class="m-b-0 text-white">Основные данные приемки № {{ $item->id }}</h4>
    </div>
    <div class="card-body">
        <small class="text-muted">Тип</small>
        <h6>{{ isset($ar_type[$item->type_id]) ? $ar_type[$item->type_id] : '' }}</h6>
        <small class="text-muted">Филиал</small>
        <h6>{{ $item->relBranch ? $item->relBranch->name : '' }}</h6>
        @if ($item->relFromCompany)
            <small class="text-muted">Поставщик</small>
            <h6>{{ $item->relFromCompany->name }}</h6>
        @endif
        @if ($item->relFromUser)
            <small class="text-muted">Клиент</small>
            <h6>{{ $item->relFromUser->name }}</h6>
        @endif

        <small class="text-muted">Сумма</small>
        <h6>{{ $item->related_cost }}</h6>
        <small class="text-muted">Создано</small>
        <h6>{{ $item->created_at }}</h6>
        <small class="text-muted">Изменено</small>
        <h6>{{ $item->updated_at }}</h6>
    </div>
</div>
