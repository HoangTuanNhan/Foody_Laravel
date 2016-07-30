<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $user->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $user->name !!}</p>
</div>

<!-- Avatar Field -->
<div class="form-group">
    {!! Form::label('avatar', 'Avatar:') !!}
    <p><img src="{!! URL::to('/uploads/'.$user->avatar) !!}" alt="some_text" style="width:100px;height:100px " ></p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $user->email !!}</p>
</div>

<!-- Password Field -->


<!-- Is Admin Field -->
<div class="form-group">
    {!! Form::label('is_admin', 'Is Admin:') !!}
    <p>{!! $user->is_admin !!}</p>
</div>

<!-- Created At Field -->


