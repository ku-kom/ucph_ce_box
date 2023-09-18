<?php

/*
 * This file is part of the package ucph_content_box
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied.');

// Extension key
$ext = 'ucph_content_box';
$ctype = 'ucph_content_box';

// Add crop variants
$defaultCropSettings = [
    'title' => 'LLL:EXT:'. $ext .'/Resources/Private/Language/locallang_be.xlf:option.default',
    'allowedAspectRatios' => [
        '16:9' => [
            'title' => 'LLL:EXT:'. $ext .'/Resources/Private/Language/locallang_be.xlf:ratio.16_9',
            'value' => 16 / 9
        ],
        '4:3' => [
            'title' => 'LLL:EXT:'. $ext .'/Resources/Private/Language/locallang_be.xlf:ratio.4_3',
            'value' => 4 / 3
        ],
        '1:1' => [
            'title' => 'LLL:EXT:'. $ext .'/Resources/Private/Language/locallang_be.xlf:ratio.1_1',
            'value' => 1.0
        ],
        'NaN' => [
            'title' => 'LLL:EXT:'. $ext .'/Resources/Private/Language/locallang_be.xlf:ratio.free',
            'value' => 0.0
        ],
    ],
    'selectedRatio' => 'NaN',
    'cropArea' => [
        'x' => 0.0,
        'y' => 0.0,
        'width' => 1.0,
        'height' => 1.0,
    ]
];
$xlargeCropSettings = $defaultCropSettings;
$xlargeCropSettings['title'] = 'LLL:EXT:'. $ext .'/Resources/Private/Language/locallang_be.xlf:option.xlarge';
$largeCropSettings = $defaultCropSettings;
$largeCropSettings['title'] = 'LLL:EXT:'. $ext .'/Resources/Private/Language/locallang_be.xlf:option.large';
$mediumCropSettings = $defaultCropSettings;
$mediumCropSettings['title'] = 'LLL:EXT:'. $ext .'/Resources/Private/Language/locallang_be.xlf:option.medium';
$smallCropSettings = $defaultCropSettings;
$smallCropSettings['title'] = 'LLL:EXT:'. $ext .'/Resources/Private/Language/locallang_be.xlf:option.small';
$extrasmallCropSettings = $defaultCropSettings;
$extrasmallCropSettings['title'] = 'LLL:EXT:'. $ext .'/Resources/Private/Language/locallang_be.xlf:option.extrasmall';

// Card group content element
$GLOBALS['TCA']['tt_content']['types'][$ctype]['columnsOverrides']['image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['default'] = $defaultCropSettings;
$GLOBALS['TCA']['tt_content']['types'][$ctype]['columnsOverrides']['image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['xlarge'] = $xlargeCropSettings;
$GLOBALS['TCA']['tt_content']['types'][$ctype]['columnsOverrides']['image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['large'] = $largeCropSettings;
$GLOBALS['TCA']['tt_content']['types'][$ctype]['columnsOverrides']['image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['medium'] = $mediumCropSettings;
$GLOBALS['TCA']['tt_content']['types'][$ctype]['columnsOverrides']['image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['small'] = $smallCropSettings;
$GLOBALS['TCA']['tt_content']['types'][$ctype]['columnsOverrides']['image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants']['extrasmall'] = $extrasmallCropSettings;
