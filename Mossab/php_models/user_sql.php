<?php
require_once './php_models/user_model.php';
class UserSql{
    private PDO $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create(UserModel &$user):bool {
        $stmt = $this->db->prepare("INSERT INTO users (email, fname, lname, dob, password) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $user->getEmail(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getDOB(),
            $user->getPassword()
        ]);
    }


    public function read($userId) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function readWithEmailAndPassword(UserModel &$user) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$user->getEmail(), $user->getPassword()]);
        $dbUser = $stmt->fetch(PDO::FETCH_ASSOC);
        $user->setUserFromPostArray($dbUser);
        return $user;
    }

    public function update(UserModel &$user) {
        $stmt = $this->db->prepare("UPDATE users SET email = ?, fname = ?, lname = ?, dob = ?, password = ? WHERE id = ?");
        $stmt->execute([
            $user->getEmail(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getDOB(),
            $user->getPassword(),
            $user->getID()
        ]);
    }
    
    public function delete($userId) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
    }
}

