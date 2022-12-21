<?php 

namespace app\models;

use app\core\Model;
use app\core\Application;
use app\models\User;

class LoginForm extends Model 
{	
	public string $email = '';
	public string $password = '';
	public function rules():array
	{
		return [
			'email' =>[self::RULE_REQUIRED, self::RULE_MATCH],
			'password' => [self::RULE_REQUIRED]
		];	
	}

	public function labels():array
	{
		return [
			'email' => 'Your email',
			'password' => 'Password'
		];
	}

	public function login()
	{	
		$user = User::findOne(['email'=>$this->email]);
		if(!$user){
			$this->addErrorForRule('email','User dos not exitst with this email');
			return false;
		}
		if(!password_verify($this->password, $user->password)){
			$this->addError("password", "Password is incorrect");
			return false;
		}
		Application::$app->login($user);
	}
}