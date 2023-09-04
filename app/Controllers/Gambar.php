<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GambarModel;

class Gambar extends BaseController
{
    protected $validation;
    protected $gambarModel;

    public function __construct()
    {
        $this->gambarModel = new GambarModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('gambar'),
            'title'         => ucwords('gambar')
        ];

        return view('gambar', $data);
    }

    // buatlah CRUD AJAX table gambar dengan field id 	judul 	nama_file 	pengguna_id 	status_pengguna
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->gambarModel->select()->where('id', $id)->get()->getRowArray();
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

        $result = $this->gambarModel->select()->findAll();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->judul,
                $value->nama_file,
                $value->pengguna_id,
                $value->status_pengguna,
                $ops
            );
            $no++;
        }

        return $this->response->setJSON($data);
    }

    public function save(){
        $response = array();

        $id = $this->request->getPost('id');
        $judul = $this->request->getPost('judul');
        $nama_file = $this->request->getPost('nama_file');
        $pengguna_id = $this->request->getPost('pengguna_id');
        $status_pengguna = $this->request->getPost('status_pengguna');

        $data = array(
            'judul' => $judul,
            'nama_file' => $nama_file,
            'pengguna_id' => $pengguna_id,
            'status_pengguna' => $status_pengguna
        );

        if ($id == '') {
            $result = $this->gambarModel->insert($data);
        } else {
            $result = $this->gambarModel->update($id, $data);
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

        $result = $this->gambarModel->delete($id);
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
