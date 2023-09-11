<?php

declare(strict_types=1);

namespace app\services\NewsService;

use app\models\News;
use app\repositories\NewsRepository;
use app\services\NewsService\DTO\NewsResponseTransfer;

class NewsListGetter
{
    private NewsRepository $newsRepository;

    /**
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return array_map(function (News $newsEntity) {
            return new NewsResponseTransfer(
                $newsEntity->id,
                $newsEntity->title,
                $newsEntity->description,
                $newsEntity->text
            );
        }, $this->newsRepository->getAll());
    }
}