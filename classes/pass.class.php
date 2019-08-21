<?php

class pass
{
	
	
 public function save($data)
  {
    // set the attributes
    
	$this->password = $data['password'];
	$this->gettime = $data['radio2'];
	if($this->gettime == 'OneHour'){
		$this->expire_at = date('Y-m-d H:i:s', time()+60*60) ;
	}
	if($this->gettime == 'mint'){
		$this->expire_at = date('Y-m-d H:i:s', time()+300) ;
	}
	if($this->gettime == 'Oneday'){
		$this->expire_at = date('Y-m-d H:i:s', time()+60*60*24) ;
	}
	$this->email= $data['email'];
	$hash = Hash::make($data['keypass'],$data['password']); 
	$token = base64_encode(uniqid(rand(), true));
    $hashed_token = sha1($token);
      try {

        $db = Database::getInstance();
		$sql = 'INSERT INTO pass (password, expire_at, email ,token) VALUES (:password,  :expire_at,:email, :token)';	
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':password', $hash);
		$stmt->bindParam(':expire_at' ,$this->expire_at);
		$stmt->bindParam(':email',$this->email);
		$stmt->bindParam(':token', $hashed_token);
        $stmt->execute();
		
	  return true;
      } catch(PDOException $exception) {

        // Log the exception message
        error_log($exception->getMessage());
      }
  }
 
public static function deleteExpired()
  {
    try {

      $db = Database::getInstance();

      $stmt = $db->prepare("DELETE FROM pass WHERE expire_at <= '" . date('Y-m-d H:i:s') . "'");
      $stmt->execute();

     

    } catch(PDOException $exception) {

      // Log the detailed exception
      error_log($exception->getMessage());
    }
  }
  public static function getByIDor404($data)
  {
    if (isset($data['id'])) {
      $Pass = static::findByID($data['id']);

      if ($Pass !== null) {
        return $Pass;
      }
    }

    Util::showNotFound();
  }
    public static function findByID($id)
  {
    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('SELECT * FROM pass WHERE id = :id LIMIT 1');
      $stmt->execute([':id' => $id]);
      $Pass = $stmt->fetchObject('pass');

      if ($Pass !== false) {
        return $Pass;
      }

    } catch(PDOException $exception) {

      error_log($exception->getMessage());
    }
  }
  
public static function findByEmail($email)
  {
	   
	   
    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('SELECT * FROM pass WHERE email = :email order by id desc LIMIT 1');
      $stmt->execute([':email' => $email]);
      $Pass = $stmt->fetchObject('pass');

      if ($Pass !== false) {
        return $Pass;
      }

    } catch(PDOException $exception) {

      error_log($exception->getMessage());
    }
  }
 public static function findthetoken($token)
  {

    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('SELECT * FROM pass WHERE token = :token LIMIT 1');
      $stmt->execute([':token' => $token]);
      $Pass = $stmt->fetchObject('pass');

      if ($Pass !== false) {
		// Check the token hasn't expired
        $expiry = DateTime::createFromFormat('Y-m-d H:i:s', $Pass->expire_at);

        if ($expiry !== false) {
          if ($expiry->getTimestamp() > time()) {
            return $Pass;
          }
        }
	  }

    } catch(PDOException $exception) {

      error_log($exception->getMessage());
    }
  }



}

?>