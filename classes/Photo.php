<?php

class Photo {
    
    
    
        public static function insertPhoto($connection, $img_name ) {
            $sql = "INSERT INTO photo (img_name)
                VALUES (:img_name)";
        
            $stmt = $connection->prepare($sql);
        
            $stmt->bindValue(":img_name", $img_name, PDO::PARAM_STR);
            // $stmt->bindValue(":upload_date", $upload_date->format('Y-m-d H:i:s'), PDO::PARAM_STR); 
        
            if ($stmt->execute()) {
                return true;
            }
        }
    
        public static function uploadImage($connection, $file) {
            $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    
            if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif") {
                $source = imagecreatefromjpeg($file["tmp_name"]);
    
                list($width, $height) = getimagesize($file["tmp_name"]);
    
                // Omezení výšky na maximálně 800px, pokud je vyšší
                $max_height = 800;
                if ($height > $max_height) {
                    $ratio = $max_height / $height;
                    $new_height = $max_height;
                    $new_width = $width * $ratio;
                } else {
                    $new_height = $height;
                    $new_width = $width;
                }
    
                $new_image = imagecreatetruecolor($new_width, $new_height);
    
                // Vytvoření zmenšené verze s omezenou výškou
                imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
                $resized_file = "resized/" . basename($file["name"]);
    
                // Uložení zmenšené fotografie s omezenou výškou
                 imagejpeg($new_image, $resized_file, 80);

            
    
                // Vytvoření zmenšené verze pro miniaturu o výšce 300px
                $miniatura_height = 300;
                $miniatura_width = ($new_width / $new_height) * $miniatura_height;
    
                $miniatura = imagecreatetruecolor($miniatura_width, $miniatura_height);
    
                // Vytvoření miniatury
                imagecopyresampled($miniatura, $new_image, 0, 0, 0, 0, $miniatura_width, $miniatura_height, $new_width, $new_height);
    
                $miniatura_file = "thumbnails/" . basename($file["name"]);
    
                // Uložení miniatury
                 imagejpeg($miniatura, $miniatura_file, 80);
    
                 imagedestroy($miniatura);
                 imagedestroy($new_image);

             
    
                // Vytvoření záznamu v databázi
                self::insertPhoto($connection, $file["name"]);
    
                Url::redirectUrl("/web/Shibumi23/admin/videos.php");
            } else {
                echo "Pouze soubory typu JPG, JPEG, PNG, GIF jsou povoleny.";
            }
        }

        
        
            public static function getAllPhotos($connection) {
                $sql = "SELECT id, img_name, upload_date FROM photo";
                $stmt = $connection->prepare($sql);
                $stmt->execute();
        
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        

    public static function deletePhoto($path) {
        try {
            //Kontrola existence souboru
            if (!file_exists($path)) {
                throw new Exception("Soubor neexistuje, nemůže být smazán");
            }
            //Smazání souboru
            if (unlink($path)) {
                return true;
            } else {
                throw new Exception("Při mazání souboru došlo k chybě");
            }
        } catch (Exception $e) {
            echo "Chyba: " . $e->getMessage();
        }
    }

    public static function deletePhotoDb($connection, $img_name) {
        $sql = "DELETE FROM photo
            WHERE img_name = :img_name";

        $stmt = $connection->prepare($sql);

        try {
            $stmt->bindValue(":img_name", $img_name, PDO::PARAM_STR);

            if (!$stmt->execute()) {
                throw new Exception("Nepovedlo se smazání");
            }
        } catch (Exception $e) {
            echo "Chyba" . $e->getMessage();
        }
    }

}


// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
//     $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

//     if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif") {
//         $source = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);

//         list($width, $height) = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

//         // Omezení výšky na maximálně 800px, pokud je vyšší
//         $max_height = 800;
//         if ($height > $max_height) {
//             $ratio = $max_height / $height;
//             $new_height = $max_height;
//             $new_width = $width * $ratio;
//         } else {
//             $new_height = $height;
//             $new_width = $width;
//         }

//         $new_image = imagecreatetruecolor($new_width, $new_height);

//         // Vytvoření zmenšené verze s omezenou výškou
//         imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

//         $resized_file = "resized/" . basename($_FILES["fileToUpload"]["name"]);

//         // Uložení zmenšené fotografie s omezenou výškou
//         imagejpeg($new_image, $resized_file, 80);

//         // Vytvoření zmenšené verze pro miniaturu o výšce 300px
//         $miniatura_height = 300;
//         $miniatura_width = ($new_width / $new_height) * $miniatura_height;

//         $miniatura = imagecreatetruecolor($miniatura_width, $miniatura_height);

//         // Vytvoření miniatury
//         imagecopyresampled($miniatura, $new_image, 0, 0, 0, 0, $miniatura_width, $miniatura_height, $new_width, $new_height);

//         $miniatura_file = "thumbnails/" . basename($_FILES["fileToUpload"]["name"]);

//         // Uložení miniatury
//         imagejpeg($miniatura, $miniatura_file, 80);

//         imagedestroy($miniatura);
//         imagedestroy($new_image);

//         echo "Fotka byla úspěšně zmenšena a vytvořena miniatura.";
//     } else {
//         echo "Pouze soubory typu JPG, JPEG, PNG, GIF jsou povoleny.";
//     }