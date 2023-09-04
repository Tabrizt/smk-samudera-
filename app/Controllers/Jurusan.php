<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JurusanModel;

class Jurusan extends BaseController
{
    protected $validation;
    protected $jurusanModel;

    public function __construct()
    {
        $this->jurusanModel = new JurusanModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('jurusan'),
            'title'         => ucwords('jurusan')
        ];

        return view('jurusan', $data);
    }

    // buatlah CRUD AJAX table jurusan dengan field id nama_jurusan
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->jurusanModel->select()->where('id', $id)->get()->getRowArray();
        if ($result) {
            $response['status'] = true;
            $response['data'] = $result;
        } else {
            $response['status'] = false;
            $response['data'] = null;
        }

        return $this->response->setJSON($response);
    }

    public function getAll(){
        $response = $data['data'] = array();

        $result = $this->jurusanModel->select()->findAll();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->nama_jurusan,
                $ops
            );
            $no++;
        }

        return $this->response->setJSON($data);
    }

    public function save(){
        $response = array();

        $id = $this->request->getPost('id');
        $nama_jurusan = $this->request->getPost('nama_jurusan');

        $data = array(
            'nama_jurusan' => $nama_jurusan
        );

        if ($id == '') {
            $result = $this->jurusanModel->insert($data);
        } else {
            $result = $this->jurusanModel->update($id, $data);
        }

        if ($result) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil disimpan';
        } else {
            $response['status'] = false;
            $response['message'] = 'Data gagal disimpan';
        }

        return $this->response->setJSON($response);
    }

    public function remove(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->jurusanModel->delete($id);
        if ($result) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil dihapus';
        } else {
            $response['status'] = false;
            $response['message'] = 'Data gagal dihapus';
        }

        return $this->response->setJSON($response);
    }
}
