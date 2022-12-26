<?php 

namespace app\controllers;

use app\core\Controller; 
use app\core\Request; 
use app\core\Response; 
use app\core\Application; 
use app\models\RegisterModel;
use app\models\LoginForm;
use app\models\User;
use app\models\Profile;
use app\core\middlewares\AuthMiddleware;


class AuthController extends Controller
{

	public function __construct()
	{	
		$this->registerMiddleware(new AuthMiddleware(['profile']));
	}
	

	public function login(Request $request, Response $response)
    {   
    	$loginForm = new LoginForm();
        if($request->isPost()){
            $loginForm->loadData($request->getBody());
            if($loginForm->validate() && $loginForm->login()){
                $response->redirect('/');
                Application::$app->login();
                return;
            }
        }
        $this->setLayout('auth');
        return $this->render('login',[
            'model' => $loginForm
        ]);
    }

	public function update(Request $request, Response $response)
	{
		$profileForm = new Profile();
		if($request->isPost()){
			$profileForm->loadData($request->getBody());
			if($profileForm->validate() && $profileForm->update()){
				Application::$app->session->setFlash("success","Thanks for Updating.");
				$response->redirect('/');
				return;
			}
			return $this->render('profile', ['model' => $profileForm]);
		}
		return $this->render('profile',[
            'model' => $profileForm
        ]);
	}

	public function register(Request $request)
	{	
		$errors = [];
		$user = new User;
		$registerModel = new RegisterModel();
		if($request->isPost()){
			$registerModel->loadData($request->getBody());
			if($registerModel->validate() && $registerModel->register()){
				return "success";
			}
			$firstname = $user->firstname;
			$firstname = $request->getBody()['firstname'];
			$user->loadData($request->getBody());

			if($user->validate() && $user->save()){

				Application::$app->session->setFlash("success","Thanks for registering");
				Application::$app->response->redirect('/');
				exit;
			}
			return $this->render('register', ['model' => $registerModel]);
		}
		$this->setLayout('auth');
		return $this->render('register', [
			'model' => $registerModel]);
	}



    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile()
    {
    	return $this->render('profile');
    }
}