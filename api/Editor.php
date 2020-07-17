<?php
require_once './includes/DBManage.php';
$img = new Editor();
$img->getImageById();

class Editor {


   /**
    * 
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
     * get image by ID
     * @return json
     */
    public function getImageById() {
        $imageID = (int) $_GET['id'];
        $dbCommon = new DBManage();
        $mysqli = $dbCommon->connectDatabase();
        $result = $mysqli->query('SELECT * FROM images WHERE id='.$imageID);
        $row = $result->fetch_assoc();
        $image = $row['file_name'];
        $imageStyle = $row['styles'];
        $mysqli->close();
        return $this->response(200, ['file' => $image,'filter' => $imageStyle]);
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
