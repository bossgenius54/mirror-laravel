@extends('layout')

@section('title', $title)

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}
                </h4>
                <form action="" class="form-material " method="get" >
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" name='user_name' class="form-control" placeholder="По имени пользователя" value="{{ $request->user_name }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name='user_id' class="form-control" placeholder="По номеру пользователя" value="{{ $request->user_id }}">
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <button type="submit" class="btn btn-block bg-blue">Применить</button>
                        </div>
                    </div>
                </form>
                
            </div>

           
            <table class="table  table-hover color-table muted-table ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Имя пользователя</th>
                        <th>Номер пользователя</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}">
                            <td>{{ $i->id }}</td>
                            <td>{{ $i->relUser->name }}</td>
                            <td>{{ $i->user_id }}</td>
                            <td>{{ $i->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            {!! $items->appends($request->all())->links() !!}
                        </td>
                    </tr>
                </tfoot>
            </table>
		</div>
	</div>
</div>


@endsection