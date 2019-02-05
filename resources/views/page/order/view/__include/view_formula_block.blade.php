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
                    <input type="text" class="form-control " value="{{ $formula->l_scope }}" disabled > 
                </div>
                <div class="form-group col-md-2">
                    <small>Цил.</small> <br/>
                    <input type="text" class="form-control " value="{{ $formula->l_cil }}" disabled > 
                </div>
                <div class="form-group col-md-2">
                    <small>Ось</small> <br/>
                    <input type="text" class="form-control " value="{{ $formula->l_os }}" disabled > 
                </div>
                <div class="form-group col-md-2">
                </div>
                <div class="form-group col-md-2">
                    <small>Призма оси</small> <br/>
                    <input type="text" class="form-control " value="{{ $formula->l_prism_01 }}" disabled > 
                </div>
                <div class="form-group col-md-2">
                    <small>Призма оси</small> <br/>
                    <input type="text" class="form-control " value="{{ $formula->l_prism_02 }}" disabled > 
                </div>
            </div>
            <h5 class="card-title">Левый глаз</h5>
            <div class="row">
                <div class="form-group col-md-2">
                    <small>Сфера</small> <br/>
                    <input type="text" class="form-control " value="{{ $formula->r_scope }}" disabled > 
                </div>
                <div class="form-group col-md-2">
                    <small>Цил.</small> <br/>
                    <input type="text" class="form-control " value="{{ $formula->r_cil }}" disabled > 
                </div>
                <div class="form-group col-md-2">
                    <small>Ось</small> <br/>
                    <input type="text" class="form-control " value="{{ $formula->r_os }}" disabled > 
                </div>
                <div class="form-group col-md-2">
                </div>
                <div class="form-group col-md-2">
                    <small>Призма оси</small> <br/>
                    <input type="text" class="form-control " value="{{ $formula->r_prism_01 }}" disabled > 
                </div>
                <div class="form-group col-md-2">
                    <small>Призма оси</small> <br/>
                    <input type="text" class="form-control " value="{{ $formula->r_prism_02 }}" disabled > 
                </div>
            </div>
            <div class="form-group">
                <small>Расстояние между центрами зрачков</small> <br/>
                <input type="text" class="form-control "  value="{{ $formula->len }}" disabled > 
            </div>
            <div class="form-group">
                <small>Назначение</small> <br/>
                <input type="text" class="form-control " value="{{ $formula->purpose }}" disabled > 
            </div>
            <div class="form-group">
                <small>Примечание</small> <br/>
                <input type="text" class="form-control" value="{{ $formula->note }}" disabled > 
            </div>
            <p class="card-text"><small class="text-muted pull-right">Создан {{ $formula->created_at }}, от врача "{{ $formula->relCreatedUser->name }}"</small></p>
        </div>
    </div>
@endif