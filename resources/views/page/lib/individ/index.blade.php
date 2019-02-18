
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
                    @can('create', App\Model\View\Individ::class)
                        <a href="{{ action('Lib\IndividController@getCreate') }}" type="button" 
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
                                        @can('list', App\Model\Formula::class)
                                            <a class="dropdown-item" href="{{ action('Common\FormulaController@getIndex', ['user_id'=> $i->id]) }}">
                                                Рецепты
                                            </a>
                                        @endcan
                                        @can('update', $i)
                                            <a class="dropdown-item" href="{{ action('Lib\IndividController@getUpdate', $i) }}">
                                                Изменить
                                            </a>
                                        @endcan
                                        @can('delete', $i)
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item js_accept_change_status" href="{{ action('Lib\IndividController@getDelete', $i) }}">
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


<div class="modal fade bs-example-modal-sm" id="modal_change_status" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <form action="" class="js_change_status_form">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Окно подтверждения удаления клиента</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" style="text-align: center;">Вы уверены что хотите удалить клиента</div>
                <div class="modal-footer" style="justify-content: space-around;">
                    <button type="button" class="btn btn-default waves-effect col-md-5" data-dismiss="modal">Нет</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light col-md-5">Да</button>
                </div>
            </div>
        </div>
    </form>
</div>
                            
                      

@endsection




@section('js_block')
    <script type="text/javascript">
        $(function () {
            $('.js_accept_change_status').click(function(evt){
                evt.preventDefault();

                $('.js_change_status_form').attr('action', $(this).attr('href'))
                $('#modal_change_status').modal("show");
            })

        });
	</script>
@endsection
