<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TugasModel;

class Tugas extends BaseController
{
    protected $validation;
    protected $tugasModel;

    public function __construct()
    {
        $this->tugasModel = new TugasModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('tugas'),
            'title'         => ucwords('tugas')
        ];

        return view('tugas', $data);
    }

    // buatlah CRUD AJAX table tugas dengan field id nama_tugas deskripsi file waktu_mulai waktu_selesai guru_mapel_id pertemuan_id
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->tugasModel->select()->where('id', $id)->get()->getRowArray();
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
        $response = array();

        $result = $this->tugasModel->select()->get()->getResultArray();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->nama_tugas,
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

        return $this->response->setJSON($response);
    }

    public function create(){
        $response = array();

        $this->validation->setRules([
            'nama_tugas' => 'required',
            'deskripsi' => 'required',
            'file' => 'uploaded[file]|mime_in[file,image/jpg,image/jpeg,image/png,application/pdf]|max_size[file,2048]',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'guru_mapel_id' => 'required',
            'pertemuan_id' => 'required'
        ]);

        if ($this->validation->withRequest($this->request)->run()) {
            $file = $this->request->getFile('file');
            $fileName = $file->getRandomName();
            $file->move('uploads/tugas', $fileName);

            $data = [
                'nama_tugas' => $this->request->getPost('nama_tugas'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'file' => $fileName,
                'waktu_mulai' => $this->request->getPost('waktu_mulai'),
                'waktu_selesai' => $this->request->getPost('waktu_selesai'),
                'guru_mapel_id' => $this->request->getPost('guru_mapel_id'),
                'pertemuan_id' => $this->request->getPost('pertemuan_id')
            ];

            $result = $this->tugasModel->insert($data);
            if ($result) {
                $response['status'] = true;
                $response['message'] = 'Data berhasil ditambahkan';
            } else {
                $response['status'] = false;
                $response['message'] = 'Data gagal ditambahkan';
            }
        } else {
            $response['status'] = false;
            $response['message'] = $this->validation->getErrors();
        }

        return $this->response->setJSON($response);
    }

    public function remove(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->tugasModel->delete($id);
        if ($result) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil dihapus';
        } else {
            $response['status'] = false;
            $response['message'] = 'Data gagal dihapus';
        }

        return $this->response->setJSON($response);
    }

    public function update()
    {
        $response = array();

        $id = $this->request->getPost('id');

        $this->validation->setRules([
            'nama_tugas' => 'required',
            'deskripsi' => 'required',
            'file' => 'uploaded[file]|mime_in[file,image/jpg,image/jpeg,image/png,application/pdf]|max_size[file,2048]',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'guru_mapel_id' => 'required',
            'pertemuan_id' => 'required'
        ]);

        if ($this->validation->withRequest($this->request)->run()) {
            $file = $this->request->getFile('file');
            $fileName = $file->getRandomName();
            $file->move('uploads/tugas', $fileName);

            $data = [
                'nama_tugas' => $this->request->getPost('nama_tugas'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'file' => $fileName,
                'waktu_mulai' => $this->request->getPost('waktu_mulai'),
                'waktu_selesai' => $this->request->getPost('waktu_selesai'),
                'guru_mapel_id' => $this->request->getPost('guru_mapel_id'),
                'pertemuan_id' => $this->request->getPost('pertemuan_id')
            ];

            $result = $this->tugasModel->update($id, $data);
            if ($result) {
                $response['status'] = true;
                $response['message'] = 'Data berhasil diubah';
            } else {
                $response['status'] = false;
                $response['message'] = 'Data gagal diubah';
            }
        } else {
            $response['status'] = false;
            $response['message'] = $this->validation->getErrors();
        }

        return $this->response->setJSON($response);
    }
}
