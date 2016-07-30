<table class="table table-responsive" id="pages-table">
    <thead>
    <th> 
        <div class="col-md-5" >
            <div class="col-md-2" style="margin-right: 30px;margin-top: 10px">Name</div>
            {{ Form::open(['route' => ['pages.index'], 'method' => 'get','style'=>'width: 200px']) }}
            <div class="input-group ">
                <input type="text" name="search" class="form-control" placeholder="Search..."/>
            </div>
            {!! Form::close() !!}
        </div>
    </th>
    <th>Content</th>
    <th colspan="3">Action</th>
</thead>
<tbody>
    @foreach($pages as $page)
    <tr>
        <td>{!! $page->name !!}</td>
        <td>{!! $page->content !!}</td>
        <td>
            {!! Form::open(['route' => ['pages.destroy', $page->id], 'method' => 'delete']) !!}
            @can('admin',$page)
            <div class='btn-group'>
                <a href="{!! route('pages.edit', [$page->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                @endcan
                <a href="{!! route('pages.show', [$page->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
            </div>
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</tbody>
</table>