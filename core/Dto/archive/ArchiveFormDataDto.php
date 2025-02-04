<?php

declare(strict_types=1);

namespace core\Dto\archive;

use core\Dto\BaseDto;

final class ArchiveFormDataDto extends BaseDto
{
    protected function setDefaults(): void
    {
        $this->options = [
            'buses' => false,
            'hotels' => false,
            'clients' => false,
            'tours' => false,
            'countries' => false,
            'resorts' => false,
        ];
    }

    public function toArray(): array
    {
        return $this->options;
    }

    public function getBuses(): bool
    {
        return (bool) $this->options['buses'];
    }

    public function getHotels(): bool
    {
        return (bool) $this->options['hotels'];
    }

    public function getClients(): bool
    {
        return (bool) $this->options['clients'];
    }

    public function getTours(): bool
    {
        return (bool) $this->options['tours'];
    }

    public function getCountries(): bool
    {
        return (bool) $this->options['countries'];
    }

    public function getResorts(): bool
    {
        return (bool) $this->options['resorts'];
    }
}