<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

/**
 * app\models\News
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property bool $is_deleted
 */
class News extends ActiveRecord
{
    public const ID_COLUMN = 'id';
    public const TITLE_COLUMN = 'title';
    public const DESCRIPTION_COLUMN = 'description';
    public const TEXT_COLUMN = 'text';
    public const IS_DELETED_COLUMN = 'is_deleted';
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%news}}';
    }
}