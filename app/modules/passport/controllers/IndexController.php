<?php

namespace Passport\Controllers;

use Phalcon\Crypt;

class IndexController extends \Phalcon\Mvc\Controller
{
	public function indexAction()
	{
		die('sasafsdf');
	}

	public function loginAction()
	{
		$this->view->setVars($this->config->sso->toArray());
	}

	public function checkLoginAction()
	{	
		$this->response->setStatusCode(200, 'ok');
		if(!$this->request->isPost() || !$this->security->checkToken())
		{
			$this->response->setJsonContent(['error' => $this->languageConfig->illegalRequest]);
		}
		
		//$encrypt = $this->crypt->encryptBase64('admin123');
		//$decrypt = $this->crypt->decryptBase64($encrypt);
		
		$mAdmin = new \Admin\Models\Admin();
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');
		$mAdmin->setEmail($email)->setPassword($password);
		//$hashPwd = $this->security->hash($password);
		
		//var_dump($this->security->checkHash($password, $hashPwd));

		if(!$mAdmin->validation())
		{
			return $this->response->setJsonContent($mAdmin->getMessages());
		}
		$admin = \Admin\Models\Admin::findByEmail($email);
		$admin->rewind();
		$admin = $admin->current();
		if(!$admin || !$this->security->checkHash($password, $admin->getPassword()))
		{
			return $this->response->setJsonContent([
				'error' => $this->languageConfig->notMember
			]);
		}
		$this->cookies->set('token', $admin->getId(), time() + 86400, '/', $this->request->getScheme() == 'https', 'ebizsoft.com');
		$this->redisCache->save('session_' . md5($admin->getId()), ['loginTime' => time()], 86400);
		return $this->response->setJsonContent(['token' => $key]);
	}
}
