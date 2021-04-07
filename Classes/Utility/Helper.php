<?php
namespace ONM\Hsforms\Utility;
use TYPO3\CMS\Backend\Utility\BackendUtility;

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
/**
 * Helper
 */
class Helper
{

    /**
     * getDays
     * its only to decode 7 checkboxes into an array with 0 or 1 means checked or not
     * @param  int $dbVal
     *
     * @return array
     */
    public static function getDays($dbVal)
    {
        $days = decbin($dbVal);
        $days = sprintf('%07d', $days);
        $days = str_split($days);
        $days = array_reverse($days);
        // shifting to Mo,Tu,We,Th,Fr,Sa,Su from Su,Mo,Tu,We,Th,Fr,Sa
        array_unshift($days, $days[6]);
        unset($days[7]);
        return $days;
    }

    /**
     * customTravelPeriodTitle makes custom title for travelperiod TCA like startdate - enddate - internal name
     *
     * @param  mixed $parameters
     *
     * @return void
     */
    public function customTravelPeriodTitle(&$parameters)
    {
        $record = BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']);
        $start = new \DateTime();
        $start->setTimestamp($record['start']);
        $end = new \DateTime();
        $end->setTimestamp($record['end']);
        $internalName = $record['internal_name'];
        $newTitle = $start->format('d-m-Y'). '  -  '.$end->format('d-m-Y');
        $newTitle .= ($internalName) ? '  -  '.$internalName : '';
        $now = new \DateTime();
        if($end < $now) {
            $newTitle .= ' (Expired)';
        }
        $parameters['title'] = $newTitle;
    }
}
