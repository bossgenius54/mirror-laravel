
@extends('layout')

@section('title', $title)

@section('content')

{{-- @include('page.stock.deletion.__include.filter') --}}

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <a href="{{ $backList }}" type="submit" class="btn btn-rounded" style="">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <h4 class="card-title">
                    {{ $title }}

                </h4>
                <div class="row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control " placeholder="Наименование" name="name" value="{{ $item->name }}" readonly>
                    </div>

                    <div class="form-group col-md-12">
                        <textarea class="form-control " placeholder="Заметки" name="note" readonly>{{ $item->note }}</textarea>
                    </div>
                </div>
            </div>

            <table class="table  table-hover color-table muted-table" >
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Ассортимент</th>
                        <th>Системный номер</th>
                        <th>Филиал</th>
                        <th>Себестоимость</th>
                        <th>Оприходование</th>
                        <th>Срок годности</th>
                        <th>Дата создания</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_sum = 0;
                    @endphp
                    @foreach ($positions as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $i->id }}</td>
                            <td>{{ $i->relProduct->name }}</td>
                            <td>{{ $i->relProduct->sys_num }}</td>
                            <td>{{ $i->relBranch->name }}</td>
                            <td>{{ $i->relPosition->price_cost }}</td>
                            <td>
                                <a href="{{ action('Stock\IncomeFromCompanyController@getView',$i->relPosition->income_id)  }}" class="text-blue"> # {{ $i->relPosition->income_id }} </a>
                            </td>
                            <td>{{ $i->relPosition->expired_at ? $i->relPosition->expired_at : 'нет срока годности' }}</td>
                            <td>{{ $i->created_at }}</td>
                        </tr>

                        @php
                            $total_sum += $i->relPosition->price_cost;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Действии
                </h4>

                @if ($item->status_id != 3 && $item->status_id != 4)
                    <a href="{{ action('Stock\DeletionController@confirm', $item) }}" class="btn btn-block btn-warning" style="margin-bottom: 10px;">
                        Подтвердить списание
                    </a>
                @endif

                @if ($item->status_id == 3)
                    <a href="#" class="btn btn-block btn-danger" data-toggle="modal" data-target="#modal_return_position" style="margin-bottom: 10px;">
                        Отменить списание
                    </a>
                @endif
            </div>

        </div>

        @include('page.stock.deletion.__include.main_info')
    </div>
</div>

<div class="modal fade bs-example-modal-sm" id="modal_return_position" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Окно подтверждения отмены списания</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" style="text-align: center;">Вы уверены что хотите вернуть позиции со списания?</div>
                <div class="modal-footer" style="justify-content: space-around;">
                    <button type="button" class="btn btn-default waves-effect col-md-5" data-dismiss="modal">Нет</button>
                    <a href="{{ action('Stock\DeletionController@return', $item) }}" class="btn btn-success waves-effect waves-light col-md-5">Да</a>
                </div>
            </div>
        </div>
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
