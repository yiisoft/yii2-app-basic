<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\News;

class NewsRepository
{
    /**
     * @param int $id
     * @return null|News
     */
    public function getById(int $id): ?News
    {
        return News::findOne($id);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return News::findAll([
            News::IS_DELETED_COLUMN => false,
        ]);
    }

    /**
     * @param array $data
     * @return News
     */
    public function create(array $data): News
    {
        $news = new News();

        $news->title = $data[News::TITLE_COLUMN];
        $news->description = $data[News::DESCRIPTION_COLUMN];
        $news->text = $data[News::TEXT_COLUMN];

        $news->save();

        return $news;
    }

    /**
     * @param News $news
     * @param array $data
     * @return News
     */
    public function update(News $news, array $data): News
    {
        $news->title = $data[News::TITLE_COLUMN];
        $news->description = $data[News::DESCRIPTION_COLUMN];
        $news->text = $data[News::TEXT_COLUMN];

        $news->save();

        return $news;
    }

    /**
     * @param News $news
     * @return void
     */
    public function delete(News $news): void
    {
        $news->is_deleted = true;

        $news->save();
    }
}