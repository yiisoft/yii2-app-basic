<?php

declare(strict_types=1);

namespace app\controllers;

use app\services\NewsService\NewsListGetter;
use Throwable;
use yii\web\Controller;
use yii\web\Response;

class GetNewsListController extends Controller
{
    private NewsListGetter $newsListGetter;

    /**
     * @param $id
     * @param $module
     * @param NewsListGetter $newsListGetter
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        NewsListGetter $newsListGetter,
        array $config = []
    ) {
        $this->newsListGetter = $newsListGetter;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return Response
     */
    public function actionHandle(): Response
    {
        $success = false;
        $result = null;
        $messages = [];

        try {
            $result = $this->newsListGetter->getList();
            $success = true;
        } catch (Throwable $e) {
            $messages[] = $e->getMessage();
        }

        return $this->asJson([
            'success' => $success,
            'result' => $result,
            'messages' => $messages,
        ]);
    }
}
