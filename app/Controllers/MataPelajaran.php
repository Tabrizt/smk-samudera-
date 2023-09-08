<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\MatapelajaranModel;

class Matapelajaran extends BaseController
{

	protected $matapelajaranModel;
	protected $validation;

	public function __construct()
	{
		$this->matapelajaranModel = new MataPelajaranModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> ucwords('matapelajaran'),
			'title'     		=> ucwords('mata_pelajaran')
		];

		return view('user/matapelajaran', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->matapelajaranModel->select()->findAll();
		$no = 1;
		foreach ($result as $key => $value) {
			$ops = '<div class="btn-group text-white">';
			$ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
			$ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
			$ops .= '</div>';
			$data['data'][$key] = array(
				$no,
				$value->nama_mapel,
				$value->waktu_mulai,
				$value->waktu_selesai,
				$value->gambar_header,

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

			$data = $this->matapelajaranModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['nama_mapel'] = $this->request->getPost('nama_mapel');
		$fields['waktu_mulai'] = $this->request->getPost('waktu_mulai');
		$fields['waktu_selesai'] = $this->request->getPost('waktu_selesai');
		$fields['gambar_header'] = $this->request->getPost('gambar_header');


		$this->validation->setRules([
			'nama_mapel' => ['label' => 'Nama mapel', 'rules' => 'required|min_length[0]|max_length[200]'],
			'waktu_mulai' => ['label' => 'Waktu mulai', 'rules' => 'required|valid_date|min_length[0]'],
			'waktu_selesai' => ['label' => 'Waktu selesai', 'rules' => 'required|valid_date|min_length[0]'],
			'gambar_header' => ['label' => 'Gambar header', 'rules' => 'required|min_length[0]|max_length[200]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->matapelajaranModel->insert($fields)) {

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
		$fields['nama_mapel'] = $this->request->getPost('nama_mapel');
		$fields['waktu_mulai'] = $this->request->getPost('waktu_mulai');
		$fields['waktu_selesai'] = $this->request->getPost('waktu_selesai');
		$fields['gambar_header'] = $this->request->getPost('gambar_header');


		$this->validation->setRules([
			'nama_mapel' => ['label' => 'Nama mapel', 'rules' => 'required|min_length[0]|max_length[200]'],
			'waktu_mulai' => ['label' => 'Waktu mulai', 'rules' => 'required|valid_date|min_length[0]'],
			'waktu_selesai' => ['label' => 'Waktu selesai', 'rules' => 'required|valid_date|min_length[0]'],
			'gambar_header' => ['label' => 'Gambar header', 'rules' => 'required|min_length[0]|max_length[200]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->matapelajaranModel->update($fields['id'], $fields)) {

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

			if ($this->matapelajaranModel->where('id', $id)->delete()) {

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
