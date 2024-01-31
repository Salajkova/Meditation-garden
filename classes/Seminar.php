<?php

class Seminar {
    
    public static function get_seminar($connection, $id, $columns = "*") {
        $sql = "SELECT $columns
        FROM seminar
        WHERE id = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try{
            if($stmt->execute()) {
                return $stmt->fetch();
            } else {
                throw new Exception("Získání dat o semináři selhalo!");
            }
        } catch (Exception $e) {
            error_log("Chyba u funkce get seminar!)");
            echo "typ chyby: " . $e->getMessage();
        }
    }

    public static function update_seminar($connection, 
    $name, $lector, $description, $price, $date, $id) {
        $sql = "UPDATE seminar
        SET name = :name,
        lector = :lector,
        description = :description,
        price = :price,
         date = :date
        WHERE id = :id";

        $stmt = $connection->prepare($sql);


        $stmt->bindValue(":name", $name, PDO::PARAM_STR); 
        $stmt->bindValue(":lector", $lector, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_INT);
        $stmt->bindValue(":date", $date, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Úprava semináře se nepovedla.");
            }
        } catch (Exception $e) {
            error_log("Chyba při úpravě semináře");
            echo "Typ chyby: " . $e->getMessage();
        }
   
    }

    public static function delete_seminar($connection, $id) {
        $sql = "DELETE FROM seminar
        WHERE id = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try{if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Vymazání se nepovedlo!");
        }
    } catch (Exception $e) {
        error_log("Chyba při mazání seminářů.");
            echo "Typ chyby: " . $e->getMessage();
    }
    }

    public static function getAllSeminars($connection, $columns = "*") {
        $sql = "SELECT $columns FROM seminar ORDER BY date ASC";

        $stmt = $connection->prepare($sql);

        try{
            if($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Chyba při výpisu seminářů!");
            }
        } catch (Exception $e) {
            error_log("Chyba získávání seminářů");
            echo "Typ chyby: " . $e->getMessage();
        }
    }

    public static function create_seminar($connection, 
    $name, $lector, $description, $price, $date ) {
        $sql = "INSERT INTO seminar (name, lector, description, price, date)
        VALUES (:name, :lector, :description, :price, :date)";

        $stmt = $connection->prepare($sql);
    
    
        $stmt->bindValue(":name", $name, PDO::PARAM_STR); 
        $stmt->bindValue(":lector", $lector, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_INT);
        $stmt->bindValue(":date", $date, PDO::PARAM_STR);

        try {
            if($stmt->execute()) {
                $id = $connection->lastInsertId();
                return $id;
            } else {
                throw new Exception ("Chyba při vytváření semináře.");
            }
        } catch (Exception $e) {
            error_log("Chyba při tvoření semináře!");
            echo "Typ chyby: " .$e->getMessage();
        }
    }


    // Pokus o archivaci semináře. Zatím neúspěšný. 
    public static function getOldSeminar($connection) {
        try {
            $sql = "SELECT * FROM seminar WHERE date < NOW()";
            $stmt = $connection->prepare($sql);
    
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Handle error
                return [];
            }
        } catch (Exception $e) {
            // Handle exception
            return [];
        }
    }
    
    
    public static function archivSeminar($connection, $id) {
        try {
            $sql = "INSERT INTO old_seminar SELECT * FROM seminar WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                // Úspěšné archivování - nyní můžete vymazat seminář z původní tabulky
                self::delete_seminar($connection, $id);
                return true;
            } else {
                throw new Exception("Archivace semináře se nezdařila.");
            }
        } catch (Exception $e) {
            // Handle exception
            return false;
        }
    }

    public static function getAllOldSeminars($connection, $columns = "*") {
        $sql = "SELECT $columns FROM old_seminar ORDER BY date ASC";

        $stmt = $connection->prepare($sql);

        try{
            if($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Chyba při výpisu seminářů!");
            }
        } catch (Exception $e) {
            error_log("Chyba získávání seminářů");
            echo "Typ chyby: " . $e->getMessage();
        }
    }

}



?>