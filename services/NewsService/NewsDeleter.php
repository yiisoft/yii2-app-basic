<?php

declare(strict_types=1);

namespace app\services\NewsService;

use app\repositories\NewsRepository;
use app\services\NewsService\Exceptions\NewsNotFoundException;

class NewsDeleter
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
     * @param int $id
     * @return void
     * @throws NewsNotFoundException
     */
    public function delete(int $id): void
    {
        $newsEntity = $this->newsRepository->getById($id);

        if (is_null($newsEntity)) {
            throw new NewsNotFoundException("News not found");
        }

        $this->newsRepository->delete($newsEntity);
    }
}