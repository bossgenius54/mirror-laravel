<div class="card">
    <div class="card-body">
        <h5 class="card-title">Лог редакции элемента Заказ #{{ $item->id }}</h5>

        @php
            $create_type = App\Model\OrderLogType::CREATED_ORDER;
        @endphp

        @foreach ($logs as $log)
            <div class="alert alert-warning" role="alert">
                <b style="font-weight: bold;">{{ $log->created_at }}</b>
                <hr/>
                Пользователь <b style="font-weight: bold;">{{ $log->relCreatedUser->name }} ({{ $log->relCreatedUser->getClearTypeName() }})</b> {{ $log->relOrderLogType->name }}
                <b style="font-weight: bold;">{{ $log->type_id != $create_type ? $log->note : ('#' . $log->order_id)  }}</b>
            </div>
        @endforeach
    </div>
  </div>
