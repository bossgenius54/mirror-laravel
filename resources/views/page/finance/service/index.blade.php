
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
                        <th>Услуга</th>
                        <th>Цена ед.</th>
                        <th>Кол-во</th>
                        <th>Сумма</th>
                        <th>Создан</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)
                        <tr class=" {{ $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even' }}" >
                            <td>{{ $i->relBranch ? $i->relBranch->name : '' }}</td>
                            <td>{{ $i->relService ? $i->relService->name : '' }}</td>
                            <td>{{ $i->service_cost }}</td>
                            <td>{{ $i->service_count }}</td>
                            <td>{{ $i->total_sum }}</td>
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
