<?php
namespace ONM\Hsforms\Hooks\PageLayoutView;
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility as LU;
use \ONM\Hsforms\Utility\Helper;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use \TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use \TYPO3\CMS\Backend\View\PageLayoutView;

/**
 * Contains a preview rendering for the page module of CType="hsforms_form"
 */
class FormElementPreviewRenderer implements PageLayoutViewDrawItemHookInterface
{

   /**
    * Preprocesses the preview rendering of a content element of type "hsforms_form"
    *
    * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject Calling parent object
    * @param bool $drawItem Whether to draw the item using the default functionality
    * @param string $headerContent Header content
    * @param string $itemContent Item content
    * @param array $row Record row of tt_content
    *
    * @return void
    */
   public function preProcess(
      PageLayoutView &$parentObject,
      &$drawItem,
      &$headerContent,
      &$itemContent,
      array &$row
   )
   {
      if ($row['CType'] === 'hsforms_form') {
        $extensionName = 'hsforms';
        $hsformsLanguageFilePrefix = 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:';
        $viewOptions = [0 => LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_view.0', $extensionName), 1 => LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_view.1', $extensionName)];
        $layoutOptions = [0 => LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_layout.0', $extensionName), 1 => LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_layout.1', $extensionName)];

        $itemContent .= '<b>'.LU::translate('tx_hsforms_form.name', $extensionName).'</b><br><br>';

        // Link
        $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_ibelink', $extensionName).'</b> '.$row['tx_hsforms_form_ibelink'].'<br>';

        // View
        $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_view', $extensionName).'</b> '.$viewOptions[$row['tx_hsforms_form_view']].'<br>';

        // layout
        $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_layout', $extensionName).'</b> '.$layoutOptions[$row['tx_hsforms_form_layout']].'<br>';

        // tx_hsforms_form_btnlabel
        if(trim($row['tx_hsforms_form_btnlabel'])) {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_btnlabel', $extensionName).'</b> '.$row['tx_hsforms_form_btnlabel'].'<br>';
        }
        
        // tx_hsforms_form_modaltitle
        if(trim($row['tx_hsforms_form_modaltitle'])) {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_modaltitle', $extensionName).'</b> '.$row['tx_hsforms_form_modaltitle'].'<br>';
        }

        // tx_hsforms_form_text
        if(trim($row['tx_hsforms_form_text'])) {
            $txt = strlen($row['tx_hsforms_form_text']) > 50 ? substr($row['tx_hsforms_form_text'],0,50)."..." : $row['tx_hsforms_form_text'];
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_text', $extensionName).'</b> '.$txt.'<br>';
        }

        // tx_hsforms_form_cssclasses
        if(trim($row['tx_hsforms_form_cssclasses'])) {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_cssclasses', $extensionName).'</b> '.$row['tx_hsforms_form_cssclasses'].'<br><br>';
        }

        // min max
        $restrictions = ['persons','adults','children','nights','rooms'];

        foreach($restrictions as $res) {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'palette.hsforms'.$res, $extensionName).'</b><br><b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_min', $extensionName).'</b> '.$row['tx_hsforms_form_min'.$res].'&nbsp;&nbsp;&nbsp;&nbsp;<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_max', $extensionName).'</b> '.$row['tx_hsforms_form_max'.$res].'<br><br>';
        }

        // allowed days
        // render binary, 7 digits, split into array and reverse
        $days = Helper::getDays($row['tx_hsforms_form_daysallowed']);

        foreach($days as $day){
            $key = 'tt_content.tx_hsforms_form_daysallowed.' . ++$a;
            if($day) $coursedays .= LU::translate($hsformsLanguageFilePrefix.$key, $extensionName) . '/';
        }
        $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_daysallowed', $extensionName).'</b> '.substr($coursedays, 0, -1).'<br>';

        // tx_hsforms_form_promocode
        if(trim($row['tx_hsforms_form_promocode'])) {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_promocode', $extensionName).'</b> '.$row['tx_hsforms_form_promocode'].'<br>';
        }

        // tx_hsforms_form_promocode_flag
        if($row['tx_hsforms_form_promocode_flag']) {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_promocode_flag', $extensionName).'</b> Yes<br>';
        } else {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_promocode_flag', $extensionName).'</b> No<br>';
        }

        // tx_hsforms_form_rate_flag
        if($row['tx_hsforms_form_rate_flag']) {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_rate_flag', $extensionName).'</b> Yes<br>';
        } else {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_rate_flag', $extensionName).'</b> No<br>';
        }

        // tx_hsforms_form_keepparams
        if($row['tx_hsforms_form_keepparams']) {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_keepparams', $extensionName).'</b> Yes<br>';
        } else {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_keepparams', $extensionName).'</b> No<br>';
        }

        // tx_hsforms_form_allowedparams
        if($row['tx_hsforms_form_allowedparams']) {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_allowedparams', $extensionName).'</b> ' . $row['tx_hsforms_form_allowedparams'] . '<br>';
        } else {
            $itemContent .= '<b>'.LU::translate($hsformsLanguageFilePrefix.'tt_content.tx_hsforms_form_allowedparams', $extensionName).'</b> all<br>';
        }

        // if all travel periods are passed then show a red notice.
        if($row['tx_hsforms_form_travelperiods']) {
            /** @var $extbaseObjectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
            $extbaseObjectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            /** @var $travelPeriodRepository \ONM\Hsforms\Domain\Repository\TravelPeriodRepository */
            $travelPeriodRepository = $extbaseObjectManager->get('ONM\Hsforms\Domain\Repository\TravelPeriodRepository');
            $travelPeriods = $travelPeriodRepository->findByUids(explode(',', $row['tx_hsforms_form_travelperiods']));
            $redNotice = true;
            $today = new \DateTime('now');
            foreach($travelPeriods as $tp) {
                if($tp->getEnd()) {
                    if(strtotime($tp->getEnd()->format('d-m-Y')) >= strtotime($today->format('d-m-Y'))) {
                        $redNotice = false;
                    }
                }
            }
            if($redNotice) {
                $itemContent .= '<span style="background-color:red; color: white">'.LU::translate($hsformsLanguageFilePrefix.'tt_content.travelperiods_passed', $extensionName).'</span>';
            }
        }
        $drawItem = false;
      }
   }
}
