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

namespace Kitodo\Dlf\Hooks;

use Kitodo\Dlf\Common\Helper;
use Kitodo\Dlf\Common\Solr;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * Hooks and helper for \TYPO3\CMS\Core\TypoScript\ConfigurationForm
 *
 * @author Sebastian Meyer <sebastian.meyer@slub-dresden.de>
 * @package TYPO3
 * @subpackage dlf
 * @access public
 */
class ConfigurationForm
{

    /**
     * Check if a connection to a Solr server could be established with the given credentials.
     *
     * @access public
     *
     * @return string Message informing the user of success or failure
     */
    public function checkSolrConnection()
    {
        $solr = Solr::getInstance();
        if ($solr->ready) {
            Helper::addMessage(
                Helper::getLanguageService()->getLL('solr.status'),
                Helper::getLanguageService()->getLL('solr.connected'),
                \TYPO3\CMS\Core\Messaging\FlashMessage::OK
            );
        } else {
            Helper::addMessage(
                Helper::getLanguageService()->getLL('solr.error'),
                Helper::getLanguageService()->getLL('solr.notConnected'),
                \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING
            );
        }
        return Helper::renderFlashMessages();
    }

    /**
     * Make sure the essential namespaces are defined.
     *
     * @access public
     *
     * @return string Message informing the user of success or failure
     */
    public function checkMetadataFormats()
    {
        if (explode('.', VersionNumberUtility::getCurrentTypo3Version())[0] < 10) {
            // We need to do some bootstrapping manually in TYPO3 9.
            // Load table configuration array into $GLOBALS['TCA'].
            ExtensionManagementUtility::loadBaseTca(false);
            // Get extension configuration from dlf/ext_localconf.php.
            ExtensionManagementUtility::loadExtLocalconf(false);
            // Initialize backend user into $GLOBALS['BE_USER'].
            Bootstrap::initializeBackendUser();
            // Initialize backend and ensure authenticated access.
            Bootstrap::initializeBackendAuthentication();
        }

        $nsDefined = [
            'MODS' => false,
            'TEIHDR' => false,
            'ALTO' => false,
            'IIIF1' => false,
            'IIIF2' => false,
            'IIIF3' => false
        ];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_dlf_formats');

        // Check existing format specifications.
        $result = $queryBuilder
            ->select('tx_dlf_formats.type AS type')
            ->from('tx_dlf_formats')
            ->where(
                '1=1'
            )
            ->execute();

        while ($resArray = $result->fetch()) {
            $nsDefined[$resArray['type']] = true;
        }
        // Build data array.
        $data = [];
        // Add MODS namespace.
        if (!$nsDefined['MODS']) {
            $data['tx_dlf_formats'][uniqid('NEW')] = [
                'pid' => 0,
                'type' => 'MODS',
                'root' => 'mods',
                'namespace' => 'http://www.loc.gov/mods/v3',
                'class' => 'Kitodo\\Dlf\\Format\\Mods'
            ];
        }
        // Add TEIHDR namespace.
        if (!$nsDefined['TEIHDR']) {
            $data['tx_dlf_formats'][uniqid('NEW')] = [
                'pid' => 0,
                'type' => 'TEIHDR',
                'root' => 'teiHeader',
                'namespace' => 'http://www.tei-c.org/ns/1.0',
                'class' => 'Kitodo\\Dlf\\Format\\TeiHeader'
            ];
        }
        // Add ALTO namespace.
        if (!$nsDefined['ALTO']) {
            $data['tx_dlf_formats'][uniqid('NEW')] = [
                'pid' => 0,
                'type' => 'ALTO',
                'root' => 'alto',
                'namespace' => 'http://www.loc.gov/standards/alto/ns-v2#',
                'class' => 'Kitodo\\Dlf\\Format\\Alto'
            ];
        }
        // Add IIIF Metadata API 1 context
        if (!$nsDefined['IIIF1']) {
            $data['tx_dlf_formats'][uniqid('NEW')] = [
                'pid' => 0,
                'type' => 'IIIF1',
                'root' => 'IIIF1',
                'namespace' => 'http://www.shared-canvas.org/ns/context.json',
                'class' => ''
            ];
        }
        // Add IIIF Presentation 2 context
        if (!$nsDefined['IIIF2']) {
            $data['tx_dlf_formats'][uniqid('NEW')] = [
                'pid' => 0,
                'type' => 'IIIF2',
                'root' => 'IIIF2',
                'namespace' => 'http://iiif.io/api/presentation/2/context.json',
                'class' => ''
            ];
        }
        // Add IIIF Presentation 3 context
        if (!$nsDefined['IIIF3']) {
            $data['tx_dlf_formats'][uniqid('NEW')] = [
                'pid' => 0,
                'type' => 'IIIF3',
                'root' => 'IIIF3',
                'namespace' => 'http://iiif.io/api/presentation/3/context.json',
                'class' => ''
            ];
        }
        if (!empty($data)) {
            // Process changes.
            $substUid = Helper::processDBasAdmin($data);
            if (!empty($substUid)) {
                Helper::addMessage(
                    Helper::getLanguageService()->getLL('metadataFormats.nsCreatedMsg'),
                    Helper::getLanguageService()->getLL('metadataFormats.nsCreated'),
                    \TYPO3\CMS\Core\Messaging\FlashMessage::INFO
                );
            } else {
                Helper::addMessage(
                    Helper::getLanguageService()->getLL('metadataFormats.nsNotCreatedMsg'),
                    Helper::getLanguageService()->getLL('metadataFormats.nsNotCreated'),
                    \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
                );
            }
        } else {
            Helper::addMessage(
                Helper::getLanguageService()->getLL('metadataFormats.nsOkayMsg'),
                Helper::getLanguageService()->getLL('metadataFormats.nsOkay'),
                \TYPO3\CMS\Core\Messaging\FlashMessage::OK
            );
        }
        return Helper::renderFlashMessages();
    }

    /**
     * This is the constructor.
     *
     * @access public
     *
     * @return void
     */
    public function __construct()
    {
        // Load backend localization file.
        Helper::getLanguageService()->includeLLFile('EXT:dlf/Resources/Private/Language/locallang_be.xlf');
    }

}
