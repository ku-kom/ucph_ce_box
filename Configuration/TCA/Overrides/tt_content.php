<?php

/*
 * This file is part of the package ucph_content_box.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 * June 2023, University of Copenhagen.
 */
declare(strict_types=1);
defined('TYPO3') or die();

call_user_func(function ($extKey ='ucph_content_box', $contentType ='ucph_content_box') {
    // Adds the content element to the "Type" dropdown
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'tt_content',
        'CType',
        [
            'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_content_box_title',
            $contentType,
            // icon identifier
            'ucph_content_box_icon',
        ],
        'ucph_cardgroup',
        'before'
    );

    // Add Content Element
    if (!is_array($GLOBALS['TCA']['tt_content']['types'][$contentType] ?? false)) {
        $GLOBALS['TCA']['tt_content']['types'][$contentType] = [];
    }

    // Configure the default backend fields for the content element
    $GLOBALS['TCA']['tt_content']['types'][$contentType] = array_replace_recursive(
        $GLOBALS['TCA']['tt_content']['types'][$contentType],
        [
        'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
                bodytext;LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_content_box_text,image,
                ucph_content_box_link;LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_content_box_link,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                        --palette--;;language,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                        --palette--;;hidden,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                        categories,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                        rowDescription,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
            ',
            'columnsOverrides' => [
                'bodytext' => [
                    'config' => [
                        'cols' => 30,
                        'rows' => 10,
                        'max' => 250,
                        'placeholder' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_content_box_text_placeholder',
                        'eval' => 'trim'
                    ],
                ],
                'image' => [
                    'config' => [
                        'maxitems' => 1,
                        'appearance' => [
                            'elementBrowserType' => 'file',
                            'elementBrowserAllowed' => 'jpg,jpeg,png,svg'
                        ],
                        'filter' => [
                            0 => [
                                'parameters' => [
                                    'allowedFileExtensions' => 'jpg,jpeg,png,svg',
                                ],
                            ],
                        ],
                        'overrideChildTca' => [
                            'columns' => [
                                'uid_local' => [
                                    'config' => [
                                        'appearance' => [
                                            'elementBrowserAllowed' => 'jpg,jpeg,png,svg',
                                        ],
                                    ],
                                ],
                                'alternative' => [
                                    'description' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_content_box_alt'
                                ]
                            ],
                            'types' => [
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                    'showitem' => '
                                    alternative,--linebreak--,crop,
                                    --palette--;;filePalette'
                                ]
                            ],
                        ],
                    ],
                ],
            ],
        ]
    );

    // Register additional fields
    $GLOBALS['TCA']['tt_content']['columns'] = array_replace_recursive(
        $GLOBALS['TCA']['tt_content']['columns'],
        [
            'ucph_content_box_link' => [
                'exclude' => true,
                'label' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_content_box_link',
                'config' => [
                    'type' => 'input',
                    'renderType' => 'inputLink',
                    'size' => 50,
                    'max' => 1024,
                    'eval' => 'trim',
                    'fieldControl' => [
                        'linkPopup' => [
                            'options' => [
                                'title' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_ce_quote_link',
                            ],
                        ],
                    ],
                    'softref' => 'typolink'
                ]
            ],
            'tx_ucph_content_bg_color' => [
                'label' => 'LLL:EXT:ucph_content_background/Resources/Private/Language/locallang_be.xlf:ucph_page_color_select',
                'displayCond' => [
                    'OR' => [
                        // Only add background color select box in these grid CTypes
                        'FIELD:CType:=:ucph_content_box',
                    ]
                 ],
                'exclude' => true,
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        [
                            'LLL:EXT:ucph_content_background/Resources/Private/Language/locallang_be.xlf:color-unset',
                            '',
                        ],
                        [
                            'LLL:EXT:ucph_content_background/Resources/Private/Language/locallang_be.xlf:color-1',
                            'subset-color-1',
                        ],
                        [
                            'LLL:EXT:ucph_content_background/Resources/Private/Language/locallang_be.xlf:color-2',
                            'subset-color-2',
                        ],
                        [
                            'LLL:EXT:ucph_content_background/Resources/Private/Language/locallang_be.xlf:color-3',
                            'subset-color-3',
                        ],
                        [
                            'LLL:EXT:ucph_content_background/Resources/Private/Language/locallang_be.xlf:color-4',
                            'subset-color-4',
                        ],
                        [
                            'LLL:EXT:ucph_content_background/Resources/Private/Language/locallang_be.xlf:color-5',
                            'subset-color-5',
                        ],
                        [
                            'LLL:EXT:ucph_content_background/Resources/Private/Language/locallang_be.xlf:color-6',
                            'subset-color-6',
                        ],
                    ],
                ],
                'default' => '',
            ],
        ]
    );

    // Add in tab "Appearence"
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        'tx_ucph_content_bg_color',
        '',
        'after:space_after_class'
    );
});
