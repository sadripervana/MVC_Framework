<?php 

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\models\LoginForm;
use app\models\ContactForm;


class SiteController extends Controller
{   
    public function login(Request $request, Response $response)
    {   $loginForm = new LoginForm();
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

    public  function home()
    {   
        $params = [
            'name' => 'sadri'
        ];
        return $this->render('home', $params);
    }

    public function contact(Request $request, Response $response)
    {   
        $contact = new ContactForm();
        if($request->isPost()){
            $contact->loadData($request->getBody());
            if($contact->validate() && $contact->send()){
                Application::$app->session->setFlash("success","Thanks for contacting us.");
                return $response->redirect('/');
            }
        }
        return $this->render('contact',[
            'model' => $contact
        ]);
    }

    public function register(Request $request)
    {   
        $errors = [];
        $user = new User();
        if($request->isPost()){
            $user->loadData($request->getBody());

            if($user->validate() && $user->save()){

                Application::$app->session->setFlash("success","Thanks for registering");
                Application::$app->response->redirect('/');
                exit;
            }
            return $this->render('register', ['model' => $user]);
        }
        $this->setLayout('auth');
        return $this->render('register', ['model' => $user]);
    }
}