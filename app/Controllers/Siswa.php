<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class Siswa extends BaseController
{
    protected $validation;
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('siswa'),
            'title'         => ucwords('siswa')
        ];

        return view('siswa', $data);
    }

    // buatlah CRUD AJAX table siswa dengan field id 	nama_siswa 	id_kelas 	nisn 	alamat 	email 	foto_profil 	password
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->siswaModel->select()->where('id', $id)->get()->getRowArray();
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

        $result = $this->siswaModel->select('siswa.*, kelas.nama_kelas')->join('kelas', 'kelas.id = siswa.id_kelas')->get()->getResultArray();
        
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->nama_siswa,
                $value->nama_kelas,
                $value->nisn,
                $value->alamat,
                $value->email,
                $value->foto_profil,
                $ops
            );
            $no++;
        }

        return $this->response->setJSON($response);
    }

    public function insert(){
        $response = array();

        $data = [
            'nama_siswa'    => $this->request->getPost('nama_siswa'),
            'id_kelas'      => $this->request->getPost('id_kelas'),
            'nisn'          => $this->request->getPost('nisn'),
            'alamat'        => $this->request->getPost('alamat'),
            'email'         => $this->request->getPost('email'),
            'foto_profil'   => $this->request->getPost('foto_profil'),
            'password'      => $this->request->getPost('password'),
        ];

        $this->validation->run($data, 'siswa');
        $errors = $this->validation->getErrors();

        if (!$errors) {
            $result = $this->siswaModel->insert($data);
            if ($result) {
                $response['status'] = true;
                $response['message'] = 'Data berhasil ditambahkan';
            } else {
                $response['status'] = false;
                $response['message'] = 'Data gagal ditambahkan';
            }
        } else {
            $response['status'] = false;
            $response['message'] = $errors;
        }

        return $this->response->setJSON($response);
    }

    public function update(){
        $response = array();

        $id = $this->request->getPost('id');

        $data = [
            'nama_siswa'    => $this->request->getPost('nama_siswa'),
            'id_kelas'      => $this->request->getPost('id_kelas'),
            'nisn'          => $this->request->getPost('nisn'),
            'alamat'        => $this->request->getPost('alamat'),
            'email'         => $this->request->getPost('email'),
            'foto_profil'   => $this->request->getPost('foto_profil'),
            'password'      => $this->request->getPost('password'),
        ];

        $this->validation->run($data, 'siswa');
        $errors = $this->validation->getErrors();

        if (!$errors) {
            $result = $this->siswaModel->update($id, $data);
            if ($result) {
                $response['status'] = true;
                $response['message'] = 'Data berhasil diubah';
            } else {
                $response['status'] = false;
                $response['message'] = 'Data gagal diubah';
            }
        } else {
            $response['status'] = false;
            $response['message'] = $errors;
        }

        return $this->response->setJSON($response);
    }

    public function delete(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->siswaModel->delete($id);
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
