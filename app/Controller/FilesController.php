<?php

App::uses('AppController', 'Controller');

/**
 * Files Controller
 *
 * @property File $File
 * @property PaginatorComponent $Paginator
 */
class FilesController extends AppController {

    public function index() {
        $files = $this->File->find('all');
        $this->set(array(
            'files' => $files,
            '_serialize' => array('files')
        ));
    }

    public function view($id = null) {
        
    }

    public function add() {
        if (empty($_FILES)) {
            $this->showError(400, 'No files');
            return false;
        }

        $dir = WWW_ROOT . 'uploadFiles';

        $tempPath = $_FILES['file']['tmp_name'];
        $hash = time() . md5(rand());
        $uploadPath = $dir . DIRECTORY_SEPARATOR . $hash;

        move_uploaded_file($tempPath, $uploadPath);

        $file = $this->File->create();
        $file['filename'] = $hash;
        $file['original_filename'] = $_FILES['file']['name'];
        $file = $this->File->save($file);

        $this->set(array(
            'file' => $file,
            '_serialize' => array('file')
        ));
    }

    public function edit($id = null) {
        
    }

    public function delete($id = null) {
        
    }

}
