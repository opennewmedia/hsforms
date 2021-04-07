<?php
namespace ONM\Hsforms\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Usman Ahmad <ua@onm.de>, Open New Media GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/***
 *
 * This file is part of the "Suite 8 Forms" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Usman Ahmad <ua@onm.de>, Open New Media GmbH
 *
 ***/

/**
 * The repository for TravelPeriods
 */
class TravelPeriodRepository extends ParentRepository
{
    // Order by start
    protected $defaultOrderings = array(
        'start' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

        
    /**
     * initializeObject
     *
     * @return void
     */
    public function initializeObject() {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');

        // don't add the pid constraint
        $querySettings->setRespectStoragePage(FALSE);
        
        $this->setDefaultQuerySettings($querySettings);
    }
    
    /**
     * findExpired
     *
     * @return $queryobject
     */
    public function findExpired()
    {
        $query = $this->createQuery();
        $query->matching($query->lessThan('end', date("Y-m-d")));
        return $query->execute();
    }
}
