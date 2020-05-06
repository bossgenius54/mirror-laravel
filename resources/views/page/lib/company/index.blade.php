
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}
                    @can('create', App\Model\Company::class)
                        <a href="{{ action('Lib\CompanyController@getCreate') }}" type="button"
                            class="btn btn-sm btn-info btn-rounded pull-right" >
                            Добавить
                        </a>
                    @endcan
                </h4>
            </div>

            <table class="table  table-hover color-table muted-table" >
                <thead>
                    <tr>
                        <th>id</th>
                        {{-- <th>Права в системе</th> --}}
                        <th>Форма собственности</th>
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
                            {{-- <td>{{ isset($ar_type[$i->type_id]) ? $ar_type[$i->type_id] : 'не указано' }}</td> --}}
                            <td>{{ isset($ar_cat[$i->cat_id]) ? $ar_cat[$i->cat_id] : 'не указано' }}</td>
                            <td>{{ $i->name }}</td>
                            <td>{{ $i->updated_at }}</td>
                            <td>{{ $i->created_at }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('upgradeToHalfPermission', $i)
                                            <a class="dropdown-item" href="{{ action('Lib\CompanyController@getUpgradeToHalfPermission', $i) }}">
                                                Дать возможность онлайн покупок
                                            </a>
                                        @endcan
                                        @can('upgradeToFullPermission', $i)
                                            <a class="dropdown-item" href="{{ action('Lib\CompanyController@getUpgradeToFullPermission', $i) }}">
                                                Полный доступ
                                            </a>
                                        @endcan
                                        @can('list', 'App\Model\Company')
                                            <a class="dropdown-item" href="{{ action('Lib\SimpleDirectorController@getIndex', $i) }}">
                                                Аккаунты покупателей
                                            </a>
                                        @endcan
                                        @can('update', $i)
                                            <a class="dropdown-item" href="{{ action('Lib\CompanyController@getUpdate', $i) }}">
                                                Изменить
                                            </a>
                                        @endcan
                                        @can('delete', $i)
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ action('Lib\CompanyController@getDelete', $i) }}">
                                                Удалить
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
