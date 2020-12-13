<?php
namespace admin\file_handling\FileOperations;

class FileOperations{

    private $file;
    private $path;
    private $allowedTypesOfPictures=[];
    
    public function __construct($path, $file, $allowedTypesOfPictures = Array())
    {
        $this->file = $file;
        $this->path = $path;
        $this->allowedTypesOfPictures = $allowedTypesOfPictures;
    }

    public function getFileName()
    {
        return basename($this->file["name"]);
    }

    public function savePicture($last_id = ""){
        if($this->file == null || $this->path == null){
            return;
        } else {
            $pictureName = basename($this->file["name"]);
            $pictureType = strtolower(pathinfo($pictureName, PATHINFO_EXTENSION));
            if(in_array($pictureType, $this->allowedTypesOfPictures)){
                if($last_id != ""){
                    $files = glob("upload/" . $last_id . "/*");
                    foreach($files as $file){
                        if(is_file($file)){
                            unlink($file);
                        }
                    }
                }
                move_uploaded_file($this->file["tmp_name"], $this->path . $last_id . "/" . $pictureName);
            }
        }
    }

    public function imageFileType()
    {
        return strtolower(pathinfo($this->file["name"], PATHINFO_EXTENSION));
    }

    public function getAllowedTypesOfPictures()
    {
        return $this->allowedTypesOfPictures;
    }

}