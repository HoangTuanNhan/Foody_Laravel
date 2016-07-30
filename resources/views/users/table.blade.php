<table class="table table-responsive" id="users-table">
    <thead>
    <th>
        <div class="col-md-5" >
            <div class="col-md-2" style="margin-right: 30px;margin-top: 10px">Name</div>
            {{ Form::open(['route' => ['users.index'], 'method' => 'get','style'=>'width: 200px']) }}
            <div class="input-group ">

                <input type="text" name="search" class="form-control" placeholder="Search..."/>
            </div>
            {!! Form::close() !!}
        </div>
    </th>

    <th>Email</th>

    <th>Is Admin</th>
    <th colspan="3">Action</th>
</thead>
<tbody>
    @foreach($users as $user)
    <tr>
        <td>{!! $user->name !!}</td>

        <td>{!! $user->email !!}</td>

        <td>
            @if ($user->is_admin == 1)
            admin
            @else
            user
            @endif
        </td>
        <td>
            {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
            <div class='btn-group'>
                 @can('admin', $user)
                
                <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                @endcan
                <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
            </div>
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</tbody>
</table>