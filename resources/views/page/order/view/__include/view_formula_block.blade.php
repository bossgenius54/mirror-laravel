@if ($formula)
    <div class="card card-outline-info"">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Рецепт на {{ $formula->type_id == App\Model\Formula::CONTACT_TYPE_ID ? 'контактные линзы' : 'очковые линзы' }} № {{ $formula->id }}. Выданный пользователю "{{ $formula->relIndivid->name }}"</h4>
        </div>
        <div class="card-body">
            <h4 class="card-title"></h4>
            
            <h5 class="card-title">Правый глаз</h5>
            <div class="row">
                <div class="form-group col-md-2">
                    <small>Сфера</small> <br/>
                    {{ $formula->l_scope }}
                </div>
                <div class="form-group col-md-2">
                    <small>Цил.</small> <br/>
                    {{ $formula->l_cil }}
                </div>
                <div class="form-group col-md-2">
                    <small>Ось</small> <br/>
                    {{ $formula->l_os }}
                </div>
                <div class="form-group col-md-2">
                </div>
                <div class="form-group col-md-2">
                    <small>Призма оси</small> <br/>
                    {{ $formula->l_prism_01 }}
                </div>
                <div class="form-group col-md-2">
                    <small>Призма оси</small> <br/>
                    {{ $formula->l_prism_02 }}
                </div>
            </div>
            <h5 class="card-title">Левый глаз</h5>
            <div class="row">
                <div class="form-group col-md-2">
                    <small>Сфера</small> <br/>
                    {{ $formula->r_scope }}
                </div>
                <div class="form-group col-md-2">
                    <small>Цил.</small> <br/>
                    {{ $formula->r_cil }}
                </div>
                <div class="form-group col-md-2">
                    <small>Ось</small> <br/>
                    {{ $formula->r_os }}
                </div>
                <div class="form-group col-md-2">
                </div>
                <div class="form-group col-md-2">
                    <small>Призма оси</small> <br/>
                    {{ $formula->r_prism_01 }}
                </div>
                <div class="form-group col-md-2">
                    <small>Призма оси</small> <br/>
                    {{ $formula->r_prism_02 }}
                </div>
            </div>
            <div class="form-group">
                @if (App\Model\Formula::CONTACT_TYPE_ID == $formula->type_id)
                    <small>Кривизна</small> <br/>
                @else
                    <small>Расстояние между центрами зрачков</small> <br/>
                @endif
                {{ $formula->len }}
            </div>
            <div class="form-group">
                <small>Назначение</small> <br/>
                {{ $formula->len }}
            </div>
            <div class="form-group">
                <small>Примечание</small> <br/>
                {{ $formula->note }}
            </div>
            <p class="card-text"><small class="text-muted pull-right">Создан {{ $formula->created_at }}, от  "{{ $formula->relCreatedUser->name }}" ({{ $formula->relCreatedUser->getClearTypeName() }})</small></p>
        </div>
    </div>
@endif