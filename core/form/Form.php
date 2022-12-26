<?php 

namespace app\core\form;
use app\core\Model;
use app\core\form\InputField;

class Form
{
    public static function begin($action, $method, $options = [])
    {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        echo sprintf('<form action="%s" enctype="multipart/form-data" method="%s" %s>', $action, $method, implode(" ", $attributes));
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }

    public function profileField(Model $model, $attribute)
    {
        return new ProfileField($model, $attribute);
    }

}