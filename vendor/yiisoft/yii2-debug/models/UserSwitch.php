<?php
/**
  * @link http://www.yiiframework.com/
  * @copyright Copyright (c) 2008 Yii Software LLC
  * @license http://www.yiiframework.com/license/
  */

namespace yii\debug\models;


use yii\base\Model;
use yii\web\IdentityInterface;
use yii\web\User;

/**
 * UserSwitch is a model used to temporary logging in another user
 *
 * @author Semen Dubina <yii2debug@sam002.net>
 *
 * @property User $user
 * @property User $mainUser
 */
class UserSwitch extends Model
{
    /**
     * @var User user which we are currently switched to
     */
    private $user;

    /**
     * @var User the main user who was originally logged in before switching.
     */
    private $mainUser;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'mainUser'], 'safe']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'user' => 'Current User',
            'mainUser' => 'frontend', 'Main User',
        ];
    }

    /**
     * Get current user
     * @return null|User
     */
    public function getUser()
    {
        if (empty($this->user)) {
            $this->user = \Yii::$app->user;
        }
        return $this->user;
    }

    /**
     * Get main user
     * @return User
     */
    public function getMainUser()
    {
        $session = \Yii::$app->getSession();

        if (empty($this->mainUser) && !\Yii::$app->getUser()->isGuest) {
            if ($session->has('main_user')) {
                $mainUserId = $session->get('main_user');
            } else {
                $mainUserId = \Yii::$app->user->getId();
            }
            $mainIdentity = \Yii::$app->user->identity->findIdentity($mainUserId);

            $mainUser = clone \Yii::$app->user;
            $mainUser->setIdentity($mainIdentity);
            $this->mainUser = $mainUser;
        }

        return $this->mainUser;
    }

    /**
     * Switch user
     * @param User $user
     */
    public function setUser(User $user)
    {
        // Check if user is currently active one
        $isCurrent = ($user->getId() === $this->getMainUser()->getId());
        // Switch identity
        \Yii::$app->getUser()->switchIdentity($user->identity);
        if (!$isCurrent) {
            \Yii::$app->getSession()->set('main_user', $this->getMainUser()->getId());
        } else {
            \Yii::$app->getSession()->remove('main_user');
        }
    }

    /**
     * Switch to user by identity
     * @param IdentityInterface $identity
     */
    public function setUserByIdentity(IdentityInterface $identity)
    {
        $user = clone \Yii::$app->user;
        $user->setIdentity($identity);
        $this->setUser($user);
    }

    /**
     * Reset to main user
     */
    public function reset()
    {
        $this->setUser($this->getMainUser());
    }

    /**
     * Checks if current user is main or not.
     * @return bool
     */
    public function isMainUser()
    {
        if (\Yii::$app->user->isGuest) {
            return true;
        }
        return (\Yii::$app->user->getId() === $this->getMainUser()->getId());
    }
}
