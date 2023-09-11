<?php

declare(strict_types=1);

namespace app\services\NewsService\DTO;

use JsonSerializable;

class NewsResponseTransfer implements JsonSerializable
{
    private int $id;

    private string $title;

    private string $description;

    private string $text;

    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param string $text
     */
    public function __construct(
        int $id,
        string $title,
        string $description,
        string $text
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}