<?php

/**
 * (c) Kitodo. Key to digital objects e.V. <contact@kitodo.org>
 *
 * This file is part of the Kitodo and TYPO3 projects.
 *
 * @license GNU General Public License version 3 or later.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
// Plugin "audioplayer".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_audioplayer'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_audioplayer'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_audioplayer', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/AudioPlayer.xml');
// Plugin "basket".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_basket'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_basket'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_basket', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/Basket.xml');
// Plugin "calendar".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_calendar'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_calendar'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_calendar', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/Calendar.xml');
// Plugin "collection".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_collection'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_collection'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_collection', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/Collection.xml');
// Plugin "feeds".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_feeds'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_feeds'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_feeds', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/Feeds.xml');
// Plugin "listview".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_listview'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_listview'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_listview', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/ListView.xml');
// Plugin "metadata".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_metadata'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_metadata'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_metadata', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/Metadata.xml');
// Plugin "navigation".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_navigation'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_navigation'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_navigation', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/Navigation.xml');
// Plugin "oaipmh".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_oaipmh'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_oaipmh'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_oaipmh', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/OaiPmh.xml');
// Plugin "pagegrid".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_pagegrid'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_pagegrid'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_pagegrid', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/PageGrid.xml');
// Plugin "pageview".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_pageview'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_pageview'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_pageview', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/PageView.xml');
// Plugin "search".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_search'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_search'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_search', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/Search.xml');
// Plugin "statistics".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_statistics'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_statistics'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_statistics', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/Statistics.xml');
// Plugin "tableofcontents".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_tableofcontents'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_tableofcontents'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_tableofcontents', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/TableOfContents.xml');
// Plugin "toolbox".
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['dlf_toolbox'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dlf_toolbox'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dlf_toolbox', 'FILE:EXT:' . 'dlf/Configuration/Flexforms/Toolbox.xml');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'Search',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.search.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-search.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'Feeds',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.feeds.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-feeds.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'Statistics',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.statistics.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-statistics.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'TableOfContents',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.tableofcontents.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-tableofcontents.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'PageGrid',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.pagegrid.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-pagegrid.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'Navigation',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.navigation.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-navigation.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'AudioPlayer',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.audioplayer.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-audioplayer.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'Calendar',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.calendar.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-calendar.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'PageView',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.pageview.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-pageview.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'Basket',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.basket.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-basket.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'Toolbox',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.toolbox.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-toolbox.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'OaiPmh',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.oaipmh.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-oaipmh.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'ListView',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.listview.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-listview.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'Collection',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.collection.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-collection.svg'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Kitodo.Dlf',
    'Metadata',
    'LLL:EXT:dlf/Resources/Private/Language/locallang_be.xlf:plugins.metadata.title',
    'EXT:dlf/Resources/Public/Icons/tx-dlf-metadata.svg'
);
