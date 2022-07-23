<?php

class User{
    private $db;
    public function __construct($db){
        $this->db=$db;
    }
//new function 
    public function is_logged_in(){
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){

            return true;
        }
    }
//new function 
    public function create_hash($value){
        return $hash = crypt($value,'$2a$12.substr(str_replace('+','.',base64_encode(sha1(microtime(true),true))),0,22)');
    }

//new function
    private function hash_verify($password,$hash){
        return $hash == crypt($password ,$hash);
    }

//new function   

    private function get_user_hash($username){
        try{
            $stmt = $this->db->prepare('SELECT password FROM blog_users WHERE username = :username');
            $stmt->execute(array('username' => $username));

            $row = $stmt->fetch();
            return $row['password'];
        }catch(PDOException $e){
            echo '<p class= "error">'.$e->getMessage().'</p>';
        }
    }
//new function 

    public function login($username,$password){    

        $hashed = $this->get_user_hash($username);
        
        if($this->hash_verify($password,$hashed) == 1){
          
            $_SESSION['loggedin'] = true;
            
            return true;
            
        }        
    }

    //new function 
    
    public function logout(){
        session_destroy();
      }

}

?>