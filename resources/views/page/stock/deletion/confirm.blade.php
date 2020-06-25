
@extends('layout')

@section('title', $title)

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ $back }}" method="GET">

                    @foreach ($items as $j)
                        <input type="hidden" checked name="position_ids[]" value="{{ $j->id }}" >
                    @endforeach

                    <button type="submit" class="btn btn-rounded" style="">
                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z" />
                        </svg>
                    </button>
                </form>

                <form action="{{ $post_create }}" method="POST" class="delete_form">
                    <div class="" style="margin-top: 15px;">
                        <h4 class="card-title">
                            {{ $title }}
                        </h4>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control deletion-name" placeholder="Наименование" name="name" value="" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-5">
                                <textarea class="form-control " placeholder="Заметки" name="note"></textarea>
                            </div>
                        </div>

                        <a href="#" type="button" class="btn btn-danger btn-rounded pull-right send-btn" style="margin-right:15px;">
                            Списать
                        </a>

                        <span class="pull-right" style="color:blue; margin-right: 20px; line-height:40px;">
                            Выбрано - <span class="count">{{$items->count()}}</span> шт
                        </span>


                        <table class="table  table-hover color-table muted-table" >
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Ассортимент</th>
                                    <th>Системный номер</th>
                                    <th>Филиал</th>
                                    <th>Себестоимость</th>
                                    <th>Срок годности</th>
                                    <th>Создан</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $i)
                                    <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                                        <td>{{ $i->id }}</td>
                                        <td>{{ $i->relProduct->name }}</td>
                                        <td>{{ $i->relProduct->sys_num }}</td>
                                        <td>{{ $i->relBranch->name }}</td>
                                        <td>{{ $i->price_cost }}</td>
                                        <td>{{ $i->expired_at ? $i->expired_at : 'бессрочна' }}</td>
                                        <td>{{ $i->created_at }}</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" checked id="position-{{$i->id}}" name="position_id[]" value="{{ $i->id }}" >
                                                <label for="position-{{$i->id}}">Добавить</label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
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

            let selected = [
                @foreach ($items as $i)
                    {{$i->id}},
                @endforeach
            ];

            $('.form-check-input').change(function() {
                if(this.checked) {
                    selected.push(this.value);
                    // alert(this.value);
                } else {
                    selected = selected.filter( item => item != this.value )
                }

                console.log(selected);
                $('.count').html(selected.length);
            });

            $('.send-btn').on('click',function(){
                let form = $('.delete_form');

                let name = $('.deletion-name').val();

                if(name == ''){
                    alert('Заполните поле "Наименование "');
                    return false;
                }

                form.submit();
            });

        });
	</script>
@endsection
