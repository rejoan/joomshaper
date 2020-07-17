<?php
require_once './includes/DBManage.php';
/**
 *  PHP Save Image
 *
 */
$img = new Saver();
$img->saveStyles();

class Saver {


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
    public function saveStyles() {
        $imageStyle = $_POST['style'];
        $imageID = (int) $_POST['imgID'];
        $dbCommon = new DBManage();
        $mysqli = $dbCommon->connectDatabase();
        $result = $mysqli->query('UPDATE images SET styles="'.$imageStyle.'" WHERE id='.$imageID);
        
        $result2 = $mysqli->query('SELECT * FROM images WHERE id='.$imageID);
        $row = $result2->fetch_assoc();
        $imageStyle = $row['styles'];
        
        $mysqli->close();
        return $this->response(200, ['style' => $imageStyle]);
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
