@if (count($can_status) > 0)
    <div class="btn-group   " style="width: 100%; margin-bottom: 10px;">
        <button type="button" class="btn btn-outline-success btn-rounde btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Смена статуса
        </button>
        <div class="dropdown-menu dropdown-menu__full">
            @foreach ($can_status as $id => $name)
                <a href="{{ action('Order\StatusOrderController@getChangeStatus', [$item,  $id]) }}""
                    class="dropdown-item js_accept_change_status" data-status="{{ $name }}" >
                    Сменить на "{{ $name }}"
                </a>
            @endforeach
        </div>
    </div>
@endif


<div class="modal fade bs-example-modal-sm" id="modal_change_status" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <form action="" class="js_change_status_form">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Окно подтверждения смены статуса</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" style="text-align: center;">Вы уверены что хотите сменить статус заявки на <br/>"<strong class="js_change_status_name"> </strong>"</div>
                <div class="modal-footer" style="justify-content: space-around;">
                    <button type="button" class="btn btn-default waves-effect col-md-5" data-dismiss="modal">Нет</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light col-md-5">Да</button>
                </div>
            </div>
        </div>
    </form>
</div>
                            
                               