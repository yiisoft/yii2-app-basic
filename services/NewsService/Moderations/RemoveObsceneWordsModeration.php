<?php

declare(strict_types=1);

namespace app\services\NewsService\Moderations;

use app\models\ObsceneWord;
use app\repositories\ObsceneWordRepository;
use app\services\NewsService\DTO\NewsRequestTransfer;

class RemoveObsceneWordsModeration implements NewsModerationInterface
{
    const REPLACEMENT = '...';

    private ObsceneWordRepository $obsceneWordRepository;

    /**
     * @param ObsceneWordRepository $obsceneWordRepository
     */
    public function __construct(ObsceneWordRepository $obsceneWordRepository)
    {
        $this->obsceneWordRepository = $obsceneWordRepository;
    }

    /**
     * @param NewsRequestTransfer $requestTransfer
     * @return void
     */
    public function handle(NewsRequestTransfer $requestTransfer): void
    {
        $obsceneWords = array_map(function (ObsceneWord $obsceneWord) {
            return $obsceneWord->word;
        }, $this->obsceneWordRepository->getAll());

        $requestTransfer->setTitle(
            str_replace($obsceneWords, self::REPLACEMENT, $requestTransfer->getTitle())
        );
        $requestTransfer->setDescription(
            str_replace($obsceneWords, self::REPLACEMENT, $requestTransfer->getDescription())
        );
        $requestTransfer->setText(
            str_replace($obsceneWords, self::REPLACEMENT, $requestTransfer->getText())
        );
    }
}