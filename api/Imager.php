<?php

/**
 *  PHP upload
 *
 */
$img = new Imager();
$img->getImages();

class Imager {

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
    public function getImages() {
        $images = glob(self::UPLOAD_DIR . '/*.jpg');
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
