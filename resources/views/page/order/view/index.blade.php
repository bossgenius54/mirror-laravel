
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-sm-8">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Услуги</h4>
            </div>
            <div class="card-body" style="    padding-bottom: 0px;">
                @include('page.order.view.__include.view_service_add')
            </div>
            @include('page.order.view.__include.view_service_list')
        </div>
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Продукция</h4>
            </div>
            <div class="card-body" style="    padding-bottom: 0px;">
                @include('page.order.view.__include.view_product_add')
            </div>
            @include('page.order.view.__include.view_product_list')
        </div>
    </div>
    <div class="col-sm-4">
        @include('page.order.view.__include.view_main')

        @include('page.order.view.__include.view_main_edit')
    </div>
</div>
@endsection


@section('js_block')
    <script type="text/javascript">
        $(function () {
            // service edit
            $(document).on('change', '#service_id', function() {
                let price = $( "#service_id option:selected" ).data('price');
                $('#service_cost').val(price);

                calcTotalServiceSum();
            });

            function calcTotalServiceSum(){
                let cost = parseInt($('#service_cost').val());
                let count = parseInt($('#service_count').val());

                $('#service_total_sum').val(cost * count);
            }

            $(document).on('change', '#service_cost', function() {
                calcTotalServiceSum();
            });

            $(document).on('change', '#service_count', function() {
                calcTotalServiceSum();
            });


            // product edit
            $(document).on('change', '#product_id', function() {
                let price = $( "#product_id option:selected" ).data('price');
                let max_count = $( "#product_id option:selected" ).data('count');
                $('#pos_cost').val(price);
                $('#pos_count').attr('max', max_count);
                $('#pos_count').val(1);

                calcTotalProductSum();
            });

            function calcTotalProductSum(){
                let cost = parseInt($('#pos_cost').val());
                let count = parseInt($('#pos_count').val());

                $('#pos_total_sum').val(cost * count);
            }

            $(document).on('change', '#pos_cost', function() {
                calcTotalProductSum();
            });

            $(document).on('change', '#pos_count', function() {
                calcTotalProductSum();
            });

        });
	</script>
@endsection