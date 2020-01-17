<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $files = $_FILES;
    echo 'Uploadnuto '.count($files).' souborů.';
} else {
    $html = <<<HTML
        <form method="post" action="upload.php" enctype="multipart/form-data" id="upload" >
        <input type="file" name="filesupl[]" multiple id="files" />
        <input type="submit" name="UploadBtn" value="Upload" id="UploadBtn">
        </form>
HTML;
    echo $html;

}