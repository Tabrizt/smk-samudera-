<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MateriModel;

class Materi extends BaseController
{
    protected $validation;
    protected $materiModel;

    public function __construct()
    {
        $this->materiModel = new MateriModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('materi'),
            'title'         => ucwords('materi')
        ];

        return view('materi', $data);
    }

    // buatlah CRUD AJAX table materi dengan field id 	nama_materi 	deskripsi 	file 	waktu_mulai 	waktu_selesai 	guru_mapel_id 	pertemuan_id
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->materiModel->select()->where('id', $id)->get()->getRowArray();
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

        $result = $this->materiModel->select()->findAll();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->nama_materi,
                $value->deskripsi,
                $value->file,
                $value->waktu_mulai,
                $value->waktu_selesai,
                $value->guru_mapel_id,
                $value->pertemuan_id,
                $ops
            );
            $no++;
        }

        return $this->response->setJSON($data);
    }

    public function save(){
        $response = array();

        $id = $this->request->getPost('id');
        $nama_materi = $this->request->getPost('nama_materi');
        $deskripsi = $this->request->getPost('deskripsi');
        $file = $this->request->getPost('file');
        $waktu_mulai = $this->request->getPost('waktu_mulai');
        $waktu_selesai = $this->request->getPost('waktu_selesai');
        $guru_mapel_id = $this->request->getPost('guru_mapel_id');
        $pertemuan_id = $this->request->getPost('pertemuan_id');

        $data = array(
            'nama_materi' => $nama_materi,
            'deskripsi' => $deskripsi,
            'file' => $file,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'guru_mapel_id' => $guru_mapel_id,
            'pertemuan_id' => $pertemuan_id
        );

        if ($id == '') {
            $result = $this->materiModel->insert($data);
        } else {
            $result = $this->materiModel->update($id, $data);
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

        $result = $this->materiModel->delete($id);
        if ($result) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil dihapus';
        } else {
            $response['status'] = false;
            $response['message'] = 'Data gagal dihapus';
        }

        return $this->response->setJSON($response);
    }

    public function upload(){
        $response = array();

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $file->move('uploads', $fileName);

        $response['status'] = true;
        $response['fileName'] = $fileName;

        return $this->response->setJSON($response);
    }
}
