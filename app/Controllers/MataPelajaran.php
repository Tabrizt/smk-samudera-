<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MataPelajaranModel;

class MataPelajaran extends BaseController
{
    protected $validation;
    protected $mataPelajaranModel;

    public function __construct()
    {
        $this->mataPelajaranModel = new MataPelajaranModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('mata pelajaran'),
            'title'         => ucwords('mata pelajaran')
        ];

        return view('mata_pelajaran', $data);
    }

    // buatlah CRUD AJAX table mata_pelajaran dengan field id 	nama_mapel 	waktu_mulai 	waktu_selesai 	gambar_header
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->mataPelajaranModel->select()->where('id', $id)->get()->getRowArray();
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

        $result = $this->mataPelajaranModel->select()->findAll();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->nama_mapel,
                $value->waktu_mulai,
                $value->waktu_selesai,
                $value->gambar_header,
                $ops
            );
            $no++;
        }

        return $this->response->setJSON($data);
    }

    public function save(){
        $response = array();

        $id = $this->request->getPost('id');
        $nama_mapel = $this->request->getPost('nama_mapel');
        $waktu_mulai = $this->request->getPost('waktu_mulai');
        $waktu_selesai = $this->request->getPost('waktu_selesai');
        $gambar_header = $this->request->getPost('gambar_header');

        $data = array(
            'nama_mapel' => $nama_mapel,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'gambar_header' => $gambar_header
        );

        if ($id == '') {
            $result = $this->mataPelajaranModel->insert($data);
        } else {
            $result = $this->mataPelajaranModel->update($id, $data);
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

        $result = $this->mataPelajaranModel->delete($id);
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
