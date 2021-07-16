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
    }



?>