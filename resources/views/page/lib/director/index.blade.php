
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}  
                    @can('create', App\Model\View\Director::class)
                        <a href="{{ action('Lib\DirectorController@getCreate') }}" type="button" 
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
                        <th>Компания</th>
                        <th>ИИН</th>
                        <th>ФИО</th>
                        <th>Почтовый адрес</th>
                        <th>Телефон</th>
                        <th>Изменен</th>
                        <th>Создан</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $i->id }}</td>
                            <td>{{ isset($ar_company[$i->company_id]) ? $ar_company[$i->company_id] : 'не указано' }}</td>
                            <td>{{ $i->iin }}</td>
                            <td>{{ $i->name }}</td>
                            <td>{{ $i->email }}</td>
                            <td>{{ $i->phone }}</td>
                            <td>{{ $i->updated_at }}</td>
                            <td>{{ $i->created_at }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('update', $i)
                                            <a class="dropdown-item" href="{{ action('Lib\DirectorController@getUpdate', $i) }}">
                                                Изменить
                                            </a>
                                        @endcan
                                        @can('delete', $i)
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ action('Lib\DirectorController@getDelete', $i) }}">
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
