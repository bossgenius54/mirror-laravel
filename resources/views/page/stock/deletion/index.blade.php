
@extends('layout')

@section('title', $title)

@section('content')

{{-- @include('page.stock.deletion.__include.filter') --}}

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}

                </h4>
            </div>

            <table class="table  table-hover color-table muted-table" >
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Наименование (Заметка)</th>
                        <th>Статус</th>
                        <th>Кол-во товаров</th>
                        <th>Общая сумма</th>
                        <th>Дата списания</th>
                        <th>Создатель</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)

                        @php
                            $total_sum = 0;
                            foreach($i->relDeletePosition as $p){
                                $total_sum += $p->relPosition->price_cost;
                            }
                        @endphp

                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $i->id }}</td>
                            <td>{{ $i->name }} {{ $i->note ? ('('.$i->note.')') : '' }}</td>
                            <td>{{ $i->relStatus->name }}</td>
                            <td>{{ $i->relDeletePosition->count() }}</td>
                            <td>{{ $total_sum }}</td>
                            <td>{{ $i->created_at }}</td>
                            <td>{{ $i->relCreatedUser->name }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('list', $i)
                                            <a class="dropdown-item" href="{{ action('Stock\DeletionController@getView', $i) }}">
                                                Посмотреть списанные позиции
                                            </a>
                                        @endcan
                                        @if ($i->status_id == App\Model\DeletionStatus::IN_WORK)
                                            @can('delete', $i)
                                                <a class="dropdown-item js_accept_change_status" href="{{ action('Stock\DeletionController@confirm', $i) }}">
                                                    Подтвердить
                                                </a>
                                            @endcan
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
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

                $('form').submit();
            });

            var lastOpenedOption = 0;
            $('.category-select').on('select2:select', function(e) {
                console.log(e.params.data.id);
                console.log(lastOpenedOption);
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
