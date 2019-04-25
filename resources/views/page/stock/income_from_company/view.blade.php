
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-md-8">
        @include('page.stock.income_from_company.__include.view_service')
        @include('page.stock.income_from_company.__include.view_product')
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
