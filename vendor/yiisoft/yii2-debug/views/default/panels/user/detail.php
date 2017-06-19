<?php

/* @var $this \yii\web\View */
/* @var $panel yii\debug\panels\UserPanel */

use yii\bootstrap\Tabs;
use yii\widgets\DetailView;

?>

<h1>User</h1>

<?php

if (!Yii::$app->user->isGuest) {

    $items = [
        [
            'label'   => 'User',
            'content' => '<h2>User Info</h2>' . DetailView::widget([
                'model'      => $panel->data['identity'],
                'attributes' => $panel->data['attributes']
            ]),
            'active'  => true,
        ],
    ];
    if ($panel->data['rolesProvider'] || $panel->data['permissionsProvider']) {
        $items[] = [
                'label'   => 'Roles and Permissions',
                'content' => $this->render('roles', ['panel' => $panel])
            ];
    }

    if ($panel->canSwitchUser()) {
        $items[] = [
            'label'   => 'Switch User',
            'content' => $this->render(
                'switch',
                [
                    'panel' => $panel
                ]
            )
        ];
    }

    echo Tabs::widget([
        'items' => $items,
    ]);

} ?>
