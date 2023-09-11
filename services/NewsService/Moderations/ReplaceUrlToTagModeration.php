<?php

declare(strict_types=1);

namespace app\services\NewsService\Moderations;

use app\services\NewsService\DTO\NewsRequestTransfer;

class ReplaceUrlToTagModeration implements NewsModerationInterface
{
    const REGEX = "~(http|ftp)s?://[a-z0-9.-]+\.[a-z]{2,3}(/\S*)?~i";

    const REPLACEMENT = "<a href='$1' target='_blank'>$2</a>";

    /**
     * @param NewsRequestTransfer $requestTransfer
     * @return void
     */
    public function handle(NewsRequestTransfer $requestTransfer): void
    {
        $requestTransfer->setTitle(
            preg_replace(self::REGEX, self::REPLACEMENT, $requestTransfer->getTitle())
        );
        $requestTransfer->setDescription(
            preg_replace(self::REGEX, self::REPLACEMENT, $requestTransfer->getDescription())
        );
        $requestTransfer->setText(
            preg_replace(self::REGEX, self::REPLACEMENT, $requestTransfer->getText())
        );
    }
}