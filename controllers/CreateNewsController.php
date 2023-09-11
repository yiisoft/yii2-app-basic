<?php

declare(strict_types=1);

namespace app\controllers;

use app\requests\NewsRequest;
use app\services\NewsService\DTO\NewsRequestTransfer;
use app\services\NewsService\NewsCreator;
use Throwable;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class CreateNewsController extends Controller
{
    public NewsCreator $newsCreator;

    /**
     * @param $id
     * @param $module
     * @param NewsCreator $newsCreator
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        NewsCreator $newsCreator,
        array $config = []
    ) {
        $this->newsCreator = $newsCreator;
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
            $request = new NewsRequest();
            $request->attributes = Yii::$app->request->post();

            if ($request->validate()) {
                $result = $this->newsCreator->create(
                    new NewsRequestTransfer(
                        $request->title,
                        $request->description,
                        $request->text
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
