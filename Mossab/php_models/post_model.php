<?php
class PostModel{
    
    private $id;
    private $category_id;
    private $date;
    private $dob;
    private $post;
    private $user_id; 
    private $image;

    public function __construct($id=null, $category_id=null, $date=null, $dob=null, $post=null, $image=null, $user_id=null) {
        $this->id = $id;
        $this->category_id = $category_id;
        $this->date = $date;
        $this->dob = $dob;
        $this->post = $post;
        $this->image = $image;
        $this->user_id = $user_id; // تصحيح هنا
    }


    public function getID() {
        return $this->id;
    }

    public function getcategory_id() {
        return $this->category_id;
    }

    public function getDate() {
        return $this->date;
    }
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getDOB() {
        return $this->dob;
    }

    public function getpost() {
        return $this->post;
    }

    public function getImage() {
        return $this->image;
    }
    public function getUserId() {
        return $this->user_id;
    }

    public function setPostFromPostArray($postData) {
        $this->id = isset($postData['id']) ? $postData['id'] : $this->id;
        $this->category_id = isset($postData['category_id']) ? $postData['category_id'] : $this->category_id;
        $this->date = isset($postData['date']) ? $postData['date'] : $this->date;
        $this->dob = isset($postData['dob']) ? $postData['dob'] : $this->dob;
        $this->post = isset($postData['post']) ? $postData['post'] : $this->post;
        $this->image = isset($postData['image']) ? $postData['image'] : $this->image;
    }
    public function getProprtyArry(){
        return [
            
            "category_id" => $this->category_id,
            "date" => $this->date,
            "dob" => $this->dob,
            "post" => $this->post,
            "image" => $this->image
        
        ];
    }

}

