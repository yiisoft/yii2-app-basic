<?php

declare(strict_types=1);

namespace app\controllers;

use app\services\NewsService\NewsDeleter;
use Throwable;
use yii\web\Controller;
use yii\web\Response;

class DeleteNewsController extends Controller
{
    public NewsDeleter $newsDeleter;

    /**
     * @param $id
     * @param $module
     * @param NewsDeleter $newsDeleter
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        NewsDeleter $newsDeleter,
        array $config = []
    ) {
        $this->newsDeleter = $newsDeleter;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionHandle(int $id): Response
    {
        $success = false;
        $result = null;
        $messages = [];

        try {
            $this->newsDeleter->delete($id);
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
