<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruMapelModel;

class GuruMapel extends BaseController
{
    protected $validation;
    protected $guruMapelModel;

    public function __construct()
    {
        $this->guruMapelModel = new GuruMapelModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('guru mapel'),
            'title'         => ucwords('guru mapel')
        ];

        return view('guru_mapel', $data);
    }

    // buatlah CRUD AJAX table guru_mapel dengan field id  guru_id 	mapel_id 	kelas_id
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->guruMapelModel->select()->where('id', $id)->get()->getRowArray();
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

        $result = $this->guruMapelModel->select()->findAll();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->guru_id,
                $value->mapel_id,
                $value->kelas_id,
                $ops
            );
            $no++;
        }

        return $this->response->setJSON($data);
    }

    public function save(){
        $response = array();

        $id = $this->request->getPost('id');
        $guru_id = $this->request->getPost('guru_id');
        $mapel_id = $this->request->getPost('mapel_id');
        $kelas_id = $this->request->getPost('kelas_id');

        $data = array(
            'guru_id' => $guru_id,
            'mapel_id' => $mapel_id,
            'kelas_id' => $kelas_id
        );

        if ($id == '') {
            $result = $this->guruMapelModel->insert($data);
        } else {
            $result = $this->guruMapelModel->update($id, $data);
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

        $result = $this->guruMapelModel->delete($id);
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
