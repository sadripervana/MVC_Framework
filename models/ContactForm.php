<?php 

namespace app\models;
use app\core\Application;
use app\core\Model;

class ContactForm extends Model
{
	public string $subject = '';
	public string $email = '';
	public string $body = '';

	public function rules():array
	{
		return [
			'subject' => [self::RULE_REQUIRED],
			'email' => [self::RULE_REQUIRED],
			'body' => [self::RULE_REQUIRED],
		];
	}

	public function labels():array
	{
		return [
			'subject' => "Enter your subject",
			'email' => "Enter your email",
			'body' => "Body",
		];		
	}

	public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

	public  static function tableName():string
	{
		return 'contactus';
	}
	
	public function attributes():array
	{
		return ['subject', 'email', 'body'];		
	}

	public function send()
	{	
		$tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")");
		echo "<pre>";
				var_dump($statement);
		echo "</pre>";
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
	}
}