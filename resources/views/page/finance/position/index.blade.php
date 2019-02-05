
@extends('layout')

@section('title', $title)

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $title }}  
                </h4>
            </div>
            
            <table class="table  table-hover color-table muted-table" >
                <thead>
                    <tr>
                        <th>Филиал</th>
                        <th>Продукция</th>
                        <th>До</th>
                        <th>После</th>
                        <th>Сумма</th>
                        <th>Создан</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $i->relBranch ? $i->relBranch->name : '' }}</td>
                            <td>{{ $i->relProduct ? $i->relProduct->name : '' }}</td>
                            <td>{{ $i->price_before }}</td>
                            <td>{{ $i->price_after }}</td>
                            <td>{{ $i->price_total }}</td>
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
