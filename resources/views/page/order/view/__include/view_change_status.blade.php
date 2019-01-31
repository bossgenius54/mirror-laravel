@if (count($can_status) > 0)
    <div class="btn-group   " style="width: 100%; margin-bottom: 10px;">
        <button type="button" class="btn btn-outline-success btn-rounde btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Смена статуса
        </button>
        <div class="dropdown-menu">
            @foreach ($can_status as $id => $name)
                <a href="{{ action('Order\StatusOrderController@getChangeStatus', [$item,  $id]) }}""
                    class="dropdown-item " >
                    Сменаить на "{{ $name }}"
                </a>
            @endforeach
        </div>
    </div>
@endif

                            
                               