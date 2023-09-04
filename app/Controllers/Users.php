<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\JurusanModel;

class Jurusan extends BaseController
{

	protected $jurusanModel;
	protected $validation;

	public function __construct()
	{
		$this->jurusanModel = new JurusanModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> ucwords('jurusan'),
			'title'     		=> ucwords('jurusan')
		];

		return view('jurusan', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->jurusanModel->select()->findAll();
		$no = 1;
		foreach ($result as $key => $value) {
			$ops = '<div class="btn-group text-white">';
			$ops .= '<a class="btn btn-dark" onClick="save(' . $value->id_jurusan . ')"><i class="fas fa-pencil-alt"></i></a>';
			$ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id_jurusan . ')"><i class="fas fa-trash-alt"></i></a>';
			$ops .= '</div>';
			$data['data'][$key] = array(
				$no,
				$value->nama_jurusan,

				$ops
			);
			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id_jurusan');

		if ($this->validation->check($id, 'required')) {

			$data = $this->jurusanModel->where('id_jurusan', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_jurusan'] = $this->request->getPost('id_jurusan');
		$fields['nama_jurusan'] = $this->request->getPost('nama_jurusan');


		$this->validation->setRules([
			'nama_jurusan' => ['label' => 'Nama jurusan', 'rules' => 'required|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->jurusanModel->insert($fields)) {

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

		$fields['id_jurusan'] = $this->request->getPost('id_jurusan');
		$fields['nama_jurusan'] = $this->request->getPost('nama_jurusan');


		$this->validation->setRules([
			'nama_jurusan' => ['label' => 'Nama jurusan', 'rules' => 'required|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->jurusanModel->update($fields['id_jurusan'], $fields)) {

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

		$id = $this->request->getPost('id_jurusan');

		if (!$this->validation->check($id, 'required')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->jurusanModel->where('id_jurusan', $id)->delete()) {

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