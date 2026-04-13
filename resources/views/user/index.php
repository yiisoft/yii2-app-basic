<?php

declare(strict_types=1);

use app\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/**
 * @var app\models\UserSearch $searchModel search model instance.
 * @var yii\data\ActiveDataProvider $dataProvider data provider instance.
 * @var yii\web\View $this view component instance.
 *
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'Registered users list with filtering, sorting, and pagination.';

$statusLabels = [
    User::STATUS_ACTIVE => ['label' => 'Active', 'class' => 'bg-success'],
    User::STATUS_INACTIVE => ['label' => 'Inactive', 'class' => 'bg-warning text-dark'],
    User::STATUS_DELETED => ['label' => 'Deleted', 'class' => 'bg-danger'],
];

$totalUsers = $dataProvider->getTotalCount();
?>
<div class="site-users d-flex align-items-center justify-content-center">

    <div class="card border-0 overflow-hidden login-split-card users-split-card w-100">
        <div class="row g-0">

            <!-- Brand panel -->
            <div class="col-md-4 d-none d-md-flex login-brand-panel text-white">
                <div class="d-flex flex-column justify-content-between p-4 p-lg-4 w-100">
                    <div>
                        <?= Html::img(
                            Yii::getAlias('@web/images/yii3_full_white_for_dark.svg'),
                            [
                                'alt' => 'Yii Framework',
                                'class' => 'mb-4',
                                'height' => 36,
                            ],
                        ) ?>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-3 login-brand-title">
                            User<br>Directory
                        </h1>
                        <p class="opacity-75 mb-0 login-brand-text">
                            Browse, filter, and sort registered users. Use the search fields to find specific accounts.
                        </p>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-white bg-opacity-25 rounded-pill px-3 py-2">
                                <?= $totalUsers ?> <?= $totalUsers === 1 ? 'user' : 'users' ?>
                            </span>
                        </div>
                        <span class="brand-meta">YII2</span>
                        <span class="brand-meta-dot">&middot;</span>
                        <span class="brand-meta">JQUERY</span>
                        <span class="brand-meta-dot">&middot;</span>
                        <span class="brand-meta">BOOTSTRAP5</span>
                    </div>
                </div>
            </div>

            <!-- Table panel -->
            <div class="col-md-8">
                <div class="p-4 p-lg-4">

                    <!-- Mobile header -->
                    <div class="d-md-none text-center mb-4">
                        <h1 class="h3 fw-bold mb-1"><?= Html::encode($this->title) ?></h1>
                        <p class="text-body-secondary small mb-0">Browse and filter registered users</p>
                    </div>

                    <div class="users-table-wrapper">
                        <?php Pjax::begin(['id' => 'users-pjax', 'timeout' => 5000]) ?>

                        <?= GridView::widget(
                            [
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'tableOptions' => [
                                    'class' => 'table table-hover align-middle mb-0',
                                ],
                                'layout' => "{items}\n{pager}\n{summary}",
                                'pager' => [
                                    'options' => ['class' => 'pagination pagination-sm justify-content-center mt-3 mb-0'],
                                    'linkContainerOptions' => ['class' => 'page-item'],
                                    'linkOptions' => ['class' => 'page-link'],
                                    'disabledListItemSubTagOptions' => ['class' => 'page-link'],
                                ],
                                'columns' => [
                                    [
                                        'attribute' => 'username',
                                        'format' => 'text',
                                        'filterInputOptions' => [
                                            'class' => 'form-control form-control-sm',
                                            'placeholder' => 'Filter...',
                                        ],
                                    ],
                                    [
                                        'attribute' => 'email',
                                        'format' => 'email',
                                        'filterInputOptions' => [
                                            'class' => 'form-control form-control-sm',
                                            'placeholder' => 'Filter...',
                                        ],
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'format' => 'raw',
                                        'filter' => [
                                            User::STATUS_ACTIVE => 'Active',
                                            User::STATUS_INACTIVE => 'Inactive',
                                            User::STATUS_DELETED => 'Deleted',
                                        ],
                                        'filterInputOptions' => [
                                            'class' => 'form-select form-select-sm',
                                            'prompt' => 'All',
                                        ],
                                        'value' => static function (User $model) use ($statusLabels): string {
                                            $info = $statusLabels[$model->status] ?? ['label' => 'Unknown', 'class' => 'bg-secondary'];

                                            return Html::tag('span', Html::encode($info['label']), [
                                                'class' => 'badge rounded-pill ' . $info['class'],
                                            ]);
                                        },
                                        'headerOptions' => ['class' => 'col-status'],
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'label' => 'Joined',
                                        'format' => ['datetime', 'php:d/m/Y'],
                                        'enableSorting' => true,
                                        'filter' => false,
                                        'contentOptions' => ['class' => 'text-nowrap'],
                                    ],
                                ],
                            ],
                        ) ?>

                        <?php Pjax::end() ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
