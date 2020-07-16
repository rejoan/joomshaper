<?php
require_once './includes/DBManage.php';
/**
 *  PHP upload
 *
 */

$uploader = new Uploader();
$uploader->saveUploadedFile();
class Uploader {

    const UPLOAD_DIR = '../Gallery/';

    /**
     * Uploader constructor
     */
    public function __construct() {
        $this->allowCors();
    }

    /**
     * Opens up CORS access
     */
    private function allowCors() {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }
    }

    /**
     * Saves the uploaded file
     *
     * @return [type] [description]
     */
    public function saveUploadedFile() {
        $total = count($_FILES['userfile']['name']);
        $res = TRUE;
        $dbCommon = new DBManage();
        $mysqli = $dbCommon->connectDatabase();
        
        for ($i = 0; $i < $total; $i++) {
            $this->handleUploadError($_FILES['userfile']['error'][$i]);
            $mysqli->query('INSERT INTO images (file_name) VALUES("'.time().$_FILES['userfile']['name'][$i].'")');
            $res = move_uploaded_file($_FILES['userfile']['tmp_name'][$i], self::UPLOAD_DIR .time().$_FILES['userfile']['name'][$i]);
        }
        $mysqli->close();
        if($res){
            return $this->response(200, ['message' => 'done']);
        }else{
            return $this->response(500, ['error' => 'Unknown Error']);
        }
        
    }



    /**
     * Formats an error response
     *
     * @param  int $uploadError
     */
    private function handleUploadError(int $uploadError) {
        if ($uploadError === 0) {
            return;
        }

        switch ($uploadError) {
            case 1:
                $error = 'UPLOAD_ERR_INI_SIZE';
                $message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                break;
            case 2:
                $error = 'UPLOAD_ERR_FORM_SIZE';
                $message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                break;
            case 3:
                $error = 'UPLOAD_ERR_PARTIAL';
                $message = 'The uploaded file was only partially uploaded.';
                break;
            case 4:
                $error = 'UPLOAD_ERR_NO_FILE';
                $message = 'No file was uploaded.';
                break;
            case 6:
                $error = 'UPLOAD_ERR_NO_TMP_DIR';
                $message = 'Missing a temporary folder.';
                break;
            case 7:
                $error = 'UPLOAD_ERR_CANT_WRITE';
                $message = 'Failed to write file to disk.';
                break;
            case 8:
                $error = 'UPLOAD_ERR_EXTENSION';
                $message = 'A PHP extension stopped the file upload';
        }

        $this->response(422, [
            'error' => $error,
            'message' => $message
        ]);
    }

    /**
     * Sets json output response
     *
     * @param  int    $status
     * @param  array  $data
     */
    private function response(int $status, array $data) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit(0);
    }

}
