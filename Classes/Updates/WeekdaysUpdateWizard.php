<?php
declare(strict_types = 1);
namespace ONM\Hsforms\Updates;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;

/**
 * This class provides update wizard to update the value of daysallowed in old records.
 */
class WeekdaysUpdateWizard implements UpgradeWizardInterface
{

    protected $table = 'tt_content';
    protected $fieldName = 'tx_hsforms_form_daysallowed';
    protected $flagField = 'tx_hsforms_form_daysallowed_converted';

    /**
     * Return the identifier for this wizard
     *
     * @return string
     */
    public function getIdentifier(): string
    {
      return 'txHsformsWeekdaysUpdateWizard';
    }

    /**
     * Return the speaking name of this wizard
     *
     * @return string
     */
    public function getTitle(): string
    {
      return 'HSforms daysallowed field updater';
    }

    /**
     * Return the description for this wizard
     *
     * @return string
     */
    public function getDescription(): string
    {
      return 'Daysallowed group checkboxes were starting from Sunday, now it starts from Monday';
    }

    /**
     * Execute the update
     *
     * Called when a wizard reports that an update is necessary
     *
     * @return bool
     */
    public function executeUpdate(): bool
    {
        $this->updateDaysallowedField();
        return true;
    }

    /**
     * Update daysallowed field data where its needed
     */
    protected function updateDaysallowedField()
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($this->table);
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $statement = $queryBuilder
            ->select('*')
            ->from($this->table)
            ->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq($this->flagField, $queryBuilder->createNamedParameter('')),
                    $queryBuilder->expr()->isNull($this->flagField)
                )
            )
            // Ensure that live workspace records are handled first
            ->addOrderBy('t3ver_wsid', 'asc')
            ->addOrderBy('pid', 'asc')
            ->execute();

        while ($record = $statement->fetch()) {
            $recordId = (int)$record['uid'];
            $tx_hsforms_form_daysallowed = $record['tx_hsforms_form_daysallowed'];
            $pid = (int)$record['pid'];
            $languageId = (int)$record['sys_language_uid'];
            $recordInDefaultLanguage = $languageId > 0 ? (int)$record['l10n_parent'] : $recordId;

            $days = decbin($tx_hsforms_form_daysallowed);
            $days = sprintf('%07d', $days);
            $days = strrev($days);
            // $days = array_reverse($days);
            $days = substr($days, 1, strlen($days)).$days[0];
            $days = strrev($days);
            $days = (int)bindec($days);

            $connection->update(
                $this->table,
                [$this->fieldName => $days, 'tx_hsforms_form_daysallowed_converted' => 'yes'],
                ['uid' => $recordId]
            );
        }
    }

    /**
     * Is an update necessary?
     *
     * Is used to determine whether a wizard needs to be run.
     * Check if data for migration exists.
     *
     * @return bool
     */
    public function updateNecessary(): bool
    {
        $updateNeeded = false;
        // Check if the database table even exists
        if ($this->checkIfWizardIsRequired()) {
            $updateNeeded = true;
        }
        return $updateNeeded;
    }

    /**
     * Returns an array of class names of prerequisite classes
     *
     * This way a wizard can define dependencies like "database up-to-date" or
     * "reference index updated"
     *
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }

    /**
     * Check if flagfield is still empty for some records
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    protected function checkIfWizardIsRequired(): bool
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable($this->table);
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $numberOfEntries = $queryBuilder
            ->count('uid')
            ->from($this->table)
            ->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq($this->flagField, $queryBuilder->createNamedParameter('')),
                    $queryBuilder->expr()->isNull($this->flagField)
                )
            )
            ->execute()
            ->fetchColumn();
        return $numberOfEntries > 0;
    }
}
