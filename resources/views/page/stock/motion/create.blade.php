
@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">{{ $title }}</h4>
            </div>
            <div class="card-body">
                <form class="form-material" action="{{ $action }}" method="post"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Наименование</label>
                        <input type="text" class="form-control " name="name" > 
                    </div>
                    <div class="form-group">
                        <label>От филиала</label>
                        @can('create', App\Model\Motion::class)
                            <select name="from_branch_id" class="form-control" required>
                                @foreach ($ar_branch_from as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        @endcan

                    </div>
                    <div class="form-group">
                        <label>К филиалу </label>
                        <select name="to_branh_id" class="form-control" required>
                            @foreach ($ar_branch_to as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-info pull-right" type="submit">Сохранить</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection