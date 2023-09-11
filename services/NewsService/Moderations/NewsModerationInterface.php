<?php

declare(strict_types=1);

namespace app\services\NewsService\Moderations;

use app\services\NewsService\DTO\NewsRequestTransfer;

interface NewsModerationInterface
{
    /**
     * @param NewsRequestTransfer $requestTransfer
     * @return void
     */
    public function handle(NewsRequestTransfer $requestTransfer): void;
}