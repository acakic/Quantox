<?php 

class PagesController
{
	 //    users params (data)
	public $name = '';
    public $email = '';
    public $password = '';
    public $re_password = '';
    public $role_id = '';
    public $subrole_id = '';
    public $sub_subrole_id = '';
    public $registrate = '';
    public $submit = '';
    public $search = '';
    public $error = [];

	public static function home()
	{
		View::load('pages', 'home');
	}
    public static function login()
    {
        View::load('user', 'login');
    }
    public static function register()
    {
        View::load('user', 'register');
    }
    public static function profile()
    {
        View::load('user', 'profile');
    }
    /*
     * Method for logout user! just unset session[user];
     */
    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: http://www.quantoxtest.com/');
    }
    /*
     * Method for returning users from search form!
     */
	public static function resultscreen()
	{
        global $conn;
        $usersgroup = new User($conn);
        $roleId= isset($_POST['role_name']) ? $_POST['role_name'] : null;
        $name = null;
        if(isset($_POST['searched_text']) && $_POST['searched_text'] !== '') {
            $name = $_POST['searched_text'];
        }
        $_SESSION['searchedUser'] = $usersgroup->getAllUsers($roleId, $name);
        $_SESSION['subroles'] = $usersgroup->getSubRoles();
        $_SESSION['ssubroles'] = $usersgroup->getSubSubRoles();
		View::load('pages', 'resultscreen');
	}
    /*
     * Method for returning users from filter form!
     */
    public function filteruser() {
        $filters = $_POST;
        global $conn;
        $usersgroup = new User($conn);
        if(isset($_POST)){
            $_SESSION['searchedUser'] = $usersgroup->getAllUsersByFilter($filters);
        }
        View::load('pages', 'resultscreen');
    }
    /*
     * Method for returning subrole for registation form!
     */
    public function getsubrolesajax() 
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $roleId = (int)$data->role;

        global $conn;
        $roles = new User($conn);
        $subroles = $roles->getSubRolesByRole($roleId);
        echo json_encode($subroles);
    }
    /*
     * Method for returning subsubrole for registation form!
     */
    public function getsubsubroleajax() 
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $subroleId = (int)$data->subrole;

        global $conn;
        $roles = new User($conn);
        $subsubroles = $roles->getSubSubRoleBySubRole($subroleId);
        echo json_encode($subsubroles);
    }
	/*
     * Method for validating  data from USER registration form!
     */
    public function registration()
    {
        if (isset($_POST)) {
            $this->name = $_POST['name'];
            $this->email = $_POST['email'];
            $this->password = $_POST['password'];
            $this->re_password = $_POST['re_password'];
            $this->role_id = $_POST['role_id'];
            $this->subrole_id = $_POST['subrole_id'];
            $this->sub_subrole_id = $_POST['sub_subrole_id'];

            //Remove any excess whitespace
            $this->name = trim($this->name);
            $this->email = trim($this->email);
            $this->password = trim($this->password);
            $this->re_password = trim($this->re_password);
            $this->role_id = trim($this->role_id);
            $this->subrole_id = trim($this->subrole_id);
            $this->sub_subrole_id = trim($this->sub_subrole_id);

            //Check that the input values are of the proper format (REGEX!)
            if (!preg_match('/^[a-zA-Z]+$/', $this->name)) {
                $this->error['name'] = 'Enter Name again!';
            }
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->error['email'] = 'Email is not valid!';
            }
            if (!preg_match('/^[1-9][0-9]*$/', $this->role_id) && filter_var($this->role_id, FILTER_VALIDATE_INT)) {
                $this->error['role_id'] = 'Select role again!';
            }
            if (!preg_match('/^[1-9][0-9]*$/', $this->subrole_id) && filter_var($this->subrole_id, FILTER_VALIDATE_INT)) {
                $this->error['subrole_id'] = 'Select subrole again!';
            }
            if (!preg_match('/^[1-9][0-9]*$/', $this->sub_subrole_id) && filter_var($this->sub_subrole_id, FILTER_VALIDATE_INT)) {
                $this->error['sub_subrole_id'] = 'Select sub subrole again!';
            }
            if (empty($this->name)) {
               $this->error['name'] = 'Field cannot be empty!';
            }
            if (empty($this->email)) {
                $this->error['email'] = 'Field cannot be empty!';
            }
            if (empty($this->role_id)) {
                $this->error['role_id'] = 'Field cannot be empty!';
            }
            if (empty($this->subrole_id)) {
                $this->error['subrole_id'] = 'Field cannot be empty!';
            }
            if (empty($this->sub_subrole_id)) {
                $this->error['sub_subrole_id'] = 'Field cannot be empty!';
            }
            if (empty($this->password)) {
                $this->error['password'] = 'Field cannot be empty!';
            }
            if ($this->re_password != $this->password || empty($this->re_password)) {
                $this->error['password'] = 'Passwords do not match!';
            }
            // //if have errors adds ?, if there only one err add =error + msg, if have more errs adding & after each err msg.
            if (!empty($this->error)) {
                $errors = '?';
                $lastKey = $this->_array_key_last($this->error);
                foreach ($this->error as $error => $msg) {
                    if ($error == $lastKey) {
                        $errors .= $error . '=' . $msg;
                    } else {
                        $errors .= $error . '=' . $msg . '&';
                    }
                }
                header('Location: '. $_SERVER['HTTP_REFERER'] .'?error=' . $msg);
                // header('Location: /user/register?error=' . $errors);
            } else {
                // creates a new password hash, Use the md5 algorithm
                $enc_pass = md5($this->password);
                global $conn;
                $user = new User($conn);
                // checking if email exists in db.
                if ($user->checkIfAvailable($this->email)) {
                    // sending data to register method, creating msg and redirecting user.
                    $is_created = $user->register($this->name, $this->email, $enc_pass, $this->role_id, $this->subrole_id, $this->sub_subrole_id);
                    if($is_created){
                        $msg = 'Successfully registered!';
                        // header('Location: '. $_SERVER['HTTP_REFERER'] .'?success=' . $msg);
                        header('Location: /user/register?success=' . $msg);
                    } else{
                        $msg = 'Try again, something is wrong!';
                        // header('Location: '. $_SERVER['HTTP_REFERER'] .'?error=' . $msg);
                        header('Location: /user/register?error=' . $msg);
                     }
                } else{
                    $msg = 'Email already exists, try another one!';
                    // header('Location: '. $_SERVER['HTTP_REFERER'] .'?error=' . $msg);
                    header('Location: /user/register?error=' . $msg);
                }
            }
        }
    }
    /*
    *   Function for finding last key in an array.
    */ 
    private function _array_key_last(array $array){
        return (!empty($array)) ? array_keys($array)[count($array)-1] : null;
    }
    /*
     * Method for validating  data from USER login form!
     */
    public function loginUser()
	{
		if (!isset($_POST['submit'])) {
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		// var_dump($_POST);
			
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		if (empty($email) || empty($password)) {
			header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=Fields can\'t be empty!');
		}
		global $conn;
		$user = new User($conn);
		$users_data = $user->checkUser($email);
        if ($users_data) {
			 $enc_password = md5($password);
			 // $enc_password = $password;
            if ($enc_password === $users_data['password']) {
				// $rola = $user->getRol($users_data['role_id']);
				
				$_SESSION['user'] = $users_data;
                // redirecting on controller which one we collect from base. And Login is first page for all users.
                $msg = 'Successfully registered!';
				header('Location: /pages/home?success=' . $msg);
            }else{
                $msg = 'Wrong credentials!';
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=' . $msg);
            }
        }else{
            $msg = 'Something went wrong!';
			header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=' . $msg);
        }
	}
    /*
     * Method for returning data for one user in array $data. and deleting user from db! (instantiate edit page);
     */
    public function edit()
    {
        global $conn;
        $oneuser = new User($conn);
        if(isset($_GET['id'])){
            View::$data['one_user'] = $oneuser->getOneUser($_GET['id']);
        }
        if (isset($_GET['delete'])) {
            if ($id = $oneuser->deleteUser($_GET['delete'])) {
                $msg = 'Successfully deleted!';
                unset($_SESSION['user']);
        		header('Location: http://www.quantoxtest.com?success=' . $msg);	
                // header('Location: '. $_SERVER['HTTP_REFERER'] .'?success=' . $msg);
            }else{
                $msg = 'You did something wrong!';
                header('Location: '. $_SERVER['HTTP_REFERER'] .'?error=' . $msg);
            }
        }
        View::load('user', 'edit');
    }
    /*
     * Method for checking data from edit form on edit page and update user;
     */
    public function update()
    {
        global $conn;
        $user = new User($conn);
        $data = $user->getOneUser($_POST['id_user']);
        var_dump($_POST);

        if (isset($_POST)) {
            $this->id_user = $_POST['id_user'];
            $this->name = $_POST['name'];
            $this->email = $_POST['email'];
            $this->password = $_POST['password'];
            $this->role_id = isset($_POST['role_id']) ? $_POST['role_id'] : $data[0]['role_id'];
            $this->subrole_id = isset($_POST['subrole_id']) ? $_POST['subrole_id'] : $data[0]['subrole_id'];
            $this->sub_subrole_id = isset($_POST['sub_subrole_id']) ? $_POST['sub_subrole_id'] : $data[0]['sub_subrole_id'];

            //Remove any excess whitespace
            $this->name = trim($this->name);
            $this->email = trim($this->email);
            $this->password = trim($this->password);
            $this->role_id = trim($this->role_id);
            $this->subrole_id = trim($this->subrole_id);
            $this->sub_subrole_id = trim($this->sub_subrole_id);

            //Check that the input values are of the proper format (REGEX!)
            if (!preg_match('/^[a-zA-Z]+$/', $this->name)) {
            }
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            }
            if (!preg_match('/^[1-9][0-9]*$/', $this->role_id) && filter_var($this->role_id, FILTER_VALIDATE_INT)) {
            }
            if (!preg_match('/^[1-9][0-9]*$/', $this->subrole_id) && filter_var($this->subrole_id, FILTER_VALIDATE_INT)) {
            }
            if (!preg_match('/^[1-9][0-9]*$/', $this->sub_subrole_id) && filter_var($this->sub_subrole_id, FILTER_VALIDATE_INT)) {
            }
            //if property is empty adding data from array $data!
            if (empty($this->name)) {
               $this->name = $data[0]['name'];
            }
            if (empty($this->email)) {
                $this->email = $data[0]['email'];
            }
            if (empty($this->password)) {
                $this->password = md5($data[0]['password']);
            }
            // creates a new password hash, Use the md5 algorithm
            $enc_pass = md5($this->password);
            // checking if email exists in db.
            $isEmailAvailable = true;
            if ($_POST['email'] && ($_POST['email'] != $data[0]['email'])) {
                $isEmailAvailable = $user->checkIfAvailable($this->email);
                if (!$isEmailAvailable) {                    
                    $msg = 'Email already exists, try another one!';
                    header('Location: '. $_SERVER['HTTP_REFERER'] .'&error=' . $msg);
                }
            }
            if ($isEmailAvailable) {
                if ($user->Update($this->id_user, $this->name, $this->email, $enc_pass, $this->role_id, $this->subrole_id, $this->sub_subrole_id)){
                    $msg = 'Successfully updated!';
                    header('Location: '. $_SERVER['HTTP_REFERER'] .'&success=' . $msg);
                } else{
                    $msg = 'Try again something went wrong!';
                    header('Location: '. $_SERVER['HTTP_REFERER'] .'&error=' . $msg);
                }
            }
            
        }
    }

}