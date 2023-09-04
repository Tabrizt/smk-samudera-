<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UjianModel;

class Ujian extends BaseController
{
    protected $validation;
    protected $ujianModel;

    public function __construct()
    {
        $this->ujianModel = new UjianModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    => ucwords('ujian'),
            'title'         => ucwords('ujian')
        ];

        return view('ujian', $data);
    }

    // buatlah CRUD AJAX table ujian dengan field id 	nama_ujian 	waktu_mulai 	waktu_selesai 	soal 	kunci_jawaban 	guru_mapel_id 	status 	pertemuan_id
    public function getOne()
    {
        $id = $this->request->getPost('id');
        $data = $this->ujianModel->find($id);
        echo json_encode($data);
    }

    public function getAll()
    {
        $response = array();

        $result = $this->ujianModel->select()->get()->getResultArray();
        $no = 1;
        foreach ($result as $key => $value) {
            $ops = '<div class="btn-group text-white">';
            $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
            $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
            $ops .= '</div>';
            $data['data'][$key] = array(
                $no,
                $value->nama_ujian,
                $value->waktu_mulai,
                $value->waktu_selesai,
                $value->soal,
                $value->kunci_jawaban,
                $value->guru_mapel_id,
                $value->status,
                $value->pertemuan_id,
            );
            $no++;
        }

        return $this->response->setJSON($response);
    }

    public function add()
    {
        $data = [
            'nama_ujian'        => $this->request->getPost('nama_ujian'),
            'waktu_mulai'       => $this->request->getPost('waktu_mulai'),
            'waktu_selesai'     => $this->request->getPost('waktu_selesai'),
            'soal'              => $this->request->getPost('soal'),
            'kunci_jawaban'     => $this->request->getPost('kunci_jawaban'),
            'guru_mapel_id'     => $this->request->getPost('guru_mapel_id'),
            'status'            => $this->request->getPost('status'),
            'pertemuan_id'      => $this->request->getPost('pertemuan_id'),
        ];

        if ($this->validation->run($data, 'ujian') == FALSE) {
            $data = [
                'nama_ujian'        => $this->validation->getError('nama_ujian'),
                'waktu_mulai'       => $this->validation->getError('waktu_mulai'),
                'waktu_selesai'     => $this->validation->getError('waktu_selesai'),
                'soal'              => $this->validation->getError('soal'),
                'kunci_jawaban'     => $this->validation->getError('kunci_jawaban'),
                'guru_mapel_id'     => $this->validation->getError('guru_mapel_id'),
                'status'            => $this->validation->getError('status'),
                'pertemuan_id'      => $this->validation->getError('pertemuan_id'),
            ];
            echo json_encode($data);
        } else {
            $this->ujianModel->save($data);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function update(){
        $response = array();

        $id = $this->request->getPost('id');

        $data = [
            'nama_ujian'        => $this->request->getPost('nama_ujian'),
            'waktu_mulai'       => $this->request->getPost('waktu_mulai'),
            'waktu_selesai'     => $this->request->getPost('waktu_selesai'),
            'soal'              => $this->request->getPost('soal'),
            'kunci_jawaban'     => $this->request->getPost('kunci_jawaban'),
            'guru_mapel_id'     => $this->request->getPost('guru_mapel_id'),
            'status'            => $this->request->getPost('status'),
            'pertemuan_id'      => $this->request->getPost('pertemuan_id'),
        ];

        if ($this->validation->run($data, 'ujian') == FALSE) {
            $data = [
                'nama_ujian'        => $this->validation->getError('nama_ujian'),
                'waktu_mulai'       => $this->validation->getError('waktu_mulai'),
                'waktu_selesai'     => $this->validation->getError('waktu_selesai'),
                'soal'              => $this->validation->getError('soal'),
                'kunci_jawaban'     => $this->validation->getError('kunci_jawaban'),
                'guru_mapel_id'     => $this->validation->getError('guru_mapel_id'),
                'status'            => $this->validation->getError('status'),
                'pertemuan_id'      => $this->validation->getError('pertemuan_id'),
            ];
            echo json_encode($data);
        } else {
            $this->ujianModel->update($id, $data);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function delete(){
        $id = $this->request->getPost('id');
        $this->ujianModel->delete($id);
        echo json_encode(array("status" => TRUE));
    }


}
