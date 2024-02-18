<?php
require_once './DataBase/DataBase_Connection.php';
require_once './php_models/user_model.php';
class Auth {
    private DataBase $database;

    public function __construct(DataBase $database) {
        $this->database = $database;
    }

    public function signup(UserModel $user) {
        // Check if the username or email already exists
        if ($this->userExists($user->getEmail())) {
            return false; // User already exists
        }


        return $this->database->insert('users', $user->getProprtyArry());
    }

    public function login(UserModel $loggedUser) {
        // Check if the username or email exists
        $user = $this->database->select('users', "email = '" . $loggedUser->getEmail() . "'");
        if (empty($user)) {
            return null; // User not found
        }
        // Verify the password
        $hashedPassword = $user[0]['password'];
        if (password_verify($loggedUser->getPassword(), $hashedPassword)) {
          
             $loggedUser->setUserFromPostArray($user[0]); // Login successful
             return $loggedUser;
        } else {
            return null; // Incorrect password
        }
    }

    public function userExists( $email) {
        // Check if the username or email already exists in the database
        $existingUser = $this->database->select('users', "email = '$email'");
        return !empty($existingUser);
    }
}
