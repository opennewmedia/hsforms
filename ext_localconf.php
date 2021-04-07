<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'ONM.Hsforms',
            'Form',
            [
                'Form' => 'index'
            ],
            // non-cacheable actions
            [

            ],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'ONM.Hsforms',
            'Api',
            [
                'Form' => 'getAvailabilityColors'
            ],
            // non-cacheable actions
            [

            ]
        );

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.forms {
                    elements {
                        hsforms {
                            iconIdentifier = hsforms-form
                            title = LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tx_hsforms_form.name
                            description = LLL:EXT:hsforms/Resources/Private/Language/locallang_db.xlf:tx_hsforms_form.description
                            tt_content_defValues {
                                CType = hsforms_form
                            }
                        }
                    }
                    show = *
                }
        }'
        );
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

        $iconRegistry->registerIcon(
            'hsforms-form',
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:hsforms/ext_icon.gif']
        );
        // Register for hook to show preview of tt_content element of CType="hsforms_form" in page module
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['hsforms_form'] =
        \ONM\Hsforms\Hooks\PageLayoutView\FormElementPreviewRenderer::class;

        // Registering an update wizard to update the daysallowed field for old records.
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['txHsformsWeekdaysUpdateWizard'] =
        \ONM\Hsforms\Updates\WeekdaysUpdateWizard::class;

        // Registering an update wizard to update the fields start,end of travelperiod
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['txHsformsDatetimeFieldsUpdateWizard'] =
        \ONM\Hsforms\Updates\DatetimeFieldsUpdateWizard::class;

        // Custom log for hsforms
        $GLOBALS['TYPO3_CONF_VARS']['LOG']['ONM']['Hsforms']['Controller']['writerConfiguration'] = [
            // configuration for WARNING severity, including all
            // levels with higher severity (ERROR, CRITICAL, EMERGENCY)
            \TYPO3\CMS\Core\Log\LogLevel::INFO => [
                // add a FileWriter
                \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                    // configuration for the writer
                    'logFile' => 'typo3temp/var/log/typo3_hsforms.log'
                ]
            ],
        ];
    }
);
