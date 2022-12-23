<?php 
namespace app\models;
use app\core\Model;
use app\core\Application;

class RegisterModel extends Model
{
	public string $firstname = '';
	public string $lastname = '';
	public string $email = '';
	public string $password = '';
	public string $confirmPassword = '';

	public function register()
	{
		 Application::$app->session->setFlash("success","Thanks for registering");
		 Application::$app->response->redirect('/');
	
	}
	public function labels():array
	{
		return [
			'firstname' => 'Your name',
			'lastname' => 'Last Name',
			'email' => 'Your email',
			'password' => 'Password',
			'confirmPassword' => 'Confirm Password'
		];
	}

	public function rules():array
	{
		
		return [
			'firstname' =>[self::RULE_REQUIRED],
			'lastname' =>[self::RULE_REQUIRED],
			'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
			'password' => [
				self::RULE_REQUIRED, 
				[self::RULE_MIN,
			    'min' => 8],
			    [self::RULE_MAX, 
			    'max' => 24
			    ]
			],
			'confirmPassword' => [self::RULE_REQUIRED,
				[self::RULE_MATCH, 'match'=> 'password']]
		];
	}
	
}