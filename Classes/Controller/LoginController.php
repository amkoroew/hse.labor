<?php
namespace HSE\Labor\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Login controller for the HSE.Labor package 
 *
 * @FLOW3\Scope("singleton")
 */
class LoginController extends \HSE\Labor\Controller\AbstractBaseController {
//class LoginController extends \TYPO3\FLOW3\Security\Authentication\Controller\AuthenticationController {

	/**
	 * @FLOW3\Inject
	 * @var \TYPO3\FLOW3\Security\Authentication\AuthenticationManagerInterface
	 */
	protected $authenticationManager;

	/**
	 * Default action, displays the login screen
	 *
	 * @param string $username Optional: A username to prefill into the username field
	 * @return void
	 */
	public function indexAction($username = NULL) {
		$this->view->assign('username', $username);
	}

	/**
         * Authenticates an account by invoking the Provider based Authentication Manager.
         *
         * @return void
         * @throws \TYPO3\FLOW3\Security\Exception\AuthenticationRequiredException
         */
        public function authenticateAction() {
                try {
                        $this->authenticationManager->authenticate();
                        $this->redirect('index', 'Module');
                } catch (\TYPO3\FLOW3\Security\Exception\AuthenticationRequiredException $exception) {
                        $this->addFlashMessage('Wrong username or password.');
                        throw $exception;
                }
        }

        /**
         *
         * @return void
         */
        public function logoutAction() {
                $this->authenticationManager->logout();
                $this->addFlashMessage('Successfully logged out.');
                $this->redirect('index', 'Module');
        }
}
