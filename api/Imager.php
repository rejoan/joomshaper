<?php
require_once './includes/DBManage.php';
$img = new Imager();
$img->getImages();

class Imager {

    const UPLOAD_DIR = '../Gallery/';

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
     * get uploaded files
     *
     * @return [json] [images name]
     */
    public function getImages() {
        $images = array();
        $dbCommon = new DBManage();
        $mysqli = $dbCommon->connectDatabase();
        $result = $mysqli->query('SELECT * FROM images LIMIT 0,10');
        while ($row = $result->fetch_assoc()) {
            $images[] = array($row['id'],$row['file_name']);
        }
        $mysqli->close();
        return $this->response(200, ['files' => $images]);
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
