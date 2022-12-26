<?php 
/** @var $this \app\core\Viwe */
/** @var $model \app\models\ContactForm */
use app\core\form\TextareaField;
$this->title = "Contact";

 ?>

<h1>Contact us</h1>


<?php use \app\core\form\Form; ?>
<?php $form = Form::begin('','post'); ?>
<?php echo $form->field($model, 'subject');?>
<?php echo $form->field($model, 'email');?>
<?php echo new TextareaField($model, 'body')?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php echo Form::end(); ?>