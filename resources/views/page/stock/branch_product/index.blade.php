
@extends('layout')

@section('title', $title)

@section('content')
@include($filter_block)

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
                        <th>Продукция</th>
                        <th>Филиал</th>
                        <th>Кол-во на складе</th>
                        <th>Нужно на складе</th>
                        <th>Кол-во докупить</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i)
                        @php 
                            $class_css = $loop->index % 2 === 0 ? 'footable-odd'  : 'footable-even';
                        @endphp
                        <tr class=" {{ $class_css }}" >
                            <td rowspan="{{ count($ar_branch) + 1 }} ">{{ $i->name }} ({{ $i->sys_num }})</td>
                            
                        </tr>
                        @foreach ($ar_branch as $id=>$name) 
                            @php 
                                $count_pos = $i->relPositions()->where('branch_id', $id)->where('status_id', App\Model\SysPositionStatus::ACTIVE)->count();
                            @endphp
                            <tr  class=" {{ $class_css }}">
                                <td >{{ $name }})</td>
                                <td>{{ $count_pos }}</td>
                                <td>{{ $i->min_stock_count }}</td>
                                <td>{{ ($count_pos - $i->min_stock_count) >= 0 ? 'не нужно' :  -($count_pos - $i->min_stock_count) }}</td>
                            </tr>
                        @endforeach
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
