<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;

class Absensi extends BaseController
{
    protected $validation;
    protected $absensiModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('absensi'),
            'title'         => ucwords('absensi')
        ];

        return view('absensi', $data);
    }
    
    // buatlah CRUD AJAX table absensi dengan field id guru_mapel_id waktu_mulai waktu_selesai status
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->absensiModel->select()->where('id', $id)->get()->getRowArray();
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

        $result = $this->absensiModel->select()->findAll();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->guru_mapel_id,
                $value->waktu_mulai,
                $value->waktu_selesai,
                $value->status,

                $ops
            );
            $no++;
        }

        return $this->response->setJSON($data);
    }

    public function save(){
        $response = array();

        $id = $this->request->getPost('id');
        $guru_mapel_id = $this->request->getPost('guru_mapel_id');
        $waktu_mulai = $this->request->getPost('waktu_mulai');
        $waktu_selesai = $this->request->getPost('waktu_selesai');
        $status = $this->request->getPost('status');

        $data = array(
            'guru_mapel_id' => $guru_mapel_id,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'status' => $status,
        );

        if ($this->validation->check($id, 'required')) {
            $data['id'] = $id;
            $this->absensiModel->save($data);
            $response['status'] = true;
            $response['message'] = 'Data berhasil disimpan';
        } else {
            $this->absensiModel->save($data);
            $response['status'] = true;
            $response['message'] = 'Data berhasil disimpan';
        }

        return $this->response->setJSON($response);
    }

    public function remove(){
        $response = array();

        $id = $this->request->getPost('id');

        if ($this->validation->check($id, 'required')) {
            $this->absensiModel->delete($id);
            $response['status'] = true;
            $response['message'] = 'Data berhasil dihapus';
        } else {
            $response['status'] = false;
            $response['message'] = 'Data tidak ditemukan';
        }

        return $this->response->setJSON($response);
    }
}
