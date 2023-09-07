<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\KelasModel;

class Kelas extends BaseController
{

	protected $kelasModel;
	protected $validation;

	public function __construct()
	{
		$this->kelasModel = new KelasModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> ucwords('kelas'),
			'title'     		=> ucwords('kelas')
		];

		return view('user/kelas', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->kelasModel->select()->findAll();
		$no = 1;
		foreach ($result as $key => $value) {
			$ops = '<div class="btn-group text-white">';
			$ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
			$ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
			$ops .= '</div>';
			$data['data'][$key] = array(
				$no,
				$value->id,
				$value->nama_kelas,
				$value->id_tahun_ajar,
				$value->id_jurusan,

				$ops
			);
			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->kelasModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['nama_kelas'] = $this->request->getPost('nama_kelas');
		$fields['id_tahun_ajar'] = $this->request->getPost('id_tahun_ajar');
		$fields['id_jurusan'] = $this->request->getPost('id_jurusan');


		$this->validation->setRules([
			'nama_kelas' => ['label' => 'Nama kelas', 'rules' => 'required|min_length[0]|max_length[200]'],
			'id_tahun_ajar' => ['label' => 'Id tahun ajar', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
			'id_jurusan' => ['label' => 'Id jurusan', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->kelasModel->insert($fields)) {

				$response['success'] = true;
				$response['messages'] = lang("App.insert-success");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("App.insert-error");
			}
		}

		return $this->response->setJSON($response);
	}

	public function edit()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['nama_kelas'] = $this->request->getPost('nama_kelas');
		$fields['id_tahun_ajar'] = $this->request->getPost('id_tahun_ajar');
		$fields['id_jurusan'] = $this->request->getPost('id_jurusan');


		$this->validation->setRules([
			'nama_kelas' => ['label' => 'Nama kelas', 'rules' => 'required|min_length[0]|max_length[200]'],
			'id_tahun_ajar' => ['label' => 'Id tahun ajar', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
			'id_jurusan' => ['label' => 'Id jurusan', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->kelasModel->update($fields['id'], $fields)) {

				$response['success'] = true;
				$response['messages'] = lang("App.update-success");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("App.update-error");
			}
		}

		return $this->response->setJSON($response);
	}

	public function remove()
	{
		$response = array();

		$id = $this->request->getPost('id');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->kelasModel->where('id', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("App.delete-success");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("App.delete-error");
			}
		}

		return $this->response->setJSON($response);
	}
}
