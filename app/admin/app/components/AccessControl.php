<?php

namespace admin\components;

use Yii;
use yii\base\Module;
use yii\di\Instance;
use yii\web\User;
use yii\web\ForbiddenHttpException;

/**
 * Access Control Filter (ACF) is a simple authorization method that is best used by applications that only need some simple access control.
 * As its name indicates, ACF is an action filter that can be attached to a controller or a module as a behavior.
 * ACF will check a set of access rules to make sure the current user can access the requested action.
 * To use AccessControl, declare it in the application config as behavior.
 * For example.
 * ```
 * 'as access' => [
 *     'class' => 'admin\components\AccessControl',
 *     'allowActions' => ['site/login', 'site/error']
 * ]
 * ```
 * @property User $user
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since  1.0
 */
class AccessControl extends \yii\base\ActionFilter
{
    /**
     * @var User User for check access.
     */
    private $_user = 'user';
    /**
     * @var array List of action that not need to check access.
     */
    public $allowActions = [];

    /**
     * Get user
     * @return User
     */
    public function getUser() {
        if (!$this->_user instanceof User) {
            $this->_user = Instance::ensure($this->_user, User::className());
        }

        return $this->_user;
    }

    /**
     * Set user
     * @param User|string $user
     */
    public function setUser($user) {
        $this->_user = $user;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action) {
        $actionId = $action->getUniqueId();
        $user = $this->getUser();
        if ($this->checkRoute('/' . $actionId, Yii::$app->getRequest()->get(), $user)) {
            return true;
        }

        return $this->denyAccess($user, $action);
    }

    /**
     * Check access route for user.
     * @param string|array $route
     * @param integer|User $user
     * @return boolean
     */
    public function checkRoute($route, $params = [], $user = null) {
        return true;
    }

    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param  User $user the current user
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess($user, $action) {

        if ($user->getIsGuest()) {
            $user->loginRequired();
        }
        else {
            if (!$this->isActive($action)) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function isActive($action) {
        $uniqueId = $action->getUniqueId();
        if ($uniqueId === Yii::$app->getErrorHandler()->errorAction) {
            return false;
        }

        return true;
    }
}
