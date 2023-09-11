<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\ObsceneWord;

class ObsceneWordRepository
{
    /**
     * @return array
     */
    public function getAll(): array
    {
        return ObsceneWord::find()->all();
    }
}