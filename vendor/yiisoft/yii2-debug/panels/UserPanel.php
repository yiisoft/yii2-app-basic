<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\debug\panels;

use Yii;
use yii\base\Controller;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveRecord;
use yii\debug\controllers\UserController;
use yii\debug\models\search\UserSearchInterface;
use yii\debug\models\UserSwitch;
use yii\debug\Panel;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Debugger panel that collects and displays user data.
 *
 * @author Daniel Gomez Pan <pana_1990@hotmail.com>
 * @since 2.0.8
 */
class UserPanel extends Panel
{

    /**
     * @var array the rule which defines who allowed to switch user identity.
     * Access Control Filter single rule. Ignore: actions, controllers, verbs.
     * Settable: allow, roles, ips, matchCallback, denyCallback.
     * By default deny for everyone. Recommendation: can allow for administrator
     * or developer (if implement) role: ['allow' => true, 'roles' => ['admin']]
     * @see http://www.yiiframework.com/doc-2.0/guide-security-authorization.html
     * @since 2.0.10
     */
    public $ruleUserSwitch = [
        'allow' => false
    ];

    /**
     * @var UserSwitch object of switching users
     * @since 2.0.10
     */
    public $userSwitch;

    /**
     * @var Model|UserSearchInterface Implements of User model with search method.
     * @since 2.0.10
     */
    public $filterModel;

    /**
     * @var array allowed columns for GridView.
     * @see http://www.yiiframework.com/doc-2.0/yii-grid-gridview.html#$columns-detail
     * @since 2.0.10
     */
    public $filterColumns = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!\Yii::$app->getUser()->isGuest) {
            $this->userSwitch = new UserSwitch();
            $this->addAccesRules();

            if (!is_object($this->filterModel)
                && class_exists($this->filterModel)
                && in_array('yii\debug\models\search\UserSearchInterface', class_implements($this->filterModel), true)
            ) {
                $this->filterModel = new $this->filterModel;
            } elseif (\Yii::$app->user && \Yii::$app->user->identityClass) {
                $identityImplement = new \Yii::$app->user->identityClass();
                if ($identityImplement instanceof ActiveRecord) {
                    $this->filterModel = new \yii\debug\models\search\User();
                }
            }
        }
    }

    /**
     * Add ACF rule. AccessControl attach to debug module.
     * Access rule for main user.
     */
    private function addAccesRules()
    {
        $this->ruleUserSwitch['controllers'] = [$this->module->id . '/user'];

        $this->module->attachBehavior(
            'access_debug',
            [
                'class' => AccessControl::className(),
                'only' => [$this->module->id.'/user', $this->module->id.'/default'],
                'user' => $this->userSwitch->getMainUser(),
                'rules' => [
                    $this->ruleUserSwitch
                ]
            ]
        );
    }

    /**
     * Get model for GridView -> FilterModel
     * @return Model|UserSearchInterface
     */
    public function getUsersFilterModel()
    {
        return $this->filterModel;
    }

    /**
     * Get model for GridView -> DataProvider
     * @return DataProviderInterface
     */
    public function getUserDataProvider()
    {
        return $this->getUsersFilterModel()->search(Yii::$app->request->queryParams);
    }

    /**
     * Check is available search of users
     * @return bool
     */
    public function canSearchUsers()
    {
        return (isset($this->filterModel) &&
            $this->filterModel instanceof Model &&
            $this->filterModel->hasMethod('search')
        );
    }

    /**
     * Check can main user switch identity.
     * @return bool
     */
    public function canSwitchUser()
    {
        $allowSwitchUser = false;

        $rule = new AccessRule($this->ruleUserSwitch);

        /** @var Controller $userController */
        $userController = null;
        $controller = $this->module->createController('user');
        if (isset($controller[0]) && $controller[0] instanceof UserController) {
            $userController = $controller[0];
        }

        //check by rule
        if ($userController) {
            $action = $userController->createAction('set-identity');
            $user = $this->userSwitch->getMainUser();
            $request = Yii::$app->request;

            $allowSwitchUser = $rule->allows($action, $user, $request) ? : false;
        }

        return $allowSwitchUser;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'User';
    }

    /**
     * @inheritdoc
     */
    public function getSummary()
    {
        return Yii::$app->view->render('panels/user/summary', ['panel' => $this]);
    }

    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        return Yii::$app->view->render('panels/user/detail', ['panel' => $this]);
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $identity = Yii::$app->user->identity;

        if (!isset($identity)) {
            return ;
        }

        $authManager = Yii::$app->getAuthManager();

        $rolesProvider = null;
        $permissionsProvider = null;

        if ($authManager instanceof yii\rbac\ManagerInterface) {
            $roles = ArrayHelper::toArray($authManager->getRolesByUser(Yii::$app->getUser()->id));
            foreach ($roles as &$role) {
                $role['data'] = $this->dataToString($role['data']);
            }
            unset($role);
            $rolesProvider = new ArrayDataProvider([
                'allModels' => $roles,
            ]);

            $permissions = ArrayHelper::toArray($authManager->getPermissionsByUser(Yii::$app->getUser()->id));
            foreach ($permissions as &$permission) {
                $permission['data'] = $this->dataToString($permission['data']);
            }
            unset($permission);

            $permissionsProvider = new ArrayDataProvider([
                'allModels' => $permissions,
            ]);
        }

        $identityData = $this->identityData($identity);

        // If the identity is a model, let it specify the attribute labels
        if ($identity instanceof Model) {
            $attributes = [];

            foreach (array_keys($identityData) as $attribute) {
                $attributes[] = [
                    'attribute' => $attribute,
                    'label' => $identity->getAttributeLabel($attribute)
                ];
            }
        } else {
            // Let the DetailView widget figure the labels out
            $attributes = null;
        }

        return [
            'identity' => $identityData,
            'attributes' => $attributes,
            'rolesProvider' => $rolesProvider,
            'permissionsProvider' => $permissionsProvider,
        ];
    }

    /**
     * Converts mixed data to string
     *
     * @param mixed $data
     * @return string
     */
    protected function dataToString($data)
    {
        if (is_string($data)) {
            return $data;
        }

        return VarDumper::export($data);
    }

    /**
     * Returns the array that should be set on [[\yii\widgets\DetailView::model]]
     *
     * @param mixed $identity
     * @return array
     */
    protected function identityData($identity)
    {
        if ($identity instanceof Model) {
            return $identity->getAttributes();
        }

        return get_object_vars($identity);
    }
}
