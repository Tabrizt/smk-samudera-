<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;

class Kelas extends BaseController
{
    protected $validation;
    protected $kelasModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('kelas'),
            'title'         => ucwords('kelas')
        ];

        return view('kelas', $data);
    }

    // buatlah CRUD AJAX table kelas dengan field id nama_kelas id_tahun_ajar id_jurusan
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->kelasModel->select()->where('id', $id)->get()->getRowArray();
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

        $result = $this->kelasModel->select()->findAll();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->nama_kelas,
                $value->id_tahun_ajar,
                $value->id_jurusan,
                $ops
            );
            $no++;
        }

        return $this->response->setJSON($data);
    }

    public function save(){
        $response = array();

        $id = $this->request->getPost('id');
        $nama_kelas = $this->request->getPost('nama_kelas');
        $id_tahun_ajar = $this->request->getPost('id_tahun_ajar');
        $id_jurusan = $this->request->getPost('id_jurusan');

        $data = array(
            'nama_kelas' => $nama_kelas,
            'id_tahun_ajar' => $id_tahun_ajar,
            'id_jurusan' => $id_jurusan
        );

        if ($id == '') {
            $result = $this->kelasModel->insert($data);
        } else {
            $result = $this->kelasModel->update($id, $data);
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

        $result = $this->kelasModel->delete($id);
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
