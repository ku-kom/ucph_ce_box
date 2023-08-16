<?php

/*
 * This file is part of the package ucph_ce_box.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 * June 2023 Nanna Ellegaard, University of Copenhagen.
 */
declare(strict_types=1);
defined('TYPO3') or die();

call_user_func(function ($extKey ='ucph_ce_box', $contentType ='ucph_ce_box') {
    // Adds the content element to the "Type" dropdown
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'tt_content',
        'CType',
        [
            'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_ce_box_title',
            $contentType,
            // icon identifier
            'ucph_ce_box_icon',
        ],
        'ucph_cardgroup',
        'before'
    );

    // Add Content Element
    if (!is_array($GLOBALS['TCA']['tt_content']['types'][$contentType] ?? false)) {
        $GLOBALS['TCA']['tt_content']['types'][$contentType] = [];
    }

    // Configure the default backend fields for the content element
    $GLOBALS['TCA']['tt_content']['types'][$contentType] = [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;;general,
                header; LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_ce_box_header,
                bodytext;LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_ce_box_text,image,
                box_link;LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_ce_box_link,
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
                    'max' => 100,
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
                                'description' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_ce_image_alt'
                            ]
                        ],
                        'types' => [
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                alternative,description,--linebreak--,crop,
                                --palette--;;filePalette'
                            ]
                        ],
                    ],
                ],
            ],
        ],
    ];

    // Register additional fields
    $GLOBALS['TCA']['tt_content']['columns'] = array_replace_recursive(
        $GLOBALS['TCA']['tt_content']['columns'],
        [
            'box_link' => [
                'exclude' => true,
                'label' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_ce_box_link',
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
            // 'quote_alignment' => [
            //     'label' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_ce_quote_alignment',
            //     'config' => [
            //         'type' => 'select',
            //         'renderType' => 'selectSingle',
            //         'items' => [
            //             [
            //                 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_ce_quote_alignment_left', '', 'EXT:'.$extKey.'/Resources/Public/Icons/justify-left.svg'
            //             ],
            //             [
            //                 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_ce_quote_alignment_center',
            //                 'text-center', 'EXT:'.$extKey.'/Resources/Public/Icons/justify.svg'
            //             ],
            //             [
            //                 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:ucph_ce_quote_alignment_right',
            //                 'text-end', 'EXT:'.$extKey.'/Resources/Public/Icons/justify-right.svg'
            //             ]
            //         ],
            //     ],
            //     'default' => '',
            // ],
        ]
    );
});