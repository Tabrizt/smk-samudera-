<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TahunAjaranModel;

class TahunAjaran extends BaseController
{
    protected $validation;
    protected $tahunAjaranModel;

    public function __construct()
    {
        $this->tahunAjaranModel = new TahunAjaranModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('tahun ajaran'),
            'title'         => ucwords('tahun ajaran')
        ];

        return view('tahun_ajaran', $data);
    }

    //buatlah CRUD AJAX table tahun ajaran dengan field  id tahun status
    public function getOne(){
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->tahunAjaranModel->select()->where('id', $id)->get()->getRowArray();
        if ($result) {
            $response['status'] = true;
            $response['data'] = $result;
        } else {
            $response['status'] = false;
            $response['data'] = null;
        }

        return $this->response->setJSON($response);
    }

    public function getAll()
    {
        $response = array();

        $result = $this->tahunAjaranModel->select()->get()->getResultArray();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->tahun,
                $value->status,
                $ops
            );
            $no++;
        }

        return $this->response->setJSON($response);
    }

    public function save()
    {
        $response = array();

        $this->validation->setRules([
            'tahun' => [
                'label' => 'Tahun Ajaran',
                'rules' => 'required|is_unique[tahun_ajaran.tahun]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah ada'
                ]
            ]
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            $response['status'] = false;
            $response['errors'] = $this->validation->getErrors();
        } else {
            $data = [
                'tahun' => $this->request->getPost('tahun'),
                'status' => $this->request->getPost('status')
            ];

            $result = $this->tahunAjaranModel->insert($data);
            if ($result) {
                $response['status'] = true;
                $response['message'] = 'Data berhasil disimpan';
            } else {
                $response['status'] = false;
                $response['message'] = 'Data gagal disimpan';
            }
        }

        return $this->response->setJSON($response);
    }

    public function update()
    {
        $response = array();

        $id = $this->request->getPost('id');

        $this->validation->setRules([
            'tahun' => [
                'label' => 'Tahun Ajaran',
                'rules' => 'required|is_unique[tahun_ajaran.tahun,id,' . $id . ']',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah ada'
                ]
            ]
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            $response['status'] = false;
            $response['errors'] = $this->validation->getErrors();
        } else {
            $data = [
                'tahun' => $this->request->getPost('tahun'),
                'status' => $this->request->getPost('status')
            ];

            $result = $this->tahunAjaranModel->update($id, $data);
            if ($result) {
                $response['status'] = true;
                $response['message'] = 'Data berhasil diubah';
            } else {
                $response['status'] = false;
                $response['message'] = 'Data gagal diubah';
            }
        }

        return $this->response->setJSON($response);
    }

    public function delete()
    {
        $response = array();

        $id = $this->request->getPost('id');

        $result = $this->tahunAjaranModel->delete($id);
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
