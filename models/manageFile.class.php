<?php
    /**
    * Control de archivos: Subida, borrado
    */
    class ManageFile{
      

        public static function createFolder( $uri_folder ){
            if( !file_exists($_SERVER['DOCUMENT_ROOT'].$uri_folder ) ){
                mkdir( $_SERVER['DOCUMENT_ROOT'].$uri_folder );
            }
        }

        public static function exists( $file ){
            if( !file_exists($_SERVER['DOCUMENT_ROOT'].$file ) ){
                return false;
            }
            return true;
        }

        public static function uploadFile( $origin, $destination){
            if( !move_uploaded_file( $origin,  $_SERVER['DOCUMENT_ROOT'].$destination)){
                return false;
            }
            return true;
        }

        public static function deleteFile( $file ){
            if( file_exists(  $_SERVER['DOCUMENT_ROOT'].$file ) ){
                unlink($_SERVER['DOCUMENT_ROOT'].$file);
                return;
            }
        }

        public static function validationUploadedImg( $file_img_name ){

            if( !isset( $_FILES ) && empty( $_FILES ) ){
                return "";
            }

            if( !isset( $_FILES[$file_img_name]['name'] ) || empty( $_FILES[$file_img_name]['name'] ) ){
                return "";
            }

            $img    = $_FILES[$file_img_name];
            // 2. Validar tipo de imagen: png, jpg, jpeg .gif ...
            $type   = $img['type']; // image/gif, image/png, image/jpeg

            if( $type != 'image/gif' && $type != 'image/png' && $type != 'image/jpeg'){
                throw new Exception("La imagen subida no es un archivo válido");
            }
            return $img['name'] ;
        }

        
    }



?>