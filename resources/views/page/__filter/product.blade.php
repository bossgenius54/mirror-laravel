
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-warning">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Форма фильтрации</h4>
            </div>
            <div class="card-body">
                <form class="form-material row" >

                    <div class="col-md-10 row">

                        <div class="form-group col-md-4">
                            <select name="name" class="form-control" >
                                <option value="">Наименование</option>
                                @foreach ($filter_names as $pr)
                                    <option value="{{ $pr->name }}" {{ $request->name == $pr->name ? 'selected' : '' }}>{{ $pr->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control " placeholder="Системный номер" name="sys_num" value="{{ $request->sys_num }}" >
                        </div>
                        <div class="form-group col-md-3">
                            <select name="cat_id" class="form-control category-select" >
                                <option value="">Категория</option>
                                @foreach ($ar_cat as $id => $name)
                                    <option value="{{ $id }}" {{ $request->cat_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12 product-option">

                            @foreach($p_options as $po)

                                <div class="collapse " id="p-option-{{$po->id}}" >
                                    <h5>Выберите опции</h5>
                                    <hr/>
                                    <div class="card card-body">
                                        @if( $po->relProductOptions->count() == 0 )
                                            У данной категории товара отсутствуют опции
                                        @endif

                                        @php
                                            $last_opt_type_id = 0;
                                            $first = true;
                                        @endphp

                                        @foreach($po->relProductOptions as $option)

                                            @if( $last_opt_type_id != $option->type_id && $first == false )
                                                <hr/>
                                                </div>
                                                @php
                                                    $first = true;
                                                @endphp
                                            @endif

                                            @if( $option->type_id != $last_opt_type_id && $first == true)

                                                <div class="form-group">
                                                    <h6>{{$option->label}}</h6>

                                                @php
                                                    $first = false;
                                                @endphp

                                            @endif

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="option[]" id="option-{{$option->id}}" value="{{$option->id}}" {{ $request->option != null ? ( in_array($option->id, $request->option) ? 'checked=true' : '' ) : '' }} >
                                                <label class="form-check-label" for="option-{{$option->id}}">{{$option->option_name}}</label>
                                            </div>


                                            @php
                                                $last_opt_type_id = $option->type_id;
                                            @endphp

                                        @endforeach

                                        @if( $po->relProductOptions->count() > 0 )
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>

                    <div class="form-group col-md-2">
                        <button class="btn btn-warning btn-block" type="submit">Отфильтровать</button>
                        <a href="#" class="btn btn-warning btn-block reset">Сбросить</a> <!-- Функционал сброса расположен в JS block в index странице -->
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@section('js_block')
    <script type="text/javascript">
        $(function () {
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
