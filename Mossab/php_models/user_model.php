<?php
class UserModel {
    private $id;
    private $email;
    private $password;
    private $dob;
    private $fname;
    private $lname;

    public function __construct($id=null, $email=null, $password=null, $dob=null, $fname=null, $lname=null) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->dob = $dob;
        $this->fname = $fname;
        $this->lname = $lname;
    }


    public function getID() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getDOB() {
        return $this->dob;
    }

    public function getFirstName() {
        return $this->fname;
    }

    public function getLastName() {
        return $this->lname;
    }

    public function setUserFromPostArray($postData) {
        $this->id = isset($postData['id']) ? $postData['id'] : $this->id;
        $this->email = isset($postData['email']) ? $postData['email'] : $this->email;
        $this->password = isset($postData['password']) ? $postData['password'] : $this->password;
        $this->dob = isset($postData['dob']) ? $postData['dob'] : $this->dob;
        $this->fname = isset($postData['fname']) ? $postData['fname'] : $this->fname;
        $this->lname = isset($postData['lname']) ? $postData['lname'] : $this->lname;
    }
    public function getProprtyArry(){
        return [
            "email" => $this->email,
            "password" => $this->hashPassword($this->password),
            "dob" => $this->dob,
            "fname" => $this->fname,
            "lname" => $this->lname
        ];
    }
    private function hashPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

