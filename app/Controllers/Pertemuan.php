<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PertemuanModel;

class Pertemuan extends BaseController
{
    protected $validation;
    protected $pertemuanModel;

    public function __construct()
    {
        $this->pertemuanModel = new PertemuanModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('pertemuan'),
            'title'         => ucwords('pertemuan')
        ];

        return view('pertemuan', $data);
    }

    // buatlah CRUD AJAX table pertemuan dengan field id 	minggu_pertemuan 	mapel_id 	
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->pertemuanModel->select()->where('id', $id)->get()->getRowArray();
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

        $result = $this->pertemuanModel->select()->findAll();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->minggu_pertemuan,
                $value->mapel_id,
                $ops
            );
            $no++;
        }

        return $this->response->setJSON($data);
    }

    public function save(){
        $response = array();

        $id = $this->request->getPost('id');
        $minggu_pertemuan = $this->request->getPost('minggu_pertemuan');
        $mapel_id = $this->request->getPost('mapel_id');

        $data = array(
            'minggu_pertemuan' => $minggu_pertemuan,
            'mapel_id' => $mapel_id
        );

        $this->validation->run($data, 'pertemuan');
        $errors = $this->validation->getErrors();

        if (!$errors) {
            if ($id) {
                $update = $this->pertemuanModel->update($id, $data);
                if ($update) {
                    $response['status'] = true;
                    $response['message'] = 'Data berhasil diubah';
                } else {
                    $response['status'] = false;
                    $response['message'] = 'Data gagal diubah';
                }
            } else {
                $save = $this->pertemuanModel->insert($data);
                if ($save) {
                    $response['status'] = true;
                    $response['message'] = 'Data berhasil disimpan';
                } else {
                    $response['status'] = false;
                    $response['message'] = 'Data gagal disimpan';
                }
            }
        } else {
            $response['status'] = false;
            $response['message'] = $errors;
        }

        return $this->response->setJSON($response);
    }

    public function remove(){
        $response = array();

        $id = $this->request->getPost('id');

        $delete = $this->pertemuanModel->delete($id);
        if ($delete) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil dihapus';
        } else {
            $response['status'] = false;
            $response['message'] = 'Data gagal dihapus';
        }

        return $this->response->setJSON($response);
    }
}
