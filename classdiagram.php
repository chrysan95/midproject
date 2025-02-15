<?php

// parent class -> users
class User{
    protected $id,
            $username, 
            $password;
    protected $books = array();
    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}

// children: books
class Book extends User{
    private $book_id,
            $name,
            $author,
            $publisher,
            $number_of_page,
            $photo;
    public function __construct($user_id, $name, $author, $publisher, $number_of_page) {
        parent::__construct('', ''); 
        $this->user_id = $user_id;
        $this->name = $name;
        $this->author = $author;
        $this->publisher = $publisher;
        $this->number_of_page = $number_of_page;
        }
}
?>