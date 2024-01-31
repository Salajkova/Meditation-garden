<?php

class Video {
    

    public static function get_video($connection, $id, $columns = "*") {
        $sql = "SELECT $columns
        FROM video
        WHERE id = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try{
            if($stmt->execute()) {
                return $stmt->fetch();
            } else {
                throw new Exception("Získání dat o videu selhalo!");
            }
        } catch (Exception $e) {
            error_log("Chyba u funkce get video!)");
            echo "typ chyby: " . $e->getMessage();
        }
    }


    public static function update_video($connection, 
    $video_name, $video_link, $id) {
        $sql = "UPDATE video        
        SET video_name = :video_name,
        video_link = :video_link
        WHERE id = :id";


        $stmt = $connection->prepare($sql);


        $stmt->bindValue(":video_name", $video_name, PDO::PARAM_STR); 
        $stmt->bindValue(":video_link", $video_link, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Úprava odkazu videa se nepovedla.");
            }
        } catch (Exception $e) {
            error_log("Chyba při úpravě videa");
            echo "Typ chyby: " . $e->getMessage();
        }
   
    }

    public static function delete_video($connection, $id) {
        $sql = "DELETE FROM video
        WHERE id = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try{if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Vymazání se nepovedlo!");
        }
    } catch (Exception $e) {
        error_log("Chyba při mazání videa.");
            echo "Typ chyby: " . $e->getMessage();
    }
    }

    public static function getAllVideos($connection, $columns = "*") {
        $sql = "SELECT $columns FROM video ORDER BY id ASC";

        $stmt = $connection->prepare($sql);

        try{
            if($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Chyba při výpisu videa!");
            }
        } catch (Exception $e) {
            error_log("Chyba získávání videí");
            echo "Typ chyby: " . $e->getMessage();
        }
    }


    // Vytvoření videa


    public static function create_video($connection, 
    $video_name, $video_link ) {
        $sql = "INSERT INTO video (video_name, video_link)
        VALUES (:video_name, :video_link)";

        $stmt = $connection->prepare($sql);
    
    
        $stmt->bindValue(":video_name", $video_name, PDO::PARAM_STR); 
        $stmt->bindValue(":video_link", $video_link, PDO::PARAM_STR);
 

        try {
            if($stmt->execute()) {
                $id = $connection->lastInsertId();
                return $id;
            } else {
                throw new Exception ("Chyba při vytváření videa.");
            }
        } catch (Exception $e) {
            error_log("Chyba při tvoření videa!");
            echo "Typ chyby: " .$e->getMessage();
        }
    }

}