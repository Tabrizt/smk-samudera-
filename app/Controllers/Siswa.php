<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\SiswaModel;

class Siswa extends BaseController
{

	protected $siswaModel;
	protected $validation;

	public function __construct()
	{
		$this->siswaModel = new SiswaModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> ucwords('siswa'),
			'title'     		=> ucwords('siswa')
		];

		return view('user/siswa', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->siswaModel->select()->findAll();
		$no = 1;
		foreach ($result as $key => $value) {
			$ops = '<div class="btn-group text-white">';
			$ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
			$ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
			$ops .= '</div>';
			$data['data'][$key] = array(
				$no,
				$value->nama_siswa,
				$value->id_kelas,
				$value->nisn,
				$value->alamat,
				$value->email,
				$value->foto_profil,
				$value->password,
				$value->created_at,
				$value->updated_at,

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

			$data = $this->siswaModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['nama_siswa'] = $this->request->getPost('nama_siswa');
		$fields['id_kelas'] = $this->request->getPost('id_kelas');
		$fields['nisn'] = $this->request->getPost('nisn');
		$fields['alamat'] = $this->request->getPost('alamat');
		$fields['email'] = $this->request->getPost('email');
		$fields['foto_profil'] = $this->request->getPost('foto_profil');
		$fields['password'] = $this->request->getPost('password');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'nama_siswa' => ['label' => 'Nama siswa', 'rules' => 'required|min_length[0]|max_length[200]'],
			'id_kelas' => ['label' => 'Id kelas', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
			'nisn' => ['label' => 'Nisn', 'rules' => 'required|min_length[0]|max_length[12]'],
			'alamat' => ['label' => 'Alamat', 'rules' => 'required|min_length[0]'],
			'email' => ['label' => 'Email', 'rules' => 'required|valid_email|min_length[0]|max_length[200]'],
			'foto_profil' => ['label' => 'Foto profil', 'rules' => 'required|min_length[0]|max_length[200]'],
			'password' => ['label' => 'Password', 'rules' => 'required|min_length[0]|max_length[200]'],
			'created_at' => ['label' => 'Created at', 'rules' => 'required|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'required|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->siswaModel->insert($fields)) {

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
		$fields['nama_siswa'] = $this->request->getPost('nama_siswa');
		$fields['id_kelas'] = $this->request->getPost('id_kelas');
		$fields['nisn'] = $this->request->getPost('nisn');
		$fields['alamat'] = $this->request->getPost('alamat');
		$fields['email'] = $this->request->getPost('email');
		$fields['foto_profil'] = $this->request->getPost('foto_profil');
		$fields['password'] = $this->request->getPost('password');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'nama_siswa' => ['label' => 'Nama siswa', 'rules' => 'required|min_length[0]|max_length[200]'],
			'id_kelas' => ['label' => 'Id kelas', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
			'nisn' => ['label' => 'Nisn', 'rules' => 'required|min_length[0]|max_length[12]'],
			'alamat' => ['label' => 'Alamat', 'rules' => 'required|min_length[0]'],
			'email' => ['label' => 'Email', 'rules' => 'required|valid_email|min_length[0]|max_length[200]'],
			'foto_profil' => ['label' => 'Foto profil', 'rules' => 'required|min_length[0]|max_length[200]'],
			'password' => ['label' => 'Password', 'rules' => 'required|min_length[0]|max_length[200]'],
			'created_at' => ['label' => 'Created at', 'rules' => 'required|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'required|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->siswaModel->update($fields['id'], $fields)) {

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

			if ($this->siswaModel->where('id', $id)->delete()) {

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
