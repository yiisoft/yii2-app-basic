<?php

declare(strict_types=1);

namespace app\requests;

use yii\base\Model;

class NewsRequest extends Model {

    public $title;

    public $description;

    public $text;

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'title',
            'description',
            'text',
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title' ,'description', 'text'], 'required'],
            [['title' ,'description', 'text'], 'string'],
        ];
    }
}