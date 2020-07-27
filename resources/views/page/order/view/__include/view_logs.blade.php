<div class="card">
    <div class="card-body">
        <h5 class="card-title">Лог редакции элемента Заказ #{{ $item->id }}</h5>

        @php
            $create_type = App\Model\OrderLogType::CREATED_ORDER;
            $delete_service = App\Model\OrderLogType::SERVICE_DELETED;
            $delete_position = App\Model\OrderLogType::PRODUCT_DELETED;
        @endphp

        @foreach ($logs as $log)
            @php
                $alert_type = $log->type_id == $delete_service ? 'alert-warning' : ($log->type_id == $delete_position ? 'alert-warning' : 'alert-success') ;
            @endphp
            <div class="alert {{ $alert_type }}" role="alert" style="font-size: 11px; font-height:11px;">
                <b style="font-weight: bold;">{{ $log->created_at }}</b>
                <hr/>
                Пользователь <b style="font-weight: bold;">{{ $log->relCreatedUser->name }} ({{ $log->relCreatedUser->getClearTypeName() }})</b> {{ $log->relOrderLogType->name }}
                <b style="font-weight: bold;">{{ $log->type_id != $create_type ? $log->note : ('#' . $log->order_id)  }}</b>
            </div>
        @endforeach
    </div>
  </div>
