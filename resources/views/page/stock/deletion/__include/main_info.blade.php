
<div class="card card-outline-info">
    <div class="card-header">
        <h4 class="m-b-0 text-white">Основные данные заказа</h4>
    </div>
    <div class="card-body">

        <h5>Элемент удаления № {{ $item->id }}</h5>

        <small class="text-muted">Создатель (Роль)</small>
        <h6>{{ $item->relCreatedUser() ? ($item->relCreatedUser->name . " (" . $item->relCreatedUser->getTypeName() . ") " ) : '' }}</h6>

        <small class="text-muted">Общая сумма</small>
        <h6>{{ $total_sum ? $total_sum : '' }}</h6>

        <small class="text-muted">Кол-во позиций</small>
        <h6>{{ $item->relDeletePosition()->count() > 0 ? $item->relDeletePosition()->count() : '' }}</h6>

        <small class="text-muted">Дата создания</small>
        <h6>{{ $item->created_at }}</h6>

    </div>
</div>
