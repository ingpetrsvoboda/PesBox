<?php
namespace TestApplication\Controller;

use Psr\Http\Message\UploadedFileInterface;
use Pes\Http\Helper\RequestStatus;
use Pes\Http\Response;

/**
 * Description of NestedFilesUpload
 *
 * @author pes2704
 */
class NestedFilesUpload extends FrontControllerAbstract {

    const UPLOADED_KEY = "filesuploaded";

    public function getResponse() {
        if (RequestStatus::isPost($this->request)) {
            $files = $this->request->getUploadedFiles()[self::UPLOADED_KEY];
            $size = 0;
            $targetPath = "uploaded/";
            foreach ($files as $file) {
            /* @var $file UploadedFileInterface */
                $size += $file->getSize();
                $file->moveTo($targetPath.$file->getClientFilename());
            }
            $html = $files ? "Uploadnuto $size bytů, počet souborů ".count($files)."." : "Neuploadnuto nic!";
        } else {
                $html = '
                <form method="post" action="" enctype="multipart/form-data" >
                    <input type="file" name="'.self::UPLOADED_KEY.'[]" multiple />
                    <input type="submit" name="UploadBtn" value="Upload" >
                </form>';
        }
        $response = new Response();
        $response->getBody()->write($html);
        return $response;
    }

}

//$html = '
//<!-- Learn about this code on MDN: https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file -->
//
//<form method="post" enctype="multipart/form-data">
//  <div>
//    <label for="image_uploads">Choose images to upload (PNG, JPG)</label>
//    <input type="file" id="image_uploads" name="'.self::UPLOADED_KEY.'[]" accept=".jpg, .jpeg, .png" multiple>
//  </div>
//  <div class="preview">
//    <p>No files currently selected for upload</p>
//  </div>
//  <div>
//    <button>Submit</button>
//  </div>
//</form>';


//                <input type="file" name="filesupl[]" multiple webkitdirectory id="files" />
