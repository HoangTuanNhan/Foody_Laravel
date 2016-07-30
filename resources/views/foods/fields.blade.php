<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="clearfix"></div>
<!-- Image Field -->
<div class="form-group col-sm-6">
    <?php
    $image = isset($food->image) ? '/uploads/' . $food->image : '/uploads/' . "no-image.png";
    ?>
    
    {!! Html::image(url($image), 'a picture', array('id' => 'view-image','class'=>'img-large')) !!}
    <br/>
    {!! Form::label('image', 'Image:') !!}
    {!! Form::file('image') !!}

</div>
<div class="clearfix"></div>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category Id:') !!}
    {!! Form::select('category_id', isset($categories) ? $categories : null , null, ['class' => 'form-control']) !!}
</div>
<div class="clearfix"></div>
<!-- Content Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('content', 'Content:') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control ckeditor']) !!}
</div>
<div class="clearfix"></div>
<!-- Author Field -->
<div class="form-group col-sm-6">

    {!! Form::label('author', 'Author:') !!}
    {!! Form::select('author', isset($users)? $users : null, null, ['class' => 'form-control']) !!}

</div>
<div class="clearfix"></div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('foods.index') !!}" class="btn btn-default">Cancel</a>
</div>
