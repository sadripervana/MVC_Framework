<?php 
/** @var $this \app\core\Viwe */
$this->title = "Register";
 ?>
<?php use \app\core\form\Form; 
/** @var $model \app\models\User **/ 
?>
<h1>Create an account</h1>
<?php $form = Form::begin('','post'); ?>
  <div class="row">
    <div class="col">
      <?php echo $form->field($model, 'firstname'); ?>
      
    </div>
    <div class="col">
      <?php echo $form->field($model, 'lastname'); ?>
      
    </div>
  </div>
<?php echo $form->field($model, 'email'); ?>
<?php echo $form->field($model, 'password')->passwordField(); ?>
<?php echo $form->field($model, 'confirmPassword')->passwordField(); ?>

  <button type="submit" class="btn btn-primary">Submit</button>

<?php echo \app\core\form\Form::end(); ?>
