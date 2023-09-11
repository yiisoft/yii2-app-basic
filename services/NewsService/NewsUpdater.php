<?php

declare(strict_types=1);

namespace app\services\NewsService;

use app\models\News;
use app\repositories\NewsRepository;
use app\services\NewsService\DTO\NewsRequestTransfer;
use app\services\NewsService\DTO\NewsResponseTransfer;
use app\services\NewsService\Exceptions\NewsNotFoundException;

class NewsUpdater
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
     * @param int $id
     * @param NewsRequestTransfer $requestTransfer
     * @return NewsResponseTransfer
     * @throws NewsNotFoundException
     */
    public function update(int $id, NewsRequestTransfer $requestTransfer): NewsResponseTransfer
    {
        $newsEntity = $this->newsRepository->getById($id);

        if (is_null($newsEntity)) {
            throw new NewsNotFoundException("News not found");
        }

        $this->newsModerator->moderate($requestTransfer);

        $newsEntity = $this->newsRepository->update(
            $newsEntity,
            [
                News::TITLE_COLUMN => $requestTransfer->getTitle(),
                News::DESCRIPTION_COLUMN => $requestTransfer->getDescription(),
                News::TEXT_COLUMN => $requestTransfer->getText(),
            ]
        );

        return new NewsResponseTransfer(
            $newsEntity->id,
            $newsEntity->title,
            $newsEntity->description,
            $newsEntity->text
        );
    }
}