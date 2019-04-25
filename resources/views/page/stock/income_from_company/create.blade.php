
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">{{ $title }}</h4>
            </div>
            <div class="card-body">
                <form class="form-material" action="{{ $action }}" method="post"  enctype="multipart/form-data">
                    <h3 class="card-title">Основные характеристики</h3>
                    <hr />
                    <div class="row">

                        <div class="form-group col-md-3">
                            <label>Филиал</label>
                            <select name="branch_id" class="form-control" required>
                                @foreach ($ar_branch as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>От компании</label>
                            <select name="from_company_id" class="form-control" required>
                                @foreach ($ar_company as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Заметка</label>
                            <input type="text" class="form-control" name="note" > 
                        </div>
                    </div>
                    <h3 class="card-title">Позиции/Товары</h3>
                    <hr />
                    <div class="row js_pr_add_block" style="    background: #bababa;
                                                                color: #f1f1f1;
                                                                margin: 10px 0;">
                        <div class="form-group col-md-4">
                            <label>Ассортимент</label>
                            <select  class="form-control js_pr_select" >
                                @foreach ($products as $pr)
                                    <option value="{{ $pr->id }}">{{ $pr->artikul }}|{{ $pr->name }} ({{ $pr->sys_num }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label>Кол-во</label>
                            <input type="number" class="form-control js_pr_count"  > 
                        </div>
                        <div class="form-group col-md-1">
                            <label>Цена </label>
                            <input type="number" class="form-control js_pr_cost"  > 
                        </div>
                        <div class="form-group col-md-2">
                            <label>Общая </label>
                            <input type="number" class="form-control js_pr_total" readonly  > 
                        </div>
                        <div class="form-group col-md-4 ">
                            <label>&nbsp;</label>
                            <button class="btn btn-warning btn-block js_pr_add" type="button">Добавить</button>
                        </div>
                    </div>
                    <div class="js_position_list">
                    </div>

                    <button class="btn btn-info pull-right" type="submit">Сохранить</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js_block')
    <script type="text/javascript">
        $(function () {
            $(document).on('change', '.js_pr_count', function() {
                let block = $(this).parent().parent();
                let count = block.find( ".js_pr_count" );
                let cost = block.find( ".js_pr_cost" );
                let total = block.find( ".js_pr_total" );

                let total_sum = parseInt(count.val()) * parseInt(cost.val());
                total.val(total_sum);
            });

            $(document).on('change', '.js_pr_cost', function() {
                let block = $(this).parent().parent();
                let count = block.find( ".js_pr_count" );
                let cost = block.find( ".js_pr_cost" );
                let total = block.find( ".js_pr_total" );

                let total_sum = parseInt(count.val()) * parseInt(cost.val());
                total.val(total_sum);
            });

            $(document).on('click', '.js_pr_remove', function() {
                let block = $(this).parent().parent();
                block.remove();
            });

            $(document).on('click', '.js_pr_add', function() {
                let block = $(this).parent().parent();
                let count = block.find( ".js_pr_count" );
                let cost = block.find( ".js_pr_cost" );
                let total = block.find( ".js_pr_total" );
                let select = block.find( ".js_pr_select" );

                let pr_id = select.val();
                let pr_name = block.find( ".js_pr_select option:selected" ).text();
                

                let html = `
                    <div class="row js_pr_el_`+pr_id+`">
                        <div class="form-group col-md-4">
                            <label>Ассортимент</label>
                            <input type="text" class="form-control" value="`+pr_name+`" readonly> 
                            <input type="hidden" name="product_id[]" value="`+pr_id+`" class="form-control"  > 
                        </div>
                        <div class="form-group col-md-1">
                            <label>Кол-во</label>
                            <input type="number" name="product_count[]" value="` + parseInt( count.val() ) + `" class="form-control js_pr_count"  > 
                        </div>
                        <div class="form-group col-md-1">
                            <label>Цена </label>
                            <input type="number" name="product_cost[]"  value="` + parseInt( cost.val() ) + `" class="form-control js_pr_cost"  > 
                        </div>
                        <div class="form-group col-md-2">
                            <label>Общая </label>
                            <input type="number" class="form-control js_pr_total" value="` + parseInt( total.val() ) + `" readonly  > 
                        </div>
                        <div class="form-group col-md-2">
                            <label>Дата истечения</label>
                            <input type="date" name="product_date[]" class="form-control "  > 
                        </div>
                        <div class="form-group col-md-2">
                            <button class="btn btn-danger btn-block js_pr_remove" type="button">Убрать</button>
                        </div>
                    </div>
                `;

                $('.js_position_list').prepend(html);

                count.val(null);
                cost.val(null);
                total.val(null);
            });
            
        });
	</script>
@endsection
