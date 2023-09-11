<?php

declare(strict_types=1);

namespace app\services\NewsService;

use app\services\NewsService\DTO\NewsRequestTransfer;

class NewsModerator
{
    private array $moderations;

    /**
     * @param array $moderations
     */
    public function __construct(array $moderations)
    {
        $this->moderations = $moderations;
    }

    /**
     * @param NewsRequestTransfer $requestTransfer
     * @return void
     */
    public function moderate(NewsRequestTransfer $requestTransfer): void
    {
        foreach ($this->moderations as $moderation) {
            $moderation->get()->handle($requestTransfer);
        }
    }
}