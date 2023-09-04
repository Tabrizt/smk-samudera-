<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Admin extends BaseController
{
    protected $validation;
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('admin'),
            'title'         => ucwords('admin')
        ];

        return view('admin', $data);
    }

    // buatlah CRUD AJAX table admin dengan field id nama email password
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->adminModel->select()->where('id', $id)->get()->getRowArray();
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

        $result = $this->adminModel->select()->findAll();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->nama,
                $value->email,
                $value->password,

                $ops
            );
            $no++;
        }

        return $this->response->setJSON($data);
    }

    public function save(){
        $response = array();

        $id = $this->request->getPost('id');
        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $data = array(
            'nama' => $nama,
            'email' => $email,
            'password' => $password
        );

        if ($this->validation->check($data, 'admin')) {
            if ($id == '') {
                $result = $this->adminModel->insert($data);
            } else {
                $result = $this->adminModel->update($id, $data);
            }

            if ($result) {
                $response['status'] = true;
                $response['message'] = 'Data berhasil disimpan';
            } else {
                $response['status'] = false;
                $response['message'] = 'Data gagal disimpan';
            }
        } else {
            $response['status'] = false;
            $response['message'] = 'Data gagal disimpan';
            $response['errors'] = $this->validation->getErrors();
        }

        return $this->response->setJSON($response);
    }

    public function remove(){
        $response = array();

        $id = $this->request->getPost('id');

        if ($this->validation->check($id, 'required')) {
            $result = $this->adminModel->delete($id);

            if ($result) {
                $response['status'] = true;
                $response['message'] = 'Data berhasil dihapus';
            } else {
                $response['status'] = false;
                $response['message'] = 'Data gagal dihapus';
            }
        } else {
            $response['status'] = false;
            $response['message'] = 'Data gagal dihapus';
            $response['errors'] = $this->validation->getErrors();
        }

        return $this->response->setJSON($response);
    }


}
