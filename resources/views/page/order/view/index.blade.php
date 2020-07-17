
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

        @include('page.order.view.__include.view_positions_list_modal')

    </div>
    <div class="col-sm-4">
        <a href="?for_print=1" class="btn btn-block btn-outline-secondary" style="margin-bottom: 10px;">
            Версия для печати
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
            });

            $('#filter').on('click', function(){
                $('#filterBlock').toggle();
            });

            $('.filter-action').on('click', function(e) {
                e.preventDefault();

                $('#confirm').css("display", "block");
                $('#send').css('display', 'none');
                $('#modalTitle').text('Окно выбора позиции');
                $('.modal-tbody').html('<th><td colspan="7">Подождите...</td></th>');

                let filterCheckBox = $('.filter-checkbox');

                let filterData = {};
                filterData.product_id = $('#product_id').val();

                if ( filterCheckBox.prop('checked') == true ){
                    filterData.expired_first = $('#expired_first').val();
                    filterData.second_date = $('#second_date').val();
                }

                console.log(filterData);

                if (filterData.product_id != ''){
                    $.ajax({
                        url: "{{ $get_position }}",
                        method: "POST",
                        data: filterData,
                        success: function(result){
                            addItemsToModal(result);
                        },
                        error: function(){
                            alert('error');
                        }
                    });

                    $('#positionModal').modal('toggle');

                    $('#expired_first').val('');
                    $('#second_date').val('');

                } else {
                    alert('Выберите продукт');
                }


            });

            let selected = [];
            $(document).on('click', '.positions-inputs', function() {
                if(this.checked) {
                    selected.push(this.value);
                    console.log(this.value);
                } else {
                    selected = selected.filter( item => item != this.value )
                }

                $('.count').val(selected.length);
            });

            $('.count').change(function(){
                let countRequest = parseInt($(this).val());
                let countIsset = selected.length;
                let countNeed = (countIsset - countRequest) > 0  ? ( countIsset - countRequest ) : ( countRequest -countIsset );
                let inputs = $('.positions-inputs');
                console.log(countNeed);

                inputs.prop('checked', false);
                selected = [];
                let i;

                countRequest = countRequest > inputs.length ? inputs.length : countRequest;

                inputs.each(function () {

                    if ( $(this).prop('checked') == false && $(this).prop('disabled') != true && countRequest != 0 ){
                        $('#position-'+$(this).val()).prop('checked', true);
                        selected.push($(this).val());
                        countRequest -= 1;
                    }

                });

                $(this).val(selected.length);
                console.log(selected);

            });
            function topFunction() {
                document.body.scrollTop = 0; // For Safari
                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
            }

            $('#confirm').on('click', function(){
                let positionInputs = $('.positions-inputs');

                positionInputs.each(function(){
                    let input = $(this);
                    let tr = $('#tr-'+input.val());
                    console.log(tr);

                    if (input.prop('checked') != true ){
                        tr.remove();
                        console.log(input.val());
                        console.log('unchecked');
                    }
                });

                $(this).css("display", "none");
                $('#send').css('display', 'block');
                $('#modalTitle').text('Подтвердите позиции');
            });

            $('#send').on('click', function(e){
                e.preventDefault();
                let form = $('#add-basket');

                selected.forEach(function(id) {
                    console.log(id);

                    $('<input>').attr({
                        type: 'hidden',
                        id: id,
                        value: id,
                        name: 'position_id[]'
                    }).appendTo(form);
                });

                form.submit();

                $('#confirm').css("display", "block");
                $('#send').css('display', 'none');
                $('#modalTitle').text('Окно выбора позиции');
                $('.modal-tbody').html('<th><td colspan="7">Подождите...</td></th>');
                selected = [];

            });

            $('#return').on('click', function() {
                $('#confirm').css("display", "block");
                $('#send').css('display', 'none');
                $('#modalTitle').text('Окно выбора позиции');
                $('.modal-tbody').html('<th><td colspan="7">Подождите...</td></th>');
                selected = [];
            });

            function addItemsToModal(result){
                let table = $('.modal-tbody');
                let total_count = $('.total_count');
                let count = $('.count');
                let nullElems = [];
                table.html('');

                console.log(result.items);
                total_count.html(result.items.length);
                count.html('0');

                if( result.items.length > 0){
                    result.items.forEach(element => {

                        if (element.expired_at != null){
                            table.append("<tr id='tr-"+element.id+"'><td>"+element.id+"</td><td>"+element.rel_product.name+"</td><td>"+element.rel_product.sys_num+"</td><td>"+element.rel_product.price_retail+"</td><td>"+element.rel_product.price_opt+"</td><td>"+element.expired_at+"</td><td><div class=\"form-check form-check-inline col-md-2\"><input class=\"form-check-input positions-inputs \" type=\"checkbox\" id=\"position-"+element.id+"\" value='"+element.id+"'><label class=\"form-check-label\" for=\"position-"+element.id+"\">Добавить</label></div></td><td></td></tr>");
                        } else {
                            nullElems.push(element);
                        }
                    });

                    console.log(nullElems);

                    if (nullElems.length > 0){
                        nullElems.forEach(element => {
                            table.append("<tr id='tr-"+element.id+"'><td>"+element.id+"</td><td>"+element.rel_product.name+"</td><td>"+element.rel_product.sys_num+"</td><td>"+element.rel_product.price_retail+"</td><td>"+element.rel_product.price_opt+"</td><td>"+element.expired_at+"</td><td><div class=\"form-check form-check-inline col-md-2\"><input class=\"form-check-input positions-inputs \" type=\"checkbox\" id=\"position-"+element.id+"\" value='"+element.id+"'><label class=\"form-check-label\" for=\"position-"+element.id+"\">Добавить</label></div></td><td></td></tr>");
                        });
                    }

                } else {
                        table.append("<tr><td colspan='7'>По заданным параметрам нет элементов, обновите фильтр или отключите его</td></tr>");
                }


            }
        });
	</script>
@endsection
