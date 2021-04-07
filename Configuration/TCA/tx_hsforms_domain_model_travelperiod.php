<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tx_hsforms_domain_model_travelperiod',
        'label' => 'internal_name',
        'label_userFunc' => ONM\Hsforms\Utility\Helper::class . '->customTravelPeriodTitle',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
		'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
		'searchFields' => 'start,end,internal_name',
        'iconfile' => 'EXT:hsforms/Resources/Public/Icons/custom_tca.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, start, end, daysallowed, internal_name',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, start, end, daysallowed, internal_name, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => [
					[
						'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
						-1,
						'flags-multiple'
					]
				],
				'default' => 0,
			],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_hsforms_domain_model_travelperiod',
                'foreign_table_where' => 'AND tx_hsforms_domain_model_travelperiod.pid=###CURRENT_PID### AND tx_hsforms_domain_model_travelperiod.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
		't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0
            ]
        ],
		'starttime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0,
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ],
        ],
        'start' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tx_hsforms_domain_model_travelperiod.start',
	        'config' => [
			    'type' => 'input',
                'size' => 12,
                'renderType' => 'inputDateTime',
			    'eval' => 'datetime',
			    'default' => 0
			],
	    ],
	    'end' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tx_hsforms_domain_model_travelperiod.end',
            'description' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tx_hsforms_domain_model_travelperiod.end.desc',
	        'config' => [
			    'type' => 'input',
                'size' => 12,
                'renderType' => 'inputDateTime',
			    'eval' => 'datetime',
			    'default' => 0
			],
        ],
        'daysallowed' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tx_hsforms_domain_model_travelperiod.daysallowed',
            'config' => [
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
                 'default' => 127,
                 'cols' => 'inline',
            ]
        ],
        'parentid' => [
            'exclude' => true,
            'label' => 'Parentid',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'parenttable' => [
            'exclude' => true,
            'label' => 'Parenttable',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
	    'internal_name' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:common.internal_name',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
    ],
];
