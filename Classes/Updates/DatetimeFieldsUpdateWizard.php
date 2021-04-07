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
 * This class provides update wizard to update the value of start and end in old records of travelperiods.
 */
class DatetimeFieldsUpdateWizard implements UpgradeWizardInterface
{

    protected $table = 'tx_hsforms_domain_model_travelperiod';
    protected $fieldNames = ['start','end'];

    /**
     * Return the identifier for this wizard
     *
     * @return string
     */
    public function getIdentifier(): string
    {
      return 'txHsformsDatetimeFieldsUpdateWizard';
    }

    /**
     * Return the speaking name of this wizard
     *
     * @return string
     */
    public function getTitle(): string
    {
      return 'HSForms start, end field conversion';
    }

    /**
     * Return the description for this wizard
     *
     * @return string
     */
    public function getDescription(): string
    {
      return 'Conversion of hsForms start, end fields of travelperiod from datetime to int';
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
        $this->updateFields();
        return true;
    }

    /**
     * Update and convert data of start and end
     */
    protected function updateFields()
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('INFORMATION_SCHEMA.COLUMNS');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $data = $queryBuilder
            ->select('DATA_TYPE')
            ->from('INFORMATION_SCHEMA.COLUMNS')
            ->where(
                $queryBuilder->expr()->eq('table_name', $queryBuilder->createNamedParameter($this->table))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('COLUMN_NAME', $queryBuilder->createNamedParameter($this->fieldNames[0]))
            )
            ->execute()
            ->fetch();

        if ($data['DATA_TYPE'] === 'datetime') {
            // the conversion of data type and data from datetime to timestamp (int) and also timezone conversions

            $conn = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($this->table);
            $statement = $conn->prepare("ALTER TABLE $this->table ADD COLUMN start_old_zzz datetime DEFAULT '0000-00-00 00:00:00'");
            $statement->execute();
            $statement = $conn->prepare("ALTER TABLE $this->table ADD COLUMN start_new int(11) unsigned DEFAULT '0' NULL");
            $statement->execute();
            $statement = $conn->prepare("ALTER TABLE $this->table ADD COLUMN end_old_zzz datetime DEFAULT '0000-00-00 00:00:00'");
            $statement->execute();
            $statement = $conn->prepare("ALTER TABLE $this->table ADD COLUMN end_new int(11) unsigned DEFAULT '0' NULL");
            $statement->execute();
            $statement = $conn->prepare("UPDATE $this->table SET start_old_zzz = start");
            $statement->execute();
            $statement = $conn->prepare("UPDATE $this->table SET end_old_zzz = end");
            $statement->execute();
            $statement = $conn->prepare("UPDATE $this->table SET start_new = unix_timestamp(CONVERT_TZ(start, 'Europe/Berlin', 'UTC'))");
            $statement->execute();
            $statement = $conn->prepare("UPDATE $this->table SET end_new = unix_timestamp(CONVERT_TZ(end, 'Europe/Berlin', 'UTC'))");
            $statement->execute();
            $statement = $conn->prepare("ALTER TABLE $this->table CHANGE start start_zzz datetime");
            $statement->execute();
            $statement = $conn->prepare("ALTER TABLE $this->table CHANGE end end_zzz datetime");
            $statement->execute();
            $statement = $conn->prepare("ALTER TABLE $this->table CHANGE start_new start int");
            $statement->execute();
            $statement = $conn->prepare("ALTER TABLE $this->table CHANGE end_new end int");
            $statement->execute();
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
        return [];
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
        $queryBuilder = $connectionPool->getQueryBuilderForTable('INFORMATION_SCHEMA.COLUMNS');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $data = $queryBuilder
            ->select('DATA_TYPE')
            ->from('INFORMATION_SCHEMA.COLUMNS')
            ->where(
                $queryBuilder->expr()->eq('table_name', $queryBuilder->createNamedParameter($this->table))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('COLUMN_NAME', $queryBuilder->createNamedParameter($this->fieldNames[0]))
            )
            ->execute()
            ->fetch();
        return ($data['DATA_TYPE'] === 'datetime');
    }
}
