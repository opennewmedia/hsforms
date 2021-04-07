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
 * Reisezeitraum
 */
class TravelPeriod extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * start
     *
     * @var \DateTime
     */
    protected $start = NULL;

    /**
     * end
     *
     * @var \DateTime
     */
    protected $end = NULL;

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * name
     *
     * @var int
     */
    protected $daysallowed = '';

    /**
     * internalName
     *
     * @var string
     */
    protected $internalName = '';

    /**
     * @param $start
     * @param $end
     */
    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Returns the start
     *
     * @return \DateTime $start
     */
    public function getStart()
    {
        $today = new \DateTime('now');
        if(strtotime($this->start->format('d-m-Y')) < strtotime($today->format('d-m-Y'))) {
            return $today;
        }
        return $this->start;
    }

    /**
     * Sets the start
     *
     * @param \DateTime $start
     * @return void
     */
    public function setStart(\DateTime $start)
    {
        $this->start = $start;
    }

    /**
     * Returns the end
     *
     * @return \DateTime $end
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Sets the end
     *
     * @param \DateTime $end
     * @return void
     */
    public function setEnd(\DateTime $end)
    {
        $this->end = $end;
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
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

    /**
     * Get name
     *
     * @return  int
     */
    public function getDaysallowed()
    {
        return $this->daysallowed;
    }

    /**
     * Set name
     *
     * @param  int  $daysallowed  name
     *
     * @return  self
     */
    public function setDaysallowed(int $daysallowed)
    {
        $this->daysallowed = $daysallowed;

        return $this;
    }
}
