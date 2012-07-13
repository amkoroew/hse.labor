<?php
namespace HSE\Labor\Security\Authentication\Provider;

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * LDAP Authentication provider
 *
 * @FLOW3\Scope("prototype")
 */
class LDAPProviderParty extends \TYPO3\LDAP\Security\Authentication\Provider\LDAPProvider {

	/**
	 * @FLOW3\Inject
	 * @var \TYPO3\Party\Domain\Repository\PartyRepository
	 */
	protected $partyRepository;

	/**
	 * @FLOW3\Inject
	 * @var \HSE\Labor\Domain\Repository\StudentRepository
	 */
	protected $studentRepository;

	/**
	 * @FLOW3\Inject
	 * @var \HSE\Labor\Domain\Repository\ModuleRepository
	 */
	protected $moduleRepository;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * Inject the settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Create a new party for a user's first login
	 * Extend this Provider class and implement this method to create a party
	 *
	 * @param \TYPO3\FLOW3\Security\Account $account The freshly created account that should be used for this party
	 * @param array $ldapSearchResult The first result returned by ldap_search
	 * @return void
	 * @throws \TYPO3\FLOW3\Error\Exception
	 */
	protected function createParty(\TYPO3\FLOW3\Security\Account $account, array $ldapSearchResult) {
		if (isset($this->settings['gid']['admin'])) {
			$admingid = $this->settings['gid']['admin'];
		} else {
			throw new \TYPO3\FLOW3\Error\Exception('No gid for the administrator given.');
		}
		$gids = $ldapSearchResult['gidnumber'];
		unset($gids['count']);
		$firstName = $ldapSearchResult['givenname'][0];
		$lastName = $ldapSearchResult['sn'][0];
		$personName = new \TYPO3\Party\Domain\Model\PersonName('', $firstName, '', $lastName);

		$party = NULL;
		if(in_array($admingid, $gids)) {
			$party = new \TYPO3\Party\Domain\Model\Person();
			$role = new \TYPO3\FLOW3\Security\Policy\Role('Administrator');
		} else {
			$party = new \HSE\Labor\Domain\Model\Student();
			$role = new \TYPO3\FLOW3\Security\Policy\Role('Student');
			$party->generateExercises($this->moduleRepository->findAll());
		}

		$party->setName($personName);
		$account->addRole($role);
		$account->setParty($party);
		$this->partyRepository->add($party);
	}

}
