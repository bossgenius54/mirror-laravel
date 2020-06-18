
@extends('layout')

@section('title', $title)

@section('content')

{{-- @include('page.stock.deletion.__include.filter') --}}

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
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
                        <th>Системный номер</th>
                        <th>Сумма</th>
                        <th>Срок годности</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($positions as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $i->id }}</td>
                            <td>{{ $i->relProduct->name }}</td>
                            <td>{{ $i->relProduct->price_retail }}</td>
                            <td>{{ $i->relPosition->expired_at }}</td>
                            <td></td>
                        </tr>
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
                    <a href="{{ action('Stock\DeletionController@confirm', $item) }}" class="btn btn-block btn-secondary" style="margin-bottom: 10px;">
                        Подтвердить списание
                    </a>
                @endif

                @if ($item->status_id == 3)
                    <a href="#" class="btn btn-block btn-secondary" style="margin-bottom: 10px;">
                        Вернуть со списания
                    </a>
                @endif
            </div>

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
