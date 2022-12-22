<?php 
/** @var $this \app\core\Viwe */
$this->title = "Login";
 ?>

<h1>Login</h1>
<?php use \app\core\form\Form; ?>
<?php $form =  \app\core\form\Form::begin('','post'); ?>
  
<?php echo $form->field($model, 'email');?>
<?php echo $form->field($model, 'password')->passwordField(); ?>

  <button type="submit" class="btn btn-primary">Submit</button>

<?php echo \app\core\form\Form::end(); ?>
