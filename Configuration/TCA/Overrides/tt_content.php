<?php
defined('TYPO3_MODE') or die();
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility as LU;


call_user_func(function () {
    $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
    $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
    $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
    $settings = $extbaseFrameworkConfiguration['plugin.']['tx_hsforms_form.']['settings.'];

    $extensionName = 'hsforms';
    $temporaryColumn = array(
        'tx_hsforms_form_ibelink' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_ibelink',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,required',
                'default' => $settings['config.']['bookingUrl']
            )
        ),
        'tx_hsforms_form_customtemplate' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_customtemplate',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim',
                'Default' => '',
                'placeholder' => 'EXT:hsforms/Resources/Private/Templates/CustomTemplate.html'
            )
        ),
        'tx_hsforms_form_view' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_view',
            'config' => array (
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_view.0', 0],
                    ['LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_view.1', 1]
                ],
                'default' => 0
            )
        ),
        'tx_hsforms_form_layout' => [
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_layout',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_layout.0', 0, 'EXT:hsforms/Resources/Public/Icons/h.png'],
                    ['LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_layout.1', 1, 'EXT:hsforms/Resources/Public/Icons/v.png'],
                ],
                'default' => 0,
                'fieldWizard' => [ 
                    'selectIcons' => [ 
                       'disabled' => false,
                    ],
                 ],
            ],
        ],
        'tx_hsforms_form_btnlabel' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_btnlabel',
            'config' => array (
                'type' => 'input',
                'default' => $settings['view.']['buttonTitle']
            )
        ),
        'tx_hsforms_form_modaltitle' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_modaltitle',
            'config' => array (
                'type' => 'input',
                'default' => $settings['view.']['modalTitle']
            )
        ),
        'tx_hsforms_form_allowedparams' => array (
            'displayCond' => 'FIELD:tx_hsforms_form_keepparams:REQ:true',
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_allowedparams',
            'config' => array (
                'type' => 'input',
                'default' => $settings['validation.']['allowedParams']
            )
        ),
        'tx_hsforms_form_text' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_text',
            'config' => array (
                'type' => 'text',
                'default' => $settings['view.']['description']
            )
        ),
        'tx_hsforms_form_cssclasses' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_cssclasses',
            'config' => array (
                'type' => 'input',
                'default' => $settings['view.']['additionalClasses']
            )
        ),
        'tx_hsforms_form_minpersons' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_min',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'default' => $settings['validation.']['minNumOfPersons'],
                'size' => 5
            )
        ),
        'tx_hsforms_form_maxpersons' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_max',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['maxNumOfPersons']
            )
        ),
        'tx_hsforms_form_minadults' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_min',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['minNumOfAdults']
            )
        ),
        'tx_hsforms_form_maxadults' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_max',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['maxNumOfAdults']
            )
        ),
        'tx_hsforms_form_defadults' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_def',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['defAdults']
            )
        ),
        'tx_hsforms_form_minchildren' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_min',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['minNumOfChildren']
            )
        ),
        'tx_hsforms_form_maxchildren' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_max',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['maxNumOfChildren']
            )
        ),
        'tx_hsforms_form_defchildren' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_def',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['defChildren']
            )
        ),
        'tx_hsforms_form_minrooms' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_min',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['minNumOfRooms']
            )
        ),
        'tx_hsforms_form_maxrooms' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_max',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['maxNumOfRooms']
            )
        ),
        'tx_hsforms_form_minnights' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_min',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['minLengthOfStay']
            )
        ),
        'tx_hsforms_form_maxnights' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_max',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['maxLengthOfStay']
            )
        ),
        'tx_hsforms_form_daysfromnow' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_daysfromnow',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['daysFromNow']
            )
        ),
        'tx_hsforms_form_daystillend' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_daystillend',
            'config' => array (
                'type' => 'input',
                'eval' => 'trim,int',
                'size' => 5,
                'default' => $settings['validation.']['daysTilEnd']
            )
        ),
        'tx_hsforms_form_lastbookingdate' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_lastbookingdate',
            'config' => array (
                'dbType' => 'datetime',
			    'type' => 'input',
			    'size' => 12,
			    'eval' => 'datetime',
                'default' => $settings['validation.']['lastBookingDate']
            )
        ),
        'tx_hsforms_form_daysallowed' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_daysallowed',
            'config' => array (
                'type' => 'check',
                'items' => [
                    ['LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_daysallowed.1', ''],
                    ['LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_daysallowed.2', ''],
                    ['LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_daysallowed.3', ''],
                    ['LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_daysallowed.4', ''],
                    ['LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_daysallowed.5', ''],
                    ['LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_daysallowed.6', ''],
                    ['LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_daysallowed.7', ''],
                 ],
                 'default' => $settings['validation.']['daysAllowed'],
                 'cols' => 'inline',
            )
        ),
        'tx_hsforms_form_daysallowed_converted' => [
            'config' => [
                'type' => 'passthrough',
                'default' => 'yes'
            ],
        ],
        'tx_hsforms_form_travelperiods' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_travelperiods',
            'config' => array (
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_hsforms_domain_model_travelperiod',
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'pid' => $extbaseFrameworkConfiguration['plugin.']['tx_hsforms_form.']['persistence.']['storagePid']
                        ]
                    ],
                    'listModule' => [
                        'disabled' => false,
                    ],
                ],
            )
        ),
        'tx_hsforms_form_rates' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_rates',
            'config' => array (
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_hsforms_domain_model_rate',
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'pid' => $extbaseFrameworkConfiguration['plugin.']['tx_hsforms_form.']['persistence.']['storagePid']
                        ]
                    ],
                    'listModule' => [
                        'disabled' => false,
                    ],
                ],
            )
        ),
        'tx_hsforms_form_segments' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_segments',
            'config' => array (
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_hsforms_domain_model_segment',
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'pid' => $extbaseFrameworkConfiguration['plugin.']['tx_hsforms_form.']['persistence.']['storagePid']
                        ]
                    ],
                    'listModule' => [
                        'disabled' => false,
                    ],
                ],
            )
        ),
        'tx_hsforms_form_promocode' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_promocode',
            'config' => array (
                'type' => 'input'
            )
        ),
        'tx_hsforms_form_promocode_flag' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_promocode_flag',
            'config' => array (
                'type' => 'check',
                'default' => $settings['view.']['hidePromotion']
            )
        ),
        'tx_hsforms_form_rate_flag' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_rate_flag',
            'config' => array (
                'type' => 'check',
                'default' => $settings['view.']['hideRate']
            )
        ),
        'tx_hsforms_form_keepparams' => array (
            'onChange' => 'reload',
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_keepparams',
            'config' => array (
                'type' => 'check',
                'default' => $settings['view.']['keepParams']
            )
        ),
        'tx_hsforms_form_segment_flag' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_segment_flag',
            'config' => array (
                'type' => 'check',
                'default' => $settings['view.']['hideSegment']
            )
        ),
        'tx_hsforms_form_legends_flag' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_legends_flag',
            'config' => array (
                'type' => 'check',
                'default' => $settings['view.']['hideLegends']
            )
        ),
        'tx_hsforms_form_buffer_flag' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_buffer_flag',
            'description' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_buffer_flag.desc',
            'config' => array (
                'type' => 'check',
                'default' => $settings['validation.']['buffer']
            )
        ),
        'tx_hsforms_form_addrooms_flag' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tt_content.tx_hsforms_form_addrooms_flag',
            'config' => array (
                'type' => 'check',
                'default' => $settings['view.']['hideRoomslink']
            )
        )
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
            'tt_content',
            $temporaryColumn
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        'tx_hsforms_form_ibelink,tx_hsforms_form_view,tx_hsforms_form_layout,tx_hsforms_form_btnlabel,tx_hsforms_form_modaltitle,tx_hsforms_form_text',
        'hsforms_form'
    );
    $hsformsLanguageFilePrefix = 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:';

    $GLOBALS['TCA']['tt_content']['palettes']['hsformspersons'] = array(
        'showitem' => 'tx_hsforms_form_minpersons,tx_hsforms_form_maxpersons',
        'canNotCollapse' => 1
    );

    $GLOBALS['TCA']['tt_content']['palettes']['hsformsadults'] = array(
        'showitem' => 'tx_hsforms_form_minadults,tx_hsforms_form_maxadults,tx_hsforms_form_defadults',
        'canNotCollapse' => 1
    );

    $GLOBALS['TCA']['tt_content']['palettes']['hsformschildren'] = array(
        'showitem' => 'tx_hsforms_form_minchildren,tx_hsforms_form_maxchildren,tx_hsforms_form_defchildren',
        'canNotCollapse' => 1
    );

    $GLOBALS['TCA']['tt_content']['palettes']['hsformsnights'] = array(
        'showitem' => 'tx_hsforms_form_minnights,tx_hsforms_form_maxnights',
        'canNotCollapse' => 1
    );

    $GLOBALS['TCA']['tt_content']['palettes']['hsformsrooms'] = array(
        'showitem' => 'tx_hsforms_form_minrooms,tx_hsforms_form_maxrooms',
        'canNotCollapse' => 1
    );

    $GLOBALS['TCA']['tt_content']['palettes']['hsformsflags'] = array(
        'showitem' => 'tx_hsforms_form_promocode_flag,tx_hsforms_form_rate_flag,tx_hsforms_form_segment_flag,tx_hsforms_form_legends_flag,tx_hsforms_form_addrooms_flag',
        'canNotCollapse' => 1
    );

    $frontendLanguageFilePrefix = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:';

    // Configure the default backend fields for the content element
    $GLOBALS['TCA']['tt_content']['types']['hsforms_form'] = array(
        'showitem' => '
        --palette--;' . $frontendLanguageFilePrefix . 'palette.general;general,
        --palette--;' . $frontendLanguageFilePrefix . 'palette.header;header,
        tx_hsforms_form_ibelink,
    --div--;'.$hsformsLanguageFilePrefix.'tabs.display,
    tx_hsforms_form_view,tx_hsforms_form_layout,tx_hsforms_form_customtemplate,tx_hsforms_form_btnlabel,tx_hsforms_form_modaltitle,tx_hsforms_form_text,tx_hsforms_form_cssclasses,
    --palette--;'.$hsformsLanguageFilePrefix.'palette.hsformsflags;hsformsflags,
    --div--;'.$hsformsLanguageFilePrefix.'tabs.restrictions,
    --palette--;'.$hsformsLanguageFilePrefix.'palette.hsformspersons;hsformspersons,
    --palette--;'.$hsformsLanguageFilePrefix.'palette.hsformsadults;hsformsadults,
    --palette--;'.$hsformsLanguageFilePrefix.'palette.hsformschildren;hsformschildren,
    --palette--;'.$hsformsLanguageFilePrefix.'palette.hsformsrooms;hsformsrooms,
    --palette--;'.$hsformsLanguageFilePrefix.'palette.hsformsnights;hsformsnights,
    tx_hsforms_form_daysfromnow,tx_hsforms_form_daystillend,tx_hsforms_form_lastbookingdate,
    tx_hsforms_form_buffer_flag,
    tx_hsforms_form_daysallowed,
    tx_hsforms_form_travelperiods,
    --div--;'.$hsformsLanguageFilePrefix.'tabs.pref,
    tx_hsforms_form_promocode,
    tx_hsforms_form_rates,
    tx_hsforms_form_segments,
    tx_hsforms_form_keepparams,
    tx_hsforms_form_allowedparams,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language,
    --div--;' . $frontendLanguageFilePrefix . 'tabs.access,
        hidden;' . $frontendLanguageFilePrefix . 'field.default.hidden,
        --palette--;' . $frontendLanguageFilePrefix . 'palette.access;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,

    --div--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category,categories,

    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended'
    );

    $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['hsforms_form'] = 'hsforms-form';

});
