<?php
//Login based on:
//http://programming-tips.in/zend-framework-2-login-with-zend-auth/
namespace Application\Controller;
 
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\LoginForm;
use Application\Form\Filter\LoginFilter;
use Application\Model\UserPassword;

class LoginController extends AbstractActionController {
	
	protected $storage;
	protected $authservice;
	
	public function indexAction(){       
		
		$request = $this->getRequest();
		
		$view = new ViewModel();
		$loginForm = new LoginForm('loginForm');       
		$loginForm->setInputFilter(new LoginFilter());
		
		if($request->isPost()){
			$data = $request->getPost();
			$loginForm->setData($data);
			
			if($loginForm->isValid()){            	
				$data = $loginForm->getData();        

				$userPassword = new UserPassword();
				$encyptPass = $userPassword->create($data['password']);
				
				$this->getAuthService()
				     ->getAdapter()
				     ->setIdentity($data['username'])
				     ->setCredential($encyptPass);
				$result = $this->getAuthService()->authenticate();
				
				if ($result->isValid()) {
					
					$session = new Container('User');
					$session->offsetSet('username', $data['username']);
					
					$this->flashMessenger()->addMessage(array('success' => 'Login Success.'));
					return $this->redirect()->tourl('/');
					// Redirect to page after successful login
				}else{
					$this->flashMessenger()->addMessage(array('error' => 'invalid credentials.'));
					// Redirect to page after login failure
				}
				return $this->redirect()->tourl('/application/login');
				// Logic for login authentication                
			}else{
				$errors = $loginForm->getMessages();
				//prx($errors);  
			}
		}        
		
		$view->setVariable('loginForm', $loginForm);
		return $view;
	}
	
	private function getAuthService()
	{
		if (! $this->authservice) {
			$this->authservice = $this->getServiceLocator()->get('AuthService');
		}
		return $this->authservice;
	}
	
	public function createAction()
	{
		return $this->redirect()->tourl('/application/create');
	}

	public function logoutAction(){
		$session = new Container('User');
		$session->getManager()->destroy();
		$this->getAuthService()->clearIdentity();
		return $this->redirect()->toUrl('/application/login');
	}
}
?>	