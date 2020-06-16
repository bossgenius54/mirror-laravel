
@extends('layout')

@section('title', $title)

@section('content')

@include('page.order.view.__include.position_filter')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}
                </h4>
                <button class="btn btn-primary btn-circle btn-xl basket-button" style="position: fixed; bottom: 20px; right: 20px;" data-toggle="modal" data-target="#modal_total_positions" >
                    <span class="count " style="position: absolute;top: -6px;display: block;right: -2px;background: red;border-radius: 50px;width: 25px;font-size: 0.8em;">
                        0
                    </span>
                    <svg class="bi bi-basket-fill" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.071 1.243a.5.5 0 0 1 .858.514L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 6h1.717L5.07 1.243zM3.5 10.5a.5.5 0 0 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 0 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 0 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 0 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 0 0-1 0v3a.5.5 0 0 0 1 0v-3z"/>
                    </svg>
                </button>
            </div>

            <div class="table-responsive text-center">
                <table class="table  table-hover color-table muted-table" >
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Ассортимент</th>
                            <th>Системный номер</th>
                            <th>Стоимость <br/> Розница </th>
                            <th>Стоимость <br/> Оптовая</th>
                            <th>Срок годности</th>
                            <th>Выбор</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $i)
                            <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                                <td>{{ $i->id }}</td>
                                <td>{{ $i->relProduct->name }}</td>
                                <td>{{ $i->relProduct->sys_num }}</td>
                                <td>{{ $i->relProduct->price_retail }}</td>
                                <td>{{ $i->relProduct->price_opt }}</td>
                                <td>{{ $i->expired_at != null ? $i->expired_at : 'нет срока годности' }}</td>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="position-{{$i->id}}" name="position_id[]" value="{{ $i->id }}" >
                                        <label for="position-{{$i->id}}">Добавить</label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal fade bs-example-modal-sm" id="modal_total_positions" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">

                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Оформить позиции</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>

                            <div class="modal-body" style="text-align: center;">
                                <div class="table-responsive text-center">
                                    <form method="POST" action="{{$addBasket}}" class="add-basket">
                                        <table class="table  table-hover color-table muted-table" >
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Ассортимент</th>
                                                    <th>Системный номер</th>
                                                    <th>Стоимость <br/> Розница </th>
                                                    <th>Стоимость <br/> Оптовая</th>
                                                    <th>Срок годности</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="modal-tbody">
                                                <tr>
                                                    <td colspan="7">Пусто</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>

                            <div class="modal-footer" style="justify-content: space-around;">
                                <button type="button" class="btn btn-default waves-effect col-md-5" data-dismiss="modal">Закрыть</button>
                                <button type="submit" class="btn btn-success waves-effect waves-light col-md-5 basket-button-send">Добавить в заказ</button>
                            </div>
                        </div>
                    </div>

            </div>

        </div>
    </div>
</div>
@endsection


@section('js_block')
    <script type="text/javascript">
        $(function () {

            var json_str = getCookie('basket');
            var cookie = json_str.length > 0 ? JSON.parse(json_str) : [] ;
            console.log(cookie);
            var basket = cookie || [] ;
            console.log(basket);

            $('.count').html(basket.length);

            $(document).on('click','.form-check-input', function(){
                let val = parseInt($(this).attr('value'));
                let find = basket.filter( i => i == val );

                if ( find.length > 0 ) {
                    console.log('unselected');
                    basket = basket.filter( i => i != val );
                } else {
                    console.log('selected');
                    basket.push(val);
                }

                console.log(basket);
                document.cookie = encodeURIComponent('basket') + '=' + JSON.stringify(basket);
                $('.count').html(basket.length);

                console.log(val);
            });

            $('.basket-button').on('click', function(){
                getItemsForBasket();
            });

            $('.add-basket').on('submit', function(){
            });

            $('.basket-button-send').on('click', function(){
                console.log('hello baby');


                $('.add-basket').submit();

                document.cookie = encodeURIComponent('basket') + '=' + JSON.stringify([]);
            });

            function getCookie(c_name) {
                if (document.cookie.length > 0) {
                    c_start = document.cookie.indexOf(c_name + "=");
                    if (c_start != -1) {
                        c_start = c_start + c_name.length + 1;
                        c_end = document.cookie.indexOf(";", c_start);
                        if (c_end == -1) {
                            c_end = document.cookie.length;
                        }
                        return unescape(document.cookie.substring(c_start, c_end));
                    }
                }
                return "";
            }

            function getItemsForBasket() {
                $.ajax({
                    method: 'POST',
                    data: {'ids': basket},
                    url: "{{ $get_position_action }}",
                    success: function(data) {
                        let items = data.items;
                        console.log(items);
                        $('.modal-tbody').html('');

                        items.forEach(element => {
                            $('.modal-tbody').append('<tr> <td>'+ element.id +'</td> <td>'+ element.rel_product.name +'</td> <td>'+ element.rel_product.sys_num +'</td> <td>'+ element.rel_product.price_retail +' тг.</td> <td>'+ element.rel_product.price_opt +' тг.</td> <td>'+ element.expired_at +' </td> <td><div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" checked="true" id="position-sec-'+element.id+'" name="position_id[]" value="'+element.id+'" ><label for="position-sec-'+element.id+'" >Добавить</label> </div></td> </tr>');
                        });
                    },
                    error: function() {
                        $('.modal-tbody').html('');
                        $('.modal-tbody').append('<tr> <td colspan="6">Не получилось получить данные</td> </tr>');
                    }
                });
            }
        });
	</script>
@endsection
