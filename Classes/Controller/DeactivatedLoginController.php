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
class DeactivatedLoginController extends \HSE\Labor\Controller\AbstractBaseController {
//class LoginController extends \HSE\Labor\Controller\AbstractBaseController {

	/**
	 * @var \TYPO3\FLOW3\Security\Authentication\AuthenticationManagerInterface
	 * @FLOW3\Inject
	 */
	protected $authenticationManager;

	/**
	 * @var \TYPO3\FLOW3\Security\AccountRepository
	 * @FLOW3\Inject
	 */
	protected $accountRepository;


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
	 * On successful authentication redirects to the status view, otherwise returns
	 * to the login screen.
	 *
	 * @return void
	 */
	public function authenticateAction() {
		$authenticated = FALSE;
		try {
			$this->authenticationManager->authenticate();
			$authenticated = TRUE;
		} catch (\Exception $exception) {
			$message = $exception->getMessage();
		}

		if ($authenticated === FALSE) {
			$this->addFlashMessage($message);
		}
		$this->redirect('index', 'module');
	}

	/**
	 * Logs out a - possibly - currently logged in account.
	 *
	 * @return void
	 */
	public function logoutAction() {
		$this->authenticationManager->logout();
		$this->addFlashMessage('Successfully logged out.');
		$this->redirect('index', 'module');
	}

	/**
	 * @return void
	 */
	public function statusAction() {
		$this->view->assign('activeTokens', $this->securityContext->getAuthenticationTokens());
	}

}
