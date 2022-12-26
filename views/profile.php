<?php 
/** @var $this \app\core\Viwe */
$this->title = "Profile";
 ?>
<?php use \app\core\form\Form; 
/** @var $model \app\models\User **/ 

?>
<h1>Update Your info</h1>
<?php $form = Form::begin('','post'); ?>
  <div class="row">
    <div class="col">
      <?php echo $form->ProfileField($model, 'firstname'); ?>
      
    </div>
    <div class="col">
      <?php echo $form->ProfileField($model, 'lastname'); ?>
      
    </div>
  </div>
<?php echo $form->ProfileField($model, 'email'); ?>
<?php echo $form->ProfileField($model, 'image')->imageField(); ?>
<label for="password">Password</label>
<input type="password" class="form-control" name="password">
  <button type="submit" class="btn btn-primary">Submit</button>

<?php echo \app\core\form\Form::end(); ?>

<img src="img" alt="">