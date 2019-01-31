<div class="card card-outline-info">
    <div class="card-header">
        <h4 class="m-b-0 text-white">Основные данные заказа</h4>
    </div>
    <div class="card-body">
        <small class="text-muted">Тип</small>
        <h6>{{ $item->is_retail ? 'Розница' : 'Оптовая' }} {{ $item->is_onlain ? '(онлайн)' : '' }}</h6>
        <small class="text-muted">От</small>
        <h6>{{ $item->relType ? $item->relType->name : '' }}</h6>
        <small class="text-muted">Статус</small>
        <h6>{{ $item->relStatus ? $item->relStatus->name : '' }}</h6>
        <small class="text-muted">Компания</small>
        <h6>{{ $item->relCompany ? $item->relCompany->name : '' }}</h6>
        <small class="text-muted">Филиал</small>
        <h6>{{ $item->relBranch ? $item->relBranch->name : '' }}</h6>
        <small class="text-muted">Клиент</small>
        <h6>{{ $item->getClient() ? $item->getClient()->name : '' }}</h6>
        @if ($item->total_sum )
            <small class="text-muted">Общая сумма</small>
            <h6>{{ $item->total_sum }}</h6>
        @endif
        @if ($item->prepay_sum )
            <small class="text-muted">Предоплата</small>
            <h6>{{ $item->prepay_sum }}</h6>
        @endif
        @if ($item->may_finish_at )
            <small class="text-muted">Дата изготовления</small>
            <h6>{{ $item->may_finish_at }}</h6>
        @endif
        @if ($item->name )
            <small class="text-muted">Наименование</small>
            <h6>{{ $item->name }}</h6>
        @endif
        @if ($item->note )
            <small class="text-muted">Заметка</small>
            <h6>{{ $item->note }}</h6>
        @endif
        <small class="text-muted">Менеджер</small>
        <h6>{{ $item->relCreatedUser ? $item->relCreatedUser->name : '' }}</h6>
        <small class="text-muted">Создано</small>
        <h6>{{ $item->created_at }}</h6>
        <small class="text-muted">Изменено</small>
        <h6>{{ $item->updated_at }}</h6>
    </div>
</div>