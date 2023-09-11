<?php

declare(strict_types=1);

namespace app\services\NewsService;

use app\models\News;
use app\repositories\NewsRepository;
use app\services\NewsService\DTO\NewsRequestTransfer;
use app\services\NewsService\DTO\NewsResponseTransfer;

class NewsCreator
{
    private NewsRepository $newsRepository;

    private NewsModerator $newsModerator;

    /**
     * @param NewsRepository $newsRepository
     * @param NewsModerator $newsModerator
     */
    public function __construct(
        NewsRepository $newsRepository,
        NewsModerator $newsModerator
    ) {
        $this->newsRepository = $newsRepository;
        $this->newsModerator = $newsModerator;
    }

    /**
     * @param NewsRequestTransfer $requestTransfer
     * @return NewsResponseTransfer
     */
    public function create(NewsRequestTransfer $requestTransfer): NewsResponseTransfer
    {
        $this->newsModerator->moderate($requestTransfer);

        $newsEntity = $this->newsRepository->create([
            News::TITLE_COLUMN => $requestTransfer->getTitle(),
            News::DESCRIPTION_COLUMN => $requestTransfer->getDescription(),
            News::TEXT_COLUMN => $requestTransfer->getText(),
        ]);

        return new NewsResponseTransfer(
            $newsEntity->id,
            $newsEntity->title,
            $newsEntity->description,
            $newsEntity->text
        );
    }
}