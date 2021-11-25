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

namespace Kitodo\Dlf\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use Kitodo\Dlf\Command\BaseCommand;
use Kitodo\Dlf\Common\Document;

/**
 * CLI Command for re-indexing collections into database and Solr.
 *
 * @author Alexander Bigga <alexander.bigga@slub-dresden.de>
 * @package TYPO3
 * @subpackage dlf
 * @access public
 */
class ReindexCommand extends BaseCommand
{
    /**
     * Configure the command by defining the name, options and arguments
     *
     * @return void
     */
    public function configure()
    {
        $this
            ->setDescription('Reindex a collection into database and Solr.')
            ->setHelp('')
            ->addOption(
                'dry-run',
                null,
                InputOption::VALUE_NONE,
                'If this option is set, the files will not actually be processed but the location URI is shown.'
            )
            ->addOption(
                'coll',
                'c',
                InputOption::VALUE_REQUIRED,
                'UID of the collection.'
            )
            ->addOption(
                'pid',
                'p',
                InputOption::VALUE_REQUIRED,
                'UID of the page the documents should be added to.'
            )
            ->addOption(
                'solr',
                's',
                InputOption::VALUE_REQUIRED,
                '[UID|index_name] of the Solr core the document should be added to.'
            )
            ->addOption(
                'owner',
                'o',
                InputOption::VALUE_OPTIONAL,
                '[UID|index_name] of the Library which should be set as owner of the documents.'
            )
            ->addOption(
                'all',
                'a',
                InputOption::VALUE_NONE,
                'Reindex all documents on the given page.'
            );
    }

    /**
     * Executes the command to index the given document to db and solr.
     *
     * @param InputInterface $input The input parameters
     * @param OutputInterface $output The Symfony interface for outputs on console
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dryRun = $input->getOption('dry-run') != false ? true : false;

        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());

        $startingPoint = $this->initializeDocumentRepository($input->getOption('pid'));

        if ($startingPoint === false) {
            $io->error('ERROR: No valid PID (' . $startingPoint . ') given.');
            exit(1);
        }

        if (
            !empty($input->getOption('solr'))
            && !is_array($input->getOption('solr'))
        ) {
            $allSolrCores = $this->getSolrCores($startingPoint);
            $solrCoreUid = $this->getSolrCoreUid($allSolrCores, $input->getOption('solr'));

            // Abort if solrCoreUid is empty or not in the array of allowed solr cores.
            if (empty($solrCoreUid) || !in_array($solrCoreUid, $allSolrCores)) {
                $output_solrCores = [];
                foreach ($allSolrCores as $index_name => $uid) {
                    $output_solrCores[] = $uid . ' : ' . $index_name;
                }
                if (empty($output_solrCores)) {
                    $io->error('ERROR: No valid Solr core ("' . $input->getOption('solr') . '") given. No valid cores found on PID ' . $startingPoint . ".\n");
                    exit(1);
                } else {
                    $io->error('ERROR: No valid Solr core ("' . $input->getOption('solr') . '") given. ' . "Valid cores are (<uid>:<index_name>):\n" . implode("\n", $output_solrCores) . "\n");
                    exit(1);
                }
            }
        } else {
            $io->error('ERROR: Required parameter --solr|-s is missing or array.');
            exit(1);
        }

        if (!empty($input->getOption('owner'))) {
            if (MathUtility::canBeInterpretedAsInteger($input->getOption('owner'))) {
                $owner = MathUtility::forceIntegerInRange((int) $input->getOption('owner'), 1);
            } else {
                $owner = (string) $input->getOption('owner');
            }
        } else {
            $owner = null;
        }

        if (!empty($input->getOption('all'))) {
            // Get all documents.
            $documents = $this->documentRepository->findAll();
        } elseif (
            !empty($input->getOption('coll'))
            && !is_array($input->getOption('coll'))
        ) {
            // "coll" may be a single integer or a comma-separated list of integers.
            if (empty(array_filter(GeneralUtility::intExplode(',', $input->getOption('coll'), true)))) {
                $io->error('ERROR: Parameter --coll|-c is not a valid comma-separated list of collection UIDs.');
                exit(1);
            }
            // Get all documents of given collections.
            $documents = $this->documentRepository->findAllByCollectionsLimited(GeneralUtility::intExplode(',', $input->getOption('coll'), true), 0);
        } else {
            $io->error('ERROR: One of parameters --all|-a or --coll|-c must be given.');
            exit(1);
        }

        foreach ($documents as $id => $document) {
            $doc = Document::getInstance($document->getUid(), ['storagePid' => $startingPoint], true);
            if ($doc->ready) {
                if ($dryRun) {
                    $io->writeln('DRY RUN: Would index ' . $id . '/' . count($documents) . ' ' . $doc->uid . ' ("' . $doc->location . '") on PID ' . $startingPoint . ' and Solr core ' . $solrCoreUid . '.');
                } else {
                    if ($io->isVerbose()) {
                        $io->writeln(date('Y-m-d H:i:s') . ' Indexing ' . $id . '/' . count($documents) . ' ' . $doc->uid . ' ("' . $doc->location . '") on PID ' . $startingPoint . ' and Solr core ' . $solrCoreUid . '.');
                    }
                    // ...and save it to the database...
                    if (!$doc->save($startingPoint, $solrCoreUid, $owner)) {
                        $io->error('ERROR: Document "' . $id . '" not saved and indexed.');
                    }
                }
            } else {
                $io->error('ERROR: Document "' . $id . '" could not be loaded.');
            }
            // Clear document registry to prevent memory exhaustion.
            Document::clearRegistry();
        }

        $io->success('All done!');

        return 0;
    }
}
