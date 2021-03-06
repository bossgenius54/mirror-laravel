
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

                    @can('delete', App\Model\Deletion::class)
                        <a href="{{ action('Stock\DeletionController@getCreate') }}" type="button" class="btn btn-danger pull-right">
                            Списать товары
                        </a>
                    @endcan

                    @can('list', App\Model\Deletion::class)
                        <a href="{{ action('Stock\DeletionController@getIndex') }}" type="button" class="btn btn-info pull-right" style="margin-right:15px;">
                            Список списанных партии
                        </a>
                    @endcan

                </h4>

            </div>

            <table class="table  table-hover color-table muted-table" >
                <thead>
                    <tr>
                        <th>Ассортимент</th>
                        <th>Филиал</th>
                        <th>Статус</th>
                        <th>Себестоимость</th>
                        <th>Срок годности</th>
                        <th>Оприхование</th>
                        <th>Изменен</th>
                        <th>Создан</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $i->relProduct->name }} ({{ $i->relProduct->sys_num }})</td>
                            <td>{{ isset($ar_branch[$i->branch_id]) ? $ar_branch[$i->branch_id] : 'не указано' }}</td>
                            <td>{{ isset($ar_status[$i->status_id]) ? $ar_status[$i->status_id] : 'не указано' }}</td>
                            <td>{{ $i->price_cost }}</td>
                            <td>{{ $i->expired_at ? $i->expired_at : 'бессрочна' }}</td>
                            <td>{{ $i->relIncome ? $i->relIncome->note.' #'.$i->relIncome->id : 'не указано' }}</td>
                            <td>{{ $i->updated_at }}</td>
                            <td>{{ $i->created_at }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('update', $i)
                                            <a class="dropdown-item" href="{{ action('Stock\PositionController@getUpdate', $i) }}">
                                                Изменить
                                            </a>
                                        @endcan
                                        @can('delete', $i)
                                            <a class="dropdown-item js_accept_change_status" href="{{ action('Stock\PositionController@getDelete', $i) }}">
                                                Списать
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
                    <h4 class="modal-title" id="mySmallModalLabel">Окно подтверждения списания позиции</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" style="text-align: center;">Вы уверены что хотите списать позиции?</div>
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
            });

            // reseting func of filter
            $('.reset').on('click', function(e){
                e.preventDefault();
                console.log('clearing a filter ---');
                $('input').val('');
                $('select').children('option').attr('selected', false);
                $('select').children('option').first().attr('selected',true);
                $('.filter-checkbox').prop('checked', false);

                $('form').submit();
            });

            var lastOpenedOption = 0;
            $('.category-select').on('select2:select', function(e) {

                $('.filter-checkbox').prop('checked', false);
                $('#p-option-'+lastOpenedOption).toggle();
                $('#p-option-'+e.params.data.id).toggle();
                lastOpenedOption = e.params.data.id;
            });

            $(document).ready(function(){
                let category = $('.category-select').val();

                lastOpenedOption = category;
                $('#p-option-'+category).toggle();
            });

        });
	</script>
@endsection
