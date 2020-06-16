
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('page.order.view.__include.view_main_edit')
    </div>
    <div class="col-sm-8">

        @include('page.order.view.__include.view_service_block')

        @include('page.order.view.__include.view_product_block')

    </div>
    <div class="col-sm-4">
        <a href="?for_print=1" class="btn btn-block btn-outline-secondary" style="margin-bottom: 10px;">
            Версия для печати
        </a>
        <a href="{{ action('Order\ViewController@getPositions',$item) }}" class="btn btn-block btn-secondary" style="margin-bottom: 10px;">
            Добавить товар по одному
        </a>
        @include('page.order.view.__include.view_change_status')
        @include('page.order.view.__include.view_total_sum_status')
        @include('page.order.view.__include.view_formula_block')
        @include('page.order.view.__include.view_main')
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

                if(count > 0){
                    $('#service_total_sum').val(cost * count);
                } else {
                    $('#service_count').val('');
                }
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
                if (!$( "#product_id" ).hasClass('js_cant_max')){
                    $('#pos_count').attr('max', max_count);
                }

                $('#pos_count').val(1);

                calcTotalProductSum();
            });

            function calcTotalProductSum(){
                let cost = parseFloat($('#pos_cost').val());
                let count = parseInt($('#pos_count').val());


                if(count > 0){
                    $('#pos_total_sum').val(cost * count);
                } else {
                    $('#pos_count').val('');
                }
            }

            $(document).on('change', '#pos_cost', function() {
                calcTotalProductSum();
            });

            $(document).on('change', '#pos_count', function() {
                calcTotalProductSum();
            });

            let link = false;
            $('.js_accept_change_status').click(function(evt){
                evt.preventDefault();
                $('.js_change_status_name').html($(this).data('status'));

                $('.js_change_status_form').attr('action', $(this).attr('href'))
                $('#modal_change_status').modal("show");
            })

        });
	</script>
@endsection
