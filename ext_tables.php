<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'ONM.Hsforms',
            'Form',
            'Room Form'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'ONM.Hsforms',
            'Api',
            'Api HotelSuite Connect'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('hsforms', 'Configuration/TypoScript', 'hsForms');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hsforms_domain_model_travelperiod');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hsforms_domain_model_rate');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hsforms_domain_model_segment');

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'ONM.Hsforms',
            'web', // Make module a submodule of 'web'
            'expiredtp', // Submodule key
            '', // Position
            [
                'Form' => 'expired'
            ],
            [
                'access' => 'user,group',
                'icon'   => 'EXT:hsforms/Resources/Public/Icons/tp.svg',
                'labels' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_mod.xlf',
            ]
        );
    }
);
