<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;
use Zend\Authentication\AuthenticationServiceInterface;
use ZfcUser\Options\UserControllerOptionsInterface;
use ZfcUser\Service\User as UserService;
use Zend\Http\Response;
use Zend\Stdlib\Parameters;
use Vpbxui\PbxSettings\Model\PbxSettingsTableInterface;
use Vpbxui\PbxSettings\Model\PbxSettings;
use Zend\Db\Sql\Ddl\Column\Varchar;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image as CaptchaImage;

class RegisterPbxController extends AbstractActionController
{
	const ROUTE_LOGIN        = 'zfcuser/login';
	const ROUTE_REGISTER     = 'vpbxui/registerpbx';
	
	const CONTROLLER_NAME    = 'zfcuser';
	
	protected $userForm;
	protected $userService;
	protected $options;
	protected $pbxSettingsTable;
	protected $redirect;
	
	public function __construct(
			FormInterface $userForm, 
			UserService $userService, 
			UserControllerOptionsInterface $options,
			PbxSettingsTableInterface $pbxSettingsTable
			)
	{
		$this->userForm = $userForm;	
		$this->userService = $userService;
		$this->options = $options;
		$this->pbxSettingsTable = $pbxSettingsTable;
	}
	public function indexAction()
	{
		$form = $this->userForm;
 		$form->get('display_name')->setLabel('Имя пользователя');
		$form->get('password')->setLabel('Пароль');
		$form->get('passwordVerify')->setLabel('Подтверждение пароля');
		
		$form->get('email')->setLabel('Адрес электронной почты');
		$form->get('submit')->setlabel('создать');
		
		$dirdata = './data';
		
		//pass captcha image options
		$captchaImage = new CaptchaImage(  array(
		    'font' => $dirdata . '/fonts/arial.ttf',
		    'width' => 250,
		    'height' => 100,
		    'dotNoiseLevel' => 40,
		    'lineNoiseLevel' => 3)
		);
		$captchaImage->setImgDir($dirdata.'/captcha');
		$captchaImage->setImgUrl('/captcha');
		
		$form->add(array(
		    'type' => 'Zend\Form\Element\Captcha',
		    'name' => 'captcha',
		    'options' => array(
		        'label' => 'символы на картинке',
		        'captcha' => $captchaImage,
		    ),
		));
		
        
		if ($this->zfcUserAuthentication()->hasIdentity()) {
			return $this->redirect()->toRoute($this->options->getLoginRedirectRoute());
		}

		$request = $this->getRequest();
		$service = $this->userService;
		
		if ($this->options->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirect')) {
			$redirect = $request->getQuery()->get('redirect');
		} else {
			$redirect = false;
		}
		
		$redirectUrl = $this->url()->fromRoute(static::ROUTE_REGISTER)
		. ($redirect ? '?redirect=' . rawurlencode($redirect) : '');
		$prg = $this->prg($redirectUrl, true);
		
		if ($prg instanceof Response) {
			return $prg;
		} elseif ($prg === false) {
			return array(
					'registerForm' => $form,
					'enableRegistration' => $this->options->getEnableRegistration(),
					'redirect' => $redirect,
			);
		}
		
		$post = $prg;
		$user = $service->register($post);		
		
		$redirect = isset($prg['redirect']) ? $prg['redirect'] : null;
		
		if (!$user) {
			return array(
					'registerForm' => $form,
					'enableRegistration' => $this->options->getEnableRegistration(),
					'redirect' => $redirect,
			);
		}
		$pbxSettings = new PbxSettings();
		$data = array('callcentre_status_override'=>'default');
		$pbxSettings->exchangeArray($data);
		
		$lastId = $this->pbxSettingsTable->savePbxSettings($pbxSettings);		
		$user->setVpbxid($lastId);
		
		$userFinal = $this->userService->getUserMapper()->findByEmail($user->getEmail());
		$user->setId($userFinal->getId());
		$this->userService->getUserMapper()->update($user);
		$events = $this->getEventManager();
		
 	 	if ($this->options->getLoginAfterRegistration()) {
			$identityFields = $this->options->getAuthIdentityFields();
			if (in_array('email', $identityFields)) {
				$post['identity'] = $user->getEmail();
			} elseif (in_array('username', $identityFields)) {
				$post['identity'] = $user->getUsername();
			}
			$post['credential'] = $post['password'];
			$request->setPost(new Parameters($post));
			
			
			$authresponse = $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'authenticate'));
			$results = $events->trigger('register.preDispatch', $this);
			if ($results->stopped()) {
			    foreach ($results as $result)
			    {
			        	
			        if ($result instanceof Response)
			        {
			            return $result;
			        }
			    }
			}
			return $authresponse;	
		}
		
	 
		
		return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LOGIN) . ($redirect ? '?redirect='. rawurlencode($redirect) : ''));		
	}
}