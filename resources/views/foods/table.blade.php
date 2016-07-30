<table class="table table-responsive" id="foods-table">
    <thead>
    <th>
         <div class="col-md-5" >
            <div class="col-md-2" style="margin-right: 30px;margin-top: 10px">Name</div>
            {{ Form::open(['route' => ['foods.index'], 'method' => 'get','style'=>'width: 200px']) }}
            <div class="input-group ">
                <input type="text" name="search" class="form-control" placeholder="Search..."/>
            </div>
            {!! Form::close() !!}
        </div>
    </th>
        <th>Image</th>
        <th>Category Id</th>
        <th>Content</th>
        <th>Author</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($foods as $food)
        <tr>
            <td>{!! $food->name !!}</td>
            <td><img src="{!! URL::to('/uploads/'.$food->image) !!}" alt="some_text" style="width:100px;height:100px " ></td>
            <td>{!! $food->category->name!!}</td>
            <td>{!! $food->content !!}</td>
            <td>{!! $food->user->name !!}</td>
            <td>
                {!! Form::open(['route' => ['foods.destroy', $food->id], 'method' => 'delete']) !!}
                @can('admin',$food)
                <div class='btn-group'>
                    <a href="{!! route('foods.edit', [$food->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                 @endcan
                  <a href="{!! route('foods.show', [$food->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>