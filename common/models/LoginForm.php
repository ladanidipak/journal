<?php

namespace common\models;

use app\models\Users;
use Yii;
use yii\base\Model;
use yii\web\Session;
use backend\vendors\Common;

/**
 * Login form
 */
class LoginForm extends Model {

    public $email;
    public $password;
    public $rememberMe;
    public $userDetails;
    private $_identity;
    private $_user = false;
    private $_id;
    public $errorMessage;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['email', 'required', 'on' => 'forgotPassword', 'message' => 'Email address cannot be blank.'],
            ['email', 'email', 'message' => 'Please enter a valid email address.'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels() {
        return array(
            'email' => "Email",
            'password' => "Password",
            'rememberMe' => 'Remember me',
        );
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if(ENVIRONMENT !== 'dev' && $user){
                if (CONF_WEB_PANEL && $user->type != Users::CONFERENCE_USER) {
                    $this->addError($attribute, 'You are not allowed to login from here.');
                }
                if ( !CONF_WEB_PANEL && $user->type == Users::CONFERENCE_USER) {
                    $this->addError($attribute, 'Incorrect username or password.');
                }
            }
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0)) {
                $user = $this->getUser();
                if (empty($user->profile_pic)):
                    $profile_pic = $user->createProfilePicture($user);
                    \Yii::$app->db->createCommand("UPDATE " . User::tableName() . " SET profile_pic='" . $profile_pic . "' WHERE id='" . $user->id . "'")->execute();
                endif;

                $this->_id = $user->id;
                $session = Yii::$app->session;
                $session->set('userId', $user->id);
                $session->set('userEmail', $user->email);
                $session->set('userFullName', $user->first_name . ' ' . $user->last_name);
                $session->set('dashboardUrl', 'login/index');
                return true;
            }
            else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    /**
     * Check for validity of email address provided during forgot password
     */
    public function checkEmailExists() {
        $emailAddress = strtolower($this->emailAddress);
        $user = User::model()->find('LOWER(email_address)=?', array($emailAddress));
        if (null === $user) {
            $this->addError('emailAddress', 'Email address does not exists.');
            return false;
        } else if (count($user) > 0) {
            $this->userDetails = $user;
            return true;
        }
    }

}
