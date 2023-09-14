<?php

declare(strict_types=1);

namespace app\controllers;

use app\requests\NewsRequest;
use app\services\NewsService\DTO\NewsRequestTransfer;
use app\services\NewsService\NewsCreator;
use app\services\NewsService\NewsDeleter;
use app\services\NewsService\NewsListGetter;
use app\services\NewsService\NewsUpdater;
use Throwable;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class NewsController extends Controller
{
    private NewsListGetter $newsListGetter;

    public NewsCreator $newsCreator;

    public NewsDeleter $newsDeleter;

    public NewsUpdater $newsUpdater;

    /**
     * @param $id
     * @param $module
     * @param NewsListGetter $newsListGetter
     * @param NewsCreator $newsCreator
     * @param NewsDeleter $newsDeleter
     * @param NewsUpdater $newsUpdater
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        NewsListGetter $newsListGetter,
        NewsCreator $newsCreator,
        NewsDeleter $newsDeleter,
        NewsUpdater $newsUpdater,
        array $config = []
    ) {
        $this->newsListGetter = $newsListGetter;
        $this->newsCreator = $newsCreator;
        $this->newsDeleter = $newsDeleter;
        $this->newsUpdater = $newsUpdater;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return Response
     */
    public function actionGetList(): Response
    {
        $success = false;
        $result = null;
        $message = '';

        try {
            $result = $this->newsListGetter->getList();
            $success = true;
        } catch (Throwable $e) {
            $message = $e->getMessage();
        }

        return $this->asJson([
            'success' => $success,
            'result' => $result,
            'message' => $message,
        ]);
    }

    /**
     * @return Response
     */
    public function actionCreate(): Response
    {
        $success = false;
        $result = null;
        $message = '';

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
                $message = json_encode($request->getErrors());
            }
        } catch (Throwable $e) {
            $message = $e->getMessage();
        }

        return $this->asJson([
            'success' => $success,
            'result' => $result,
            'message' => $message,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionDelete(int $id): Response
    {
        $success = false;
        $result = null;
        $message = '';

        try {
            $this->newsDeleter->delete($id);
            $success = true;
        } catch (Throwable $e) {
            $message = $e->getMessage();
        }

        return $this->asJson([
            'success' => $success,
            'result' => $result,
            'message' => $message,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionUpdate(int $id): Response
    {
        $success = false;
        $result = null;
        $message = '';

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
                $message = json_encode($request->getErrors());
            }
        } catch (Throwable $e) {
            $message = $e->getMessage();
        }

        return $this->asJson([
            'success' => $success,
            'result' => $result,
            'message' => $message,
        ]);
    }

    /**
     * @return void
     */
    public function actionOptions(): void
    {
        if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
            Yii::$app->getResponse()->setStatusCode(405);
        }

        Yii::$app->getResponse()->getHeaders()->set('Allow', 'GET, POST, PUT, PATCH, HEAD, DELETE, OPTIONS');
    }
}
