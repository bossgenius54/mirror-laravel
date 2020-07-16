
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-warning">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Форма фильтрации</h4>
            </div>
            <div class="card-body">

                @if ($msg && $msg != '')
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ $msg }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form class="form-material row" >

                    <div class="col-md-10 row">
                        <input type="hidden" name="filtered" value="true" />

                        <div class="form-group col-md-3">
                            <select name="name" class="form-control" >
                                <option value="">Наименование</option>
                                @foreach ($product_names as $id => $in)
                                    <option value="{{ $in->id }}" {{ $request->name == $in->id ? 'selected' : '' }}>{{ $in->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select name="sys_num" class="form-control" >
                                <option value="">Системный номер</option>
                                @foreach ($product_sys_num as $id => $in)
                                    <option value="{{ $in->id }}" {{ $request->sys_num == $in->id ? 'selected' : '' }}>{{ $in->sys_num }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select name="branch_id" class="form-control" >
                                <option value="">Филиал</option>
                                @foreach ($ar_branch as $id => $name)
                                    <option value="{{ $id }}" {{ $request->branch_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="expired_first">Период от</label>
                            <input type="date" class="form-control " required id="created_at_first" placeholder="Дата" name="created_at_first" value="{{ $request->created_at_first }}" >

                        </div>

                        <div class="form-group col-md-4" >
                            <label for="expired_second">Период до</label>
                            <input type="date" class="form-control " required id="created_at_second" placeholder="Дата" name="created_at_second" value="{{ $request->created_at_second }}" >
                        </div>

                        <div class="form-group col-md-3">
                            <select name="cat_id" class="form-control category-select" >
                                <option value="">Категория</option>
                                @foreach ($ar_cat as $id => $name)
                                    <option value="{{ $id }}" {{ $request->cat_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
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
