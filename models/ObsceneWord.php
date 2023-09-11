<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

/**
 * app\models\News
 *
 * @property int $id
 * @property string $word
 */
class ObsceneWord extends ActiveRecord
{
    public const ID_COLUMN = 'id';
    public const WORD_COLUMN = 'word';
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%obscene_words}}';
    }
}