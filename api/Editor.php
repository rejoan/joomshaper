<?php
require_once './includes/DBManage.php';
/**
 *  PHP upload
 *
 */
$img = new Editor();
$img->getImageById();

class Editor {


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
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
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
    public function getImageById() {
        $imageID = (int) $_GET['id'];
        $dbCommon = new DBManage();
        $mysqli = $dbCommon->connectDatabase();
        $result = $mysqli->query('SELECT * FROM images WHERE id='.$imageID);
        $row = $result->fetch_assoc();
        $image = $row['file_name'];
        $mysqli->close();
        return $this->response(200, ['file' => $image]);
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
