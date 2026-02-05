<?php

declare(strict_types=1);

namespace core\services;

use core\Dto\archive\ArchiveFormDataDto;
use core\Dto\archive\ArchiveResultDto;
use core\managers\archive\ArchiveDatabaseManager;
use Exception;

class Archiver
{
    private ArchiveDatabaseManager $manager;

    public function __construct()
    {
        $this->manager = new ArchiveDatabaseManager();
    }

    /**
     * @param ArchiveFormDataDto $formDataDto
     * @throws Exception
     * @return bool
     */
    public function archive(ArchiveFormDataDto $formDataDto): bool
    {
        $entitiesToArchive = [];
        foreach ($formDataDto->toArray() as $key => $toArchive) {
            $toArchive = (bool) $toArchive;

            if ($toArchive) {
                $entitiesToArchive[] = $key;
            }
        }

        $result = $this->manager->archive($entitiesToArchive);

        if ($result->getCode() != ArchiveResultDto::CODE_OK) {
            throw new Exception($result->getMessage());
        }

        return true;
    }
}