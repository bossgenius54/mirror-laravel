
@extends('layout')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-md-8">
            @include('page.stock.income_from_company.__include.view_service')
            @if ($item->relPositions()->where('status_id', App\Model\SysPositionStatus::IN_INCOME)->count())
                @include('page.stock.income_from_company.__include.view_income_product')
            @else 
                @include('page.stock.income_from_company.__include.view_product')
            @endif
            @include('page.stock.income_from_company.__include.view_position')
        </div>
        <div class="col-md-4">
            @if ($item->relPositions()->where('status_id', App\Model\SysPositionStatus::IN_INCOME)->count())
                <a href="{{ action('Stock\IncomeFromCompanyController@getActiveProduct', $item) }}" class="btn btn-warning btn-block">
                    Закончить оприходование
                </a><br/>
            @endif
            @include('page.stock.income_from_company.__include.view_main')
        </div>
    </div>
@endsection



@section('js_block')
    <script type="text/javascript">
        $(function () {
            $('.js_change_position').change(function(){
                let input = $(this).data('hidden_input');
                input = $('.'+input);

                input.val($(this).val());
            });
        });
	</script>
@endsection

