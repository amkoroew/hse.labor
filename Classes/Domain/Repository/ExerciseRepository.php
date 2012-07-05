<?php
namespace HSE\Labor\Domain\Repository;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * A repository for Exercises
 *
 * @FLOW3\Scope("singleton")
 */
class ExerciseRepository extends \TYPO3\FLOW3\Persistence\Repository {

	/**
	 * Finds active exercises by the specified lab
	 *
	 * @param \HSE\Labor\Domain\Model\Lab $lab The lab the exercise must refer to
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface The exercises
	 */
	public function findActiveByLab(\HSE\Labor\Domain\Model\Lab $lab) {
		$query = $this->createQuery();
		return $query->matching(
		             	$query->logicalAnd(
		             		$query->equals('lab', $lab),
		             		$query->equals('active', true)
		             	)
		             )
		             ->execute();
		// add setOrderings
	}
}
