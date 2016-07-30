<table class="table table-responsive" id="categories-table">
    <thead>
    <th>ID</th>
    <th>
        <div class="col-md-5" >
            <div class="col-md-2" style="margin-right: 30px;margin-top: 10px">Name</div>
            {{ Form::open(['route' => ['categories.index'], 'method' => 'get','style'=>'width: 200px']) }}
            <div class="input-group ">
                <input type="text" name="search" class="form-control" placeholder="Search..."/>
            </div>
            {!! Form::close() !!}
        </div>
    </th>
    <th>Image</th>
    <th colspan="3">Action</th>
</thead>
<tbody>
    @foreach($categories as $category)
    <tr>
        <td>{{ $category->id }}</td>
        <td>{{ $category->name }}</td>
        <td><img src="{!! URL::to('/uploads/'.$category->image) !!}" alt="some_text" style="width:100px;height:100px " ></td>
        <td>

            {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete']) !!}
            <div class='btn-group'>
                @can('admin', $category)

                <a href="{!! route('categories.edit', [$category->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                @endcan
                <a href="{!! route('categories.show', [$category->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
            </div>
            {!! Form::close() !!}

        </td>
    </tr>
    @endforeach
</tbody>
</table>