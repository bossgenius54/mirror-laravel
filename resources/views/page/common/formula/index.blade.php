
@extends('layout')

@section('title', $title)

@section('content')

@include('page.__filter.formula')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}
                    @can('create', App\Model\Formula::class)
                        @if ($request->user_id)
                            <a href="{{ action('Common\FormulaController@getCreate', $request->user_id) }}" type="button"
                                class="btn btn-sm btn-info btn-rounded pull-right" >
                                Создать рецепт на очковые линзы
                            </a>
                            <a href="{{ action('Common\FormulaController@getCreate', $request->user_id) }}?type_id={{ $contact_type_id }}" type="button"
                                class="btn btn-sm btn-info btn-rounded pull-right" >
                                Создать рецепт на контактные линзы
                            </a>
                        @endif
                    @endcan
                </h4>
            </div>


        </div>
    </div>
    @foreach ($items as $i)
        <div class="col-md-6">
            <div class="card card-outline-info"">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Рецепт на {{ $i->type_id == $contact_type_id ? 'контактные линзы' : 'очковые линзы' }} № {{ $i->id }}. Выданный пользователю "{{ $i->relIndivid->name }}"</h4>
                </div>
                <div class="card-body">
                    <h4 class="card-title"></h4>

                    <h5 class="card-title">Правый глаз</h5>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <small>Сфера</small> <br/>
                            <input type="text" class="form-control " value="{{ $i->l_scope }}" disabled >
                        </div>
                        <div class="form-group col-md-2">
                            <small>Цил.</small> <br/>
                            <input type="text" class="form-control " value="{{ $i->l_cil }}" disabled >
                        </div>
                        <div class="form-group col-md-2">
                            <small>Ось</small> <br/>
                            <input type="text" class="form-control " value="{{ $i->l_os }}" disabled >
                        </div>
                        <div class="form-group col-md-2">
                        </div>
                        <div class="form-group col-md-2">
                            <small>Призма оси</small> <br/>
                            <input type="text" class="form-control " value="{{ $i->l_prism_01 }}" disabled >
                        </div>
                        <div class="form-group col-md-2">
                            <small>Призма оси</small> <br/>
                            <input type="text" class="form-control " value="{{ $i->l_prism_02 }}" disabled >
                        </div>
                    </div>
                    <h5 class="card-title">Левый глаз</h5>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <small>Сфера</small> <br/>
                            <input type="text" class="form-control " value="{{ $i->r_scope }}" disabled >
                        </div>
                        <div class="form-group col-md-2">
                            <small>Цил.</small> <br/>
                            <input type="text" class="form-control " value="{{ $i->r_cil }}" disabled >
                        </div>
                        <div class="form-group col-md-2">
                            <small>Ось</small> <br/>
                            <input type="text" class="form-control " value="{{ $i->r_os }}" disabled >
                        </div>
                        <div class="form-group col-md-2">
                        </div>
                        <div class="form-group col-md-2">
                            <small>Призма оси</small> <br/>
                            <input type="text" class="form-control " value="{{ $i->r_prism_01 }}" disabled >
                        </div>
                        <div class="form-group col-md-2">
                            <small>Призма оси</small> <br/>
                            <input type="text" class="form-control " value="{{ $i->r_prism_02 }}" disabled >
                        </div>
                    </div>
                    <div class="form-group">
                        @if ($i->type_id == $contact_type_id)
                            <small>Кривизна</small> <br/>
                        @else
                            <small>Расстояние между центрами зрачков</small> <br/>
                        @endif
                        <input type="text" class="form-control "  value="{{ $i->len }}" disabled >
                    </div>
                    <div class="form-group">
                        <small>Назначение</small> <br/>
                        <input type="text" class="form-control " value="{{ $i->purpose }}" disabled >
                    </div>
                    <div class="form-group">
                        <small>Примечание</small> <br/>
                        <input type="text" class="form-control" value="{{ $i->note }}" disabled >
                    </div>
                    <p class="card-text"><small class="text-muted pull-right">Создан {{ $i->created_at }}, от  "{{ $i->relCreatedUser->name }}" ({{ $i->relCreatedUser->getClearTypeName() }})</small></p>

                </div>

                <div class="card-footer">
                    @if ($request->user_id)
                        @can('update', $i)
                            <a class="btn btn-warning" href="{{ action('Common\FormulaController@getUpdate', [$request->user_id, $i]) }}">
                                Изменить
                            </a>
                        @endcan
                    @endif
                    @can('delete', $i)
                        <a class="btn btn-danger pull-right"  href="{{ action('Common\FormulaController@getDelete', $i) }}">
                            Удалить
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    @endforeach
    {!! $items->appends($request->all())->links() !!}
</div>
@endsection
