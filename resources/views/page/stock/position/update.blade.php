
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-sm-8">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">{{ $title }}</h4>
            </div>
            <div class="card-body">
                <form class="form-material" action="{{ $action }}" method="post"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Себестоимость</label>
                        <input type="number" class="form-control " name="price_cost" value="{{ $item->price_cost }}" required>
                    </div>
                    <div class="form-group">
                        <label>Срок годности</label>
                        <input type="date" class="form-control " name="expired_at" value="{{ $item->expired_at }}" required>
                    </div>

                    <button class="btn btn-info pull-right" type="submit">Сохранить</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">
                    Лог истории позиции
                </h4>
            </div>
            <div class="card-body">

                @foreach ($logs as $log)
                    @php
                        if ($log->relMotion) {

                            $createdUser = $log->relMotion->relCreatedUser->name . ' (' . $log->relMotion->relCreatedUser->getTypeName() . ')';
                            $created_at = $log->relMotion->updated_at;
                            $text = 'перемещена из ' . $log->relMotion->relFromBranch->name . ' в ' . $log->relMotion->relToBranch->name . '';

                        } elseif ($log->relIncome) {

                            $createdUser = $log->relIncome->relCreatedUser ? ($log->relIncome->relCreatedUser->name . ' (' . $log->relIncome->relCreatedUser->getTypeName() . ')') : '';
                            $created_at = $log->relIncome->updated_at;
                            $text = $log->relIncome->relType->name . ' #' . $log->relIncome->id . ' ' . ($log->relIncome->relFromCompany ? $log->relIncome->relFromCompany->name : $log->relIncome->relFromUser->name) ;

                        } elseif ($log->relOutcome) {

                            $createdUser = $log->relOutcome->relCreatedUser->name . ' (' . $log->relOutcome->relCreatedUser->getTypeName() . ')';
                            $created_at = $log->relOutcome->updated_at;
                            $text = $log->relOutcome->relToUser ? ('продан клиенту #' . $log->relOutcome->relToUser->id . ' '. $log->relOutcome->relToUser->name) : ('продан компание #' . $log->relOutcome->relToCompany->id . ' '. $log->relOutcome->relToCompany->name);

                        }
                    @endphp
                    <div class="alert alert-success" role="alert" style="font-size: 11px;line-height:15px;">
                        <b style="font-weight: bold;">{{ $created_at }}</b>
                        <hr/>
                        Позиция <b style="font-weight: bold;">#{{ $item->id }} - {{ $product->name }} ( {{ $product->sys_num }} )</b>
                        <b style="font-weight: bold;">
                            {!! $text !!}
                        </b>
                        <hr/>
                        <p class="text-right" style="line-height: 11px;">Инициатор: {{ $createdUser }} </p>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

</div>
@endsection
