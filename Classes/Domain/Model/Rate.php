<?php
namespace ONM\Hsforms\Domain\Model;

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
 * Rate / Preis
 */
class Rate extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * code
     *
     * @var string
     */
    protected $code = '';

    /**
     * internalName
     *
     * @var string
     */
    protected $internalName = '';

    /**
     * Returns the code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the code
     *
     * @param string $code
     * @return void
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Returns the internalName
     *
     * @return string $internalName
     */
    public function getInternalName()
    {
        return $this->internalName;
    }

    /**
     * Sets the internalName
     *
     * @param string $internalName
     * @return void
     */
    public function setInternalName($internalName)
    {
        $this->internalName = $internalName;
    }
}
