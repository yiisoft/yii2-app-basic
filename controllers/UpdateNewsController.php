<?php

declare(strict_types=1);

namespace app\controllers;

use app\requests\NewsRequest;
use app\services\NewsService\DTO\NewsRequestTransfer;
use app\services\NewsService\NewsUpdater;
use Throwable;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class UpdateNewsController extends Controller
{
    public NewsUpdater $newsUpdater;

    /**
     * @param $id
     * @param $module
     * @param NewsUpdater $newsUpdater
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        NewsUpdater $newsUpdater,
        array $config = []
    ) {
        $this->newsUpdater = $newsUpdater;
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
            $request = new NewsRequest();
            $request->attributes = Yii::$app->request->post();

            if ($request->validate()) {
                $result = $this->newsUpdater->update(
                    $id,
                    new NewsRequestTransfer(
                        $request->title,
                        $request->description,
                        $request->text,
                    )
                );
                $success = true;
            } else {
                $messages = $request->errors;
            }
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
