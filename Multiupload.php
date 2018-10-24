<?php 
class Multiupload{
    
    const POLICY_KEEP = 1,
            POLICY_OVERWRITE = 2,
            POLICY_RENAME = 3,
            MIN_OWN_ERROR = 1000;

    private $error = 0,
            $file,
            $input,
            $maxSize = 0,
            $name,
            $policy = self::POLICY_OVERWRITE,
            $target = './';

    function __construct($input) {
        $this->input = $input;
      foreach($_FILES[$input]['tmp_name'] as $atributo => $valor){
        if(isset($_FILES[$input]) && $_FILES[$input]['name'][$atributo] != '') {
            $this->file = $_FILES[$input];
        } else {
            $this->error = 1;
        }
      }
    }
    
    private function __doUpload() {
        $result = false;
        switch($this->policy) {
            case self::POLICY_KEEP:
                $result = $this->__doUploadKeep();
                break;
            case self::POLICY_OVERWRITE:
                $result = $this->__doUploadOverwrite();
                break;
            case self::POLICY_RENAME:
                $result = $this->__doUploadRename();
                break;
        }
        return $result;
    }
    
    private function __doUploadKeep(){
      foreach($this->file['tmp_name'] as $atributo => $valor){
        $result = false;
        if(file_exists($this->target . $this->file['name'][$atributo]) === false) {
            $result = move_uploaded_file($this->file['tmp_name'][$atributo], $this->target . $this->file['name'][$atributo]);
        }
      }
        return $result;
    }
    
    private function __doUploadOverwrite(){
      foreach($this->file['tmp_name'] as $atributo => $valor){
        $result = false;
        $result = move_uploaded_file($this->file['tmp_name'][$atributo], $this->target . $this->file['name'][$atributo]);
      }
      return $result;
    }
    
    private function __doUploadRename(){
      foreach($this->file['tmp_name'] as $atributo => $valor){
        $result = false;
        $newName = $this->target . $this->file['name'][$atributo];
        if(file_exists($newName)) {
            $newName = self::__getValidName($newName);
        }
        $result = move_uploaded_file($this->file['tmp_name'][$atributo], $newName);
      }
      return $result;
    }
    
    private static function __getValidName($file) {
        $parts = pathinfo($file);
        $cont = 0;
        while(file_exists($parts['dirname'] . '/' . $parts['filename'] . $cont . '.' . $parts['extension'])) {
            $cont++;
        }
        return $parts['dirname'] . '/' . $parts['filename'] . $cont . '.' . $parts['extension'];
    }


    function setPolicy($policy) {
        if(is_int($policy) && $policy >= self::POLICY_KEEP && $policy <= self::POLICY_RENAME) {
            $this->policy = $policy;
        }
        return $this;
    }

    function setTarget($target) {
        if(is_string($target) && trim($target) !== '') {
            $this->target = trim($target);
        }
        return $this;
    }

    function upload() {
        $result = false;
        if($this->error !== 1) {
                $this->error = 0;
                $result = $this->__doUpload();
        }
        return $result;
    }
  }
