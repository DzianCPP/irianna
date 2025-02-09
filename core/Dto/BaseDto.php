<?php

declare(strict_types=1);

namespace core\Dto;

use LogicException;

abstract class BaseDto
{
    protected array $options = [];

    abstract protected function setDefaults(): void;
    abstract public function toArray(): array;

    public function __construct(array $post)
    {
        $this->setDefaults();

        if (empty($post)) {
            return;
        }

        foreach ($post as $key => $value) {
            $this->options[$key] = $value;
        }
    }

    /**
     * @param string $key
     * @throws \LogicException
     * @return string|int|float|bool
     */
    public function get(string $key): string|int|float|bool
    {
        if (!isset($this->options[(string) $key])) {
            throw new LogicException(
                'There is no such key as '
                . $key
                . ' in the DTO class '
                . static::class
            );
        }

        return $this->options[$key];
    }
}