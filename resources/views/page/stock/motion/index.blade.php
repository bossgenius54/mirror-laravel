
@extends('layout')

@section('title', $title)

@section('content')

@include($filter_block)

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}
                    @can('create', App\Model\Motion::class)
                        <a href="{{ action('Stock\MotionController@getCreate') }}" type="button" class="btn btn-sm btn-info btn-rounded pull-right" >
                            Добавить
                        </a>
                    @endcan
                </h4>
            </div>

            <table class="table  table-hover color-table muted-table" >
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Статус</th>
                        <th>От филиала</th>
                        <th>К филиалу</th>
                        <th>Наименование</th>
                        <th>Изменен</th>
                        <th>Создан</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $i->id }}</td>
                            <td>{{ isset($ar_status[$i->status_id]) ? $ar_status[$i->status_id] : 'не указано' }}</td>
                            <td>{{ isset($ar_branch[$i->from_branch_id]) ? $ar_branch[$i->from_branch_id] : 'не указано' }}</td>
                            <td>{{ isset($ar_branch[$i->to_branh_id]) ? $ar_branch[$i->to_branh_id] : 'не указано' }}</td>
                            <td>{{ $i->name }}</td>
                            <td>{{ $i->updated_at }}</td>
                            <td>{{ $i->created_at }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('view', $i)
                                            <a class="dropdown-item" href="{{ action('Stock\MotionController@getView', $i) }}">
                                                Просмотр
                                            </a>
                                        @endcan

                                        @can('update', $i)
                                            @if($i->user_id == $user->id)
                                                <a class="dropdown-item" href="{{ action('Stock\MotionController@getUpdate', $i) }}">
                                                    Изменить
                                                </a>
                                            @endif
                                        @endcan
                                        @can('finish', $i)
                                            @if($user->id != $i->user_id)
                                            <a class="dropdown-item" href="{{ action('Stock\MotionController@getFinish', $i) }}">
                                                Завершить
                                            </a>
                                            @endif
                                        @endcan
                                        @can('cancel', $i)
                                            <a class="dropdown-item" href="{{ action('Stock\MotionController@getCanceled', $i) }}">
                                                Отменить
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            {!! $items->appends($request->all())->links() !!}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
