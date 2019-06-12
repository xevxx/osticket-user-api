<?php
include_once INCLUDE_DIR.'class.api.php';
include_once INCLUDE_DIR.'class.user.php';
class UsersApiController extends ApiController {
    /**
     * Create user from json data - public function
     * $data - JSOn object including username, email and password
     * returns user object
     */
    function create($format) {
		
        $key = $this->requireApiKey();
        if(!$key)
            return $this->exerr(401, __('API key not authorized'));
        $user = null;
        if(!strcasecmp($format, 'email')) {
             return $this->exerr(500, __('Email not supported at the moment'));
        } else {
            # Parse request body
            $user = $this->createUser($this->getRequest($format));
            $this->registerUser($user,$this->getRequest($format));
        }
        if(!$user)
            return $this->exerr(500, __('Unable to create new user: unknown error'));
        $this->response(201, $user->getId());
    }

    /**
     * Change user password from json data - public function
     * $data - JSOn object including username and new password
     * returns user object
     */
    function changepword($format) {
		
        $key = $this->requireApiKey();
        $json = $this->getRequest($format);
        if(!$key)
            return $this->exerr(401, __('API key not authorized'));
        $user = null;
        if(!strcasecmp($format, 'email')) {
             return $this->exerr(500, __('Email not supported at the moment'));
        } else {
            # Parse request body
            $user = User::lookupByEmail($json['email']);
            if (!$user)
                return $this->exerr(500, __('User does  not exist'));
            else
                $this->setPasswd($user,$json);
        }
        if(!$user)
            return $this->exerr(500, __('Unable to create new user: unknown error'));
        $this->response(201, $user->getId());
    }
    
    /**
     * Create user from json data
     * $data - JSOn object including username, email and password
     * returns user object
     */
    private function createUser($data) {
		$user = User::fromVars($data);
		return $user;
    }

    /**
     * Register User after creation
     * $user object
     * $data - JSOn object including username, email and password
     */
    private function registerUser($user, $data) {
        $errors = array();
        $data["backend"] = "client";
        $account = UserAccount::register($user,$data,$errors);
    }

    /**
     * Register User after creation
     * $user object
     * $data - JSOn object including username, email and password
     */
    private function setPasswd($user, $data) {
        $user->getAccount()->setPassword($data['passwd1']);
        $user->getAccount()->save(true);
    }

}
