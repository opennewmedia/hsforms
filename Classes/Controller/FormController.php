<?php
namespace ONM\Hsforms\Controller;
use \ONM\Hsforms\Utility\Helper;
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility as LU;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
use ONM\Hsforms\Utility\HotelsuiteApi;
use \TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

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
 * FormController
 */
class FormController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
    /**
	 * whether or not the applicant has agreed to the privacy agreement
	 *
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
    protected $cObj;

    /**
	 *
	 * @var \ONM\Hsforms\Domain\Repository\TravelPeriodRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
    protected $travelPeriodRepository;

    /**
	 *
	 * @var \ONM\Hsforms\Domain\Repository\SegmentRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
    protected $segmentRepository;

    /**
	 *
	 * @var \ONM\Hsforms\Domain\Repository\RateRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
    protected $rateRepository;

    /**
     * initializeAction
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->cObj = $this->configurationManager->getContentObject();

        /** @var $logger \TYPO3\CMS\Core\Log\Logger */
        $this->logger = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Log\LogManager::class)->getLogger(__CLASS__);
    }

    /**
     * action expiredtp
     *
     * @return void
     */
    public function expiredAction()
    {
        // all bookers where all travel periods are expired
        $bookers = [];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content')->createQueryBuilder();
        $statement = $queryBuilder
            ->select('*')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('hsforms_form'))
            )
            ->execute();
        while ($row = $statement->fetch()) {
            if($row['tx_hsforms_form_travelperiods']) {
                /** @var $extbaseObjectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
                $extbaseObjectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
                /** @var $travelPeriodRepository \ONM\Hsforms\Domain\Repository\TravelPeriodRepository */
                $travelPeriodRepository = $extbaseObjectManager->get('ONM\Hsforms\Domain\Repository\TravelPeriodRepository');
                $travelPeriods = $travelPeriodRepository->findByUids(explode(',', $row['tx_hsforms_form_travelperiods']));
                $redNotice = true;
                $today = new \DateTime('now');
                foreach($travelPeriods as $tp) {
                    if(strtotime($tp->getEnd()->format('d-m-Y')) >= strtotime($today->format('d-m-Y'))) {
                        $redNotice = false;
                    }
                }
                if($redNotice) {
                    $bookers[] = $row;
                }
            }
        }
        $this->view->assign('bookers', $bookers);

        // all expired travel periods
        $travelPeriods = $this->travelPeriodRepository->findExpired();
        $this->view->assign('travelPeriods', $travelPeriods);
    }

    /**
     * action getAvailabilityColors
     *
     * @return void
     */
    public function getAvailabilityColorsAction()
    {
        $dateString = GeneralUtility::_GP('dateString');
        $colors = [];
        if ($dateString) {
            $startDate = \DateTime::createFromFormat("Y-m-d", $dateString);
        } else {
            $startDate = new \DateTime();
        }
        $startDate = $startDate->modify("first day of this month");
        $endDate = clone $startDate;
        $endDate->modify("last day of this month");
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('hsforms');
        // fetch data from API when API is enabled from ext config
        if($extensionConfiguration['enableAPI']) {
            $api = new HotelsuiteApi();
            $colors = $api->fetch('/web-availability-color?start=' . $startDate->format("Y-m-d") . '&end=' . $endDate->format("Y-m-d"));
        }
        $this->view->assign('result', $colors);
    }

    /**
     * action index
     *
     * @return void
     */
    public function indexAction()
    {
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('hsforms');
        // fetch data from API when API is enabled from ext config
        if($extensionConfiguration['enableAPI']) {
            $api = new HotelsuiteApi();

            // grab legends data only when is allowed from the backend
            if(!$this->cObj->data['tx_hsforms_form_legends_flag']) {
                $colorsConfig = json_decode($api->fetch('/web-availability-color-config'));
                if(is_array($colorsConfig->_embedded->web_availability_color_config)) {
                    $this->view->assign('colorConfig', $colorsConfig->_embedded->web_availability_color_config[0]);
                }
            }
        }
        // changes the template based on the custom template field in the backend
        if($this->cObj->data['tx_hsforms_form_customtemplate']) {
            $absTemplatePath = GeneralUtility::getFileAbsFileName($this->cObj->data['tx_hsforms_form_customtemplate']);
            if(file_exists($absTemplatePath)) {
                $this->view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName($this->cObj->data['tx_hsforms_form_customtemplate']));
            } else {
                $this->logger->info('Custom template is not found in hsforms so using default template.');
            }
        }

        $linkedDataFields = ['travelperiods'=>'travelPeriodRepository', 'segments'=>'segmentRepository', 'rates'=>'rateRepository'];
        $linkedData = [];
        $extensionName = 'hsforms';
        foreach($linkedDataFields as $linkedDataField => $linkedDataRepo) {
            $Ids = explode(',',$this->cObj->data['tx_hsforms_form_' . $linkedDataField]);
            $linkedData[$linkedDataField] = $this->{$linkedDataRepo}->findByUids($Ids);
        }

        if (sizeof($linkedData['travelperiods']->toArray()) > 0) {
            $tps = [];
            $today = new \DateTime('now');
            $bufferMinLengthOfStay = ($this->cObj->data["tx_hsforms_form_buffer_flag"]) ? '0' : $this->cObj->data['tx_hsforms_form_minnights'];
            foreach($linkedData['travelperiods'] as $tp) {
                $tp->setEnd($tp->getEnd()->add(\DateInterval::createfromdatestring($bufferMinLengthOfStay . ' day')));
                $today->add(\DateInterval::createfromdatestring($bufferMinLengthOfStay . ' day'));
                if(strtotime($tp->getEnd()->format('d-m-Y')) >= strtotime($today->format('d-m-Y'))) {
                    if($tp->getStart()->diff($tp->getEnd())->days >= $this->cObj->data['tx_hsforms_form_minnights']) {
                        if($tp->getDaysallowed() == 127) {
                            $tps[] = $tp;
                        } elseif($tp->getDaysallowed() != 0) {
                            // break tp into multiple weekly tps
                            $tps = array_merge($tps, $this->breakItWeekly($tp, $this->cObj->data['tx_hsforms_form_minnights']));
                        }
                    }
                }
            }
            $linkedData['travelperiods'] = $tps;
        }
        // managing travel periods
        $sizeOfTravelPeriodsList = (is_array($linkedData['travelperiods'])) ? sizeof($linkedData['travelperiods']) : sizeof($linkedData['travelperiods']->toArray());

        if ($sizeOfTravelPeriodsList == 0) {
            // Start date with daysfromnow
            $start = (new \DateTime())->add(\DateInterval::createfromdatestring('+' . $this->cObj->data["tx_hsforms_form_daysfromnow"] . ' day'));
            $end = (new \DateTime())->add(\DateInterval::createfromdatestring($this->cObj->data["tx_hsforms_form_daystillend"] . ' day'));
            $lastBooking = $this->cObj->data["tx_hsforms_form_lastbookingdate"];
            $lastBookingDate = \DateTime::createFromFormat("Y-m-d", $lastBooking, new \DateTimeZone('Europe/Berlin'));
            if($lastBooking) {
                $lastBookingDateObject = new \DateTime($lastBooking);
            } else {
                $lastBookingDateObject = new \DateTime();
                $lastBookingDateObject->add(\DateInterval::createFromDateString('yesterday'));
            }

            if ($start < $lastBookingDateObject) {
                $end = min($end, $lastBookingDateObject);
            }
            $linkedData['travelperiods'] = [ new \ONM\Hsforms\Domain\Model\TravelPeriod($start, $end) ];
        }


        // fields names
        $fields = ['ibelink','view','btnlabel', 'modaltitle','text','cssclasses','promocode', 'layout'];
        // min-max fields
        $minMaxFields = ['persons','adults','children','nights','rooms'];

        // flag fields show hide
        $flagFields = ['promocode','rate','segment', 'legends', 'addrooms'];
        foreach($flagFields as $field) {
            $this->view->assign($field . '_flag', $this->cObj->data['tx_hsforms_form_' . $field . '_flag']);
        }

        // assigning fields to view
        foreach($fields as $field) {
            $this->view->assign($field, $this->cObj->data['tx_hsforms_form_' . $field]);
        }
        $config = [];
        foreach($minMaxFields as $field) {
            $this->view->assign('min' . $field, $this->cObj->data['tx_hsforms_form_min' . $field]);
            $this->view->assign('max' . $field, $this->cObj->data['tx_hsforms_form_max' . $field]);
            $config['min' . $field] = $this->cObj->data['tx_hsforms_form_min' . $field];
            $config['max' . $field] = $this->cObj->data['tx_hsforms_form_max' . $field];
        }

        // default values for adults and children
        $defaultValues = ['adults', 'children'];
        foreach($defaultValues as $field) {
            $this->view->assign('def' . $field, $this->cObj->data['tx_hsforms_form_def' . $field]);
        }

        // grabbing day values from checkboxes in the backend
        $days = Helper::getDays($this->cObj->data['tx_hsforms_form_daysallowed']);
        $hsformsLanguageFilePrefix = 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:';
        foreach($days as $day){
            $key = 'tt_content.tx_hsforms_form_daysallowed.' . ++$a;
            if($day) $coursedays .= LU::translate($hsformsLanguageFilePrefix.$key, $extensionName) . '/';
        }

        //grabbing params from ibelink if any
        if(strpos($this->cObj->data['tx_hsforms_form_ibelink'], '?')) {
            $queryString = explode('?', $this->cObj->data['tx_hsforms_form_ibelink'])[1];
            $parameters = explode('&', $queryString);
            foreach($parameters as $param) {
                $keyVal = explode('=', $param);
                if(sizeof($keyVal) == 1) {
                    $keyVal[1] = $keyVal[0];
                }
                $params[$keyVal[0]] = $keyVal[1];
            }
            $this->view->assign('urlParams', $params);
        }

        // assigning days allowed from localland and days as 0,1 array
        $this->view->assign('daysallowed',$coursedays);
        $this->view->assign('days',$days);

        // sending ext config to view
        $this->view->assign("extConfig", GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('hsforms'));

        // sending uid
        $this->view->assign("uid", $this->cObj->data['uid']);

        // sending linked data like travel periods, segments and rate
        $this->view->assign('linkedData', $linkedData);

        // default segment data
        $this->view->assign('defaultSegment', ['title'=>LU::translate('defaultSegment.title', $extensionName), 'image'=>$this->settings['view']['defaultSegmentImage']]);

        // sending ts config
        $this->view->assign('settings', $this->settings);

        // keepParams settings
        $this->view->assign('keepParams', $this->cObj->data['tx_hsforms_form_keepparams']);

        // allowedParams
        $this->view->assign('allowedParams', $this->cObj->data['tx_hsforms_form_allowedparams']);

        // enableAPI
        $this->view->assign('enableAPI', $extensionConfiguration['enableAPI']);

        // config for js
        $this->view->assign('jsconfig', $config);
    }

    /**
     * this func will break tp to multiple travel periods based on days allowed every week
     *
     * @param  \ONM\Hsforms\Domain\Model\TravelPeriod $tp
     * @return array
     */
    protected function breakItWeekly($tp, $minLOS)
    {
        $tps = [];
        $days = Helper::getDays($tp->getDaysallowed());
        array_push($days, $days[0]);
        array_shift($days);
        // now we have $days like array of 0,1 in this scheme of days Mo, Tu, We, Th, Fr, Sa, Su
        $offset = array_search(1, $days);
        $offset_end = array_search(1, array_reverse($days, true));
        $startDate = clone $tp->getStart();
        $endDate = clone $tp->getEnd();
        $today = new \DateTime();
        while ($startDate < $endDate) {
            $weekStartDate = new \DateTime();
            $weekStartDate->setTimestamp(strtotime('this week', $startDate->getTimestamp()));
            $week = $weekStartDate->format('W');
            $year = $weekStartDate->format('Y');
            $weekStartDate->setISODate($year, $week);
            $start = clone $weekStartDate;
            $start->modify("+$offset days");
            $end = clone $start;
            $offset_diff = $offset_end - $offset;
            $end->modify("+$offset_diff days");
            $trashIt = false;
            $tempToday = clone $today;
            if($end < $today || $tempToday->modify("+$minLOS days") > $end) {
                $trashIt = true;
            }
            if($start < $today) {
                $start = $today;
                if($start->diff($end)->days < $minLOS) {
                    $trashIt = true;
                }
            }
            if($start < $tp->getStart()) {
                $start = clone $tp->getStart();
                if($start->diff($end)->days < $minLOS) {
                    $trashIt = true;
                }
            }
            if($end > $tp->getEnd()) {
                $end = clone $tp->getEnd();
                if($start->diff($end)->days < $minLOS) {
                    $trashIt = true;
                }
            }
            if($start > $tp->getEnd()) {
                $trashIt = true;
            }
            if(!$trashIt) {
                $tp_temp = new \ONM\Hsforms\Domain\Model\TravelPeriod($start, $end);
                $tps[] = $tp_temp;
            }
            $startDate->modify('+7 days');
        }
        return $tps;
    }
}
