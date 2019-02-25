@if ($user->can('service', $item) ||  $order_services->count() > 0)
    @if ($user->type_id != App\Model\SysUserType::COMPANY_CLIENT))4
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Услуги</h4>
            </div>
            @if ($request->for_print != 1)
                <div class="card-body" style="    padding-bottom: 0px;     padding-top: 0;">
                    @include('page.order.view.__include.view_service_add')
                </div>
            @endif
            @include('page.order.view.__include.view_service_list')
        </div>
    @endif
@endif