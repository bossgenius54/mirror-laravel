
@extends('layout')

@section('title', $title)

@section('content')

@include('page.stock.deletion.__include.filter')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}

                    <a href="#" type="button" class="btn btn-info btn-rounded pull-right send-btn" style="margin-right:15px;">
                        Далее
                    </a>

                    <span class="pull-right" style="color:blue; margin-right: 20px; line-height:40px;">
                        Выбрано -
                        <input type="number" class="count form-control" value="0" style="display: inline-block;width:100px;" /> шт
                        из {{ $items ? $items->count() : '0' }}
                    </span>
                </h4>

                <div class="form-check form-check-inline">
                    <input class="select-all" type="checkbox" id="select-all" value="all" >
                    <label for="select-all">Выбрать все</label>
                </div>
            </div>

            <table class="table  table-hover color-table muted-table" >
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ассортимент</th>
                        <th>Системный номер</th>
                        <th>Филиал</th>
                        <th>Статус</th>
                        <th>Себестоимость</th>
                        <th>Срок годности</th>
                        <th>Создан</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $loop->index + 1 }}</td>
                            <td title="id: {{ $i->id }}" data-toggle="tooltip" data-placement="top">{{ $i->relProduct->name }}</td>
                            <td>{{ $i->relProduct->sys_num }}</td>
                            <td>{{ isset($ar_branch[$i->branch_id]) ? $ar_branch[$i->branch_id] : 'не указано' }}</td>
                            <td>{{ $i->relStatus->name }}</td>
                            <td>{{ $i->price_cost }}</td>
                            <td>{{ $i->expired_at ? $i->expired_at : 'бессрочна' }}</td>
                            <td>{{ $i->created_at }}</td>
                            <td>
                                <div class="form-check form-check-inline"
                                title="{{ $i->status_id == $motion_id ? ('Завершите перемещение № '.$i->motion_id) : ($i->status_id == $reserve_id ? ('Зарезервирован в заказе № '.$i->order_id) : '') }}"
                                data-toggle="tooltip" data-placement="top" >
                                    <input class="form-check-input-positions"
                                            type="checkbox" id="{{$i->id}}"
                                            name="position_id[]"
                                            {{ $request->position_ids ? (in_array($i->id, $request->position_ids) ? 'checked' : '') : '' }}
                                            value="{{ $i->id }}"
                                            {{ $i->status_id == $motion_id ? 'disabled' : ($i->status_id == $reserve_id ? 'disabled':'') }}>
                                    <label for="{{$i->id}}">Добавить</label>
                                </div>
                            </td>
                        </tr>

                    @empty
                        @if ($request->filtered != 'true')
                            <tr>
                                <td colspan="9" class="text-center text-danger">Для списания примените параметры фильтра</td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="9"  class="text-center text-info">Элементов нет</td>
                            </tr>
                        @endif

                    @endforelse
                </tbody>
            </table>

            <form action="{{ $confirm_action }}" method="POST" class="confirm">
                @csrf

            </form>
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

            let selected = [];
            $('.form-check-input-positions').change(function() {
                if(this.checked) {
                    selected.push(this.value);
                    // alert(this.value);
                } else {
                    selected = selected.filter( item => item != this.value )
                }

                $('.count').val(selected.length);
            });

            $('.select-all').change(function() {

                let inputs = $('.form-check-input-positions');

                if(this.checked) {

                    inputs.each(function () {

                        if ( $(this).prop('checked') == false && $(this).prop('disabled') != true ){
                            selected.push($(this).val());
                            $(this).prop('checked', true);
                        }

                    });

                } else {
                    inputs.prop('checked', false);

                    selected = [];
                }

                $('.count').val(selected.length);
            });

            $('.send-btn').on('click', function() {
                let form = $('.confirm');

                if (selected.length < 1){

                    let inputs = $('.form-check-input-positions');

                    inputs.each(function () {

                        if ( $(this).prop('checked') == true && $(this).prop('disabled') != true ){
                            selected.push($(this).val());
                        }

                    });

                }

                selected.forEach(function(id) {
                    console.log(id);

                    $('<input>').attr({
                        type: 'hidden',
                        id: id,
                        value: id,
                        name: 'position_ids[]'
                    }).appendTo(form);
                });

                form.submit();

            });

            $('.count').change(function(){
                let countRequest = parseInt($(this).val());
                let countIsset = selected.length;
                let countNeed = (countIsset - countRequest) > 0  ? ( countIsset - countRequest ) : ( countRequest -countIsset );
                let inputs = $('.form-check-input-positions');
                console.log(countNeed);

                inputs.prop('checked', false);
                selected = [];
                let i;

                countRequest = countRequest > inputs.length ? inputs.length : countRequest;

                inputs.each(function () {

                    if ( $(this).prop('checked') == false && $(this).prop('disabled') != true && countRequest != 0 ){
                        $('#'+$(this).val()).prop('checked', true);
                        selected.push($(this).val());
                        countRequest -= 1;
                    }

                });

                $(this).val(selected.length);
                console.log(selected);

            });

        });
	</script>
@endsection
