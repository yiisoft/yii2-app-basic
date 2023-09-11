<?php

declare(strict_types=1);

namespace app\services\NewsService\DTO;

class NewsRequestTransfer
{
    private string $title;

    private string $description;

    private string $text;

    /**
     * @param string $title
     * @param string $description
     * @param string $text
     */
    public function __construct(
        string $title,
        string $description,
        string $text
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
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

    /**
     * @param string $title
     * @return NewsRequestTransfer
     */
    public function setTitle(string $title): NewsRequestTransfer
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $description
     * @return NewsRequestTransfer
     */
    public function setDescription(string $description): NewsRequestTransfer
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $text
     * @return NewsRequestTransfer
     */
    public function setText(string $text): NewsRequestTransfer
    {
        $this->text = $text;
        return $this;
    }
}