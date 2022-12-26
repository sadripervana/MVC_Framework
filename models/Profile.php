<?php 

namespace app\models;

use app\core\Model;
use app\core\Application;
use app\models\User;

class Profile extends Model 
{	
	public string $email = '';
	public string $firstname = '';
	public string $lastname = '';
	public string $password = '';
	public string $image = '';

	public  static function tableName():string
	{
		return 'users';
	}

	public static function primaryKey():string
	{
		return 'id';
	}

	public function rules():array
	{
		return [
			'email' =>[self::RULE_REQUIRED, self::RULE_MATCH],
			'firstname' =>[self::RULE_REQUIRED],
			'lastname' =>[self::RULE_REQUIRED],
			'password' => [self::RULE_REQUIRED]
		];	
	}

	public function labels():array
	{
		return [
			'email' => 'Your email',
			'firstname' => 'Your Firstname',
			'lastname' => 'Your Lastname',
			'password' => 'New Password',
			'image' => 'Your Image'
		];
	}


	public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }


	public function attributes():array
	{
		return ['email', 'firstname', 'lastname', 'password', 'image'];		
	}

	public function update()
	{
	   $newFileName = "gallery";
	   $file = $_FILES['image'];
	   $fileName = $file['name'];
	   $fileType = $file['type'];
	   $fileTempName = $file['tmp_name'];
	   $fileError = $file['error'];
	   $fileSize = $file['size'];

	   $fileExt = explode(".",$fileName);
	   $fileActualExt = strtolower(end($fileExt));

	   $allowed = array("jpg", "jpeg", "png");

	   if(in_array($fileActualExt, $allowed)){
	     if($fileError === 0){
	       if($fileSize < 20000000){
	         $imageFullName = $newFileName.".".uniqid("",true).".".$fileActualExt;//uniq id...//more karakter than default with true with false kreate smaller uniq id//include file extention
	         $fileDestination = "../img/".$imageFullName;

	        $this->image = $imageFullName;

			$this->password = password_hash($this->password, PASSWORD_DEFAULT);
			$user = User::findOne(['email'=>$this->email]);
			$tableName = $this->tableName();
	        $attributes = $this->attributes();
	        $params = array_map(fn($attr) => ":$attr", $attributes);
	        $sql = "UPDATE $tableName SET ";
	        foreach ($attributes as $attribute) {
	            $sql .= " $attribute = '". $this->{$attribute} ."',";
			}
			$sql = rtrim($sql, ',');
	        $sql.= " WHERE email = '$user->email'";
	        echo "<pre>";
	        		var_dump($sql);
	        echo "</pre>";
			$statement = self::prepare($sql);
	        $statement->execute();

	        move_uploaded_file($fileTempName, $fileDestination);

	        return true;

	       } else {
	         echo "Your file size is too big!";
	         exit();
	       }
	     } else {
	       echo "You had and error!";
	       exit();
	     }
	   } else {
	     echo "You need to upload a proper file type!";
	     exit ();
	   }
		}

}