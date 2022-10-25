<?php
    class User{
        public $id, $username, $position, $name, $email, $phonenumber;

        function __construct($user){
            $this->$id = $user->$id;
            $this->$username = $user->$username; 
            $this->$position = $user->$position; 
            $this->$name = $user->$name; 
            $this->$email = $user->$email; 
            $this->$phonenumber = $user->$phonenumber;
        }

        function setId($id){
            $this->$id = $id;
        }

        function getId(){
            return $this->$id;
        }

        function setUserName($username) {
            return $this->$username = $username;
        }

        function getUserName(){
            return $this->$username;
        }

        function setPosition($position) {
            return $this->$position = $position;
        }

        function getPosition(){
            return $this->$position;
        }

        function setName($name) {
            return $this->$name = $name;
        }

        function getName(){
            return $this->$name;
        }

        function setEmail($email) {
            return $this->$email = $email;
        }

        function getEmail(){
            return $this->$email;
        }

        function setPhoneNumber($phonenumber) {
            return $this->$phonenumber = $phonenumber;
        }

        function getPhoneNumber(){
            return $this->$phonenumber;
        }    
    }
?>