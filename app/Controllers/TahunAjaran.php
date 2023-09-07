<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\TahunAjaranModel;

class Tahunajaran extends BaseController
{

	protected $tahunajaranModel;
	protected $validation;

	public function __construct()
	{
		$this->tahunajaranModel = new TahunAjaranModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> ucwords('tahunajaran'),
			'title'     		=> ucwords('tahun_ajaran')
		];

		return view('user/tahunajaran', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->tahunajaranModel->select()->findAll();
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

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->tahunajaranModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['tahun'] = $this->request->getPost('tahun');
		$fields['status'] = $this->request->getPost('status');


		$this->validation->setRules([
			'tahun' => ['label' => 'Tahun', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
			'status' => ['label' => 'Status', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->tahunajaranModel->insert($fields)) {

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
		$fields['tahun'] = $this->request->getPost('tahun');
		$fields['status'] = $this->request->getPost('status');


		$this->validation->setRules([
			'tahun' => ['label' => 'Tahun', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
			'status' => ['label' => 'Status', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->tahunajaranModel->update($fields['id'], $fields)) {

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

			if ($this->tahunajaranModel->where('id', $id)->delete()) {

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
