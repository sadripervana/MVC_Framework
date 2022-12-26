<?php 

namespace app\core\form;
use app\core\Application;
use app\core\Model;
use app\models\User;

class ProfileField extends BaseField
{
    const TYPE_TEXT = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_FILE = 'file';
    

    /**
     * Field constructor.
     *
     * @param \thecodeholic\phpmvc\Model $model
     * @param string          $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    public function renderInput():string
    {   
        $user = User::findOne(['email'=>Application::$app->user->email()]);
        return sprintf('<input type="%s" class="form-control%s" name="%s" value="%s">',
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $user->{$this->attribute},
        );
    }

    public function imageField()
    {   
        $this->type = self::TYPE_FILE;
        return $this;
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function fileField()
    {
        $this->type = self::TYPE_FILE;
        return $this;
    }
}