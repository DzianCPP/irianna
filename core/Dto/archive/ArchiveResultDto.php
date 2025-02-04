<?php

declare(strict_types=1);

namespace core\Dto\archive;

use core\Dto\BaseDto;
use LogicException;

final class ArchiveResultDto extends BaseDto
{
    public const CODE_OK = 1;
    public const CODE_ERROR = 2;
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';

    protected array $options = [
        'code' => null,
        'status' => null,
        'message' => null,
    ];

    protected function setDefaults(): void
    {
        $this->options = [
            'code' => self::CODE_OK,
            'status' => self::STATUS_SUCCESS,
            'message' => '',
        ];
    }

    public function toArray(): array
    {
        return $this->options;
    }

    public function setCode(int $code): static
    {
        if ($code != self::CODE_OK || $code != self::CODE_ERROR) {
            throw new LogicException('There is no code ' . $code . ' in ArchiveResultDto');
        }

        $this->options['code'] = $code;

        return $this;
    }

    public function setStatus(string $status): static
    {
        if ($status != self::STATUS_SUCCESS || $status != self::STATUS_FAILED) {
            throw new LogicException('There is no status ' . $status . ' in ArchiveResultDto');            
        }

        $this->options['status'] = $status;

        return $this;
    }

    public function setMessage(string $message): static
    {
        $this->options['message'] = $message;

        return $this;
    }

    public function getCode(): int
    {
        return (int) $this->options['code'];
    }

    public function getStatus(): int
    {
        return (int) $this->options['status'];
    }

    public function getMessage(): string
    {
        return (string) $this->options['message'];
    }
}