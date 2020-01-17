<?php

/*
 * Copyright (C) 2018 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */


DEFINE ('FTP_USER','yourUser');
DEFINE ('FTP_PASS','yourPassword');

/*
 *
 * jen kopie, netestováno !
 *
 */

/**
* Returns the created directory or false.
*
* @param Directory to create (String)
* @return Created directory or false;
*/

function mkDirFix ($path) {


        $path = explode("/",$path);
        $conn_id = @ftp_connect("localhost");
        if(!$conn_id) {
            return false;
        }
        if (@ftp_login($conn_id, FTP_USER, FTP_PASS)) {

            foreach ($path as $dir) {
                if(!$dir) {
                    continue;
                }
                $currPath.="/".trim($dir);
                if(!@ftp_chdir($conn_id,$currPath)) {
                    if(!@ftp_mkdir($conn_id,$currPath)) {
                        @ftp_close($conn_id);
                        return false;
                    }
                    @ftp_chmod($conn_id,0777,$currPath);
                }
            }
        }
        @ftp_close($conn_id);
        return $currPath;

}