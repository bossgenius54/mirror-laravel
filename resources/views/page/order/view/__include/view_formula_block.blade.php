@if ($formula)
    <div class="card card-outline-info"">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Рецепт № {{ $formula->id }}. Выданный пользователю "{{ $formula->relIndivid->name }}"</h4>
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
                <small>Расстояние между центрами зрачков</small> <br/>
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
            <p class="card-text"><small class="text-muted pull-right">Создан {{ $formula->created_at }}, от врача "{{ $formula->relCreatedUser->name }}"</small></p>
        </div>
    </div>
@endif