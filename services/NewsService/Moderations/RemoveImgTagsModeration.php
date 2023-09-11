<?php

declare(strict_types=1);

namespace app\services\NewsService\Moderations;

use app\services\NewsService\DTO\NewsRequestTransfer;

class RemoveImgTagsModeration implements NewsModerationInterface
{
    const REGEX = "/<img[^>]+\>/i";

    const REPLACEMENT = "";

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