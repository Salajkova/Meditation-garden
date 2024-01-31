<?php

class User {

    public static function createUser($connection, $first_name, $second_name, $email, $password, $role) {

        $sql = "INSERT INTO user (first_name, second_name, email, password, role) 
        VALUES (:first_name, :second_name, :email, :password, :role)";

        $stmt = $connection->prepare($sql);

            $stmt->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $stmt->bindValue(":second_name", $second_name, PDO::PARAM_STR);
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);
            $stmt->bindValue(":password", $password, PDO::PARAM_STR);
            $stmt->bindValue(":role", $role, PDO::PARAM_STR);

            try {
           if($stmt->execute()){
            $id = $connection->lastInsertId();
            return $id; 
            }else {
            throw new Exception("CHyba při tvoření účtu!");
                 }
            } catch (Exception $e) {
            error_log("Chyba při vytvoření uživatele\n", 3 , "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
         }
        }


    public static function authentication($connection, $log_email, $log_password) {
        $sql = "SELECT password
                FROM user
                WHERE email = :email";
    
        
        $stmt = $connection->prepare($sql);
         $stmt->bindValue(":email", $log_email, PDO::PARAM_STR);

           
         try{
            if($stmt->execute()) {
                if ($user = $stmt->fetch()){
                return password_verify($log_password, $user[0]);
                }
        }else {
        throw new Exception("Authentifikace selhala!");
         } 
        } catch (Exception $e) {
            error_log("Chyba při authentifikaci\n", 3 , "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
        }
    }


    public static function getUserId($connection, $email){
        $sql = "SELECT id FROM user
                WHERE email = :email";

        
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);

           try {
            if($stmt->execute()){
                $result = $stmt->fetch();
                $user_id = $result[0];
                return $user_id;
            } else {
                throw new Exception("Chyba při získávání Id");
            }
        } catch (Exception $e) {
            error_log("Chyba při získání Id uživatele\n", 3 , "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
        
        }
    }
    public static function getUserRole($connection, $id){
        $sql = "SELECT role FROM user
                WHERE id = :id";

        
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

           try {
            if($stmt->execute()){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result["role"];
            } else {
                throw new Exception("Chyba při získávání user_role");
            }
        } catch (Exception $e) {
            error_log("Chyba při získání role uživatele\n", 3 , "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
        
        }
    }

}