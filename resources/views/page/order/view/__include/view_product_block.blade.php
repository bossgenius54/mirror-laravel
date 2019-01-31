@if ($user->can('position', $item) ||  $order_products->count() > 0)
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Продукция</h4>
        </div>
        @if ($request->for_print != 1)
            <div class="card-body" style="padding-bottom: 0px;padding-top: 0;">
                @include('page.order.view.__include.view_product_add')
            </div>
        @endif
        @include('page.order.view.__include.view_product_list')
    </div>
@endif