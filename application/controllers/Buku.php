<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Buku extends CI_Controller
{
	public function index()
	{
		$this->load->model('M_Buku');

		$buku = $this->M_Buku->getAllBuku();

		$data = [
			'title' => 'Halaman Buku',
			'page'  => 'buku/v_buku',
			'buku'  => $buku
		];

		$this->load->view('index', $data);
	}

	public function add()
	{
		$data = [
			'title' => 'Tambah Buku',
			'page'  => 'buku/v_addBuku'
		];

		$this->load->view('index', $data);
	}

	public function store()
	{
		$this->form_validation->set_rules('judul', 'Judul', 'required', [
			'required' => 'Judul harus diisi'
		]);
		$this->form_validation->set_rules('penulis', 'penulis', 'required', [
			'required' => 'Penulis harus diisi'
		]);
		$this->form_validation->set_rules('penerbit', 'Penerbit', 'required', [
			'required' => 'Penerbit harus diisi'
		]);
		$this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|min_length[4]|max_length[4]', [
			'required' => 'Tahun harus diisi',
			'numeric' => 'Tahun harus berupa angka'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->add();
		} else {
			$judul    = $this->input->post('judul', true);
			$penulis  = $this->input->post('penulis', true);
			$penerbit = $this->input->post('penerbit', true);
			$tahun    = $this->input->post('tahun', true);

			$cover = $_FILES['cover']['name'];

			if ($cover) {
				$this->load->library('upload');
				$config['upload_path']   = './upload';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size']      = 5000; // 5 mb
				$config['remove_spaces'] = TRUE;
				$config['detect_mime']   = TRUE;
				$config['encrypt_name']  = TRUE;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('cover')) {
					$this->session->set_flashdata('error', $this->upload->display_errors());

					redirect('buku/add', 'refresh');
				} else {
					$upload_data = $this->upload->data();

					$data = [
						'judul'    => $judul,
						'penulis'  => $penulis,
						'penerbit' => $penerbit,
						'tahun'    => $tahun,
						'cover'    => $upload_data['file_name']
					];
				}
			} else {
				$data = [
					'judul'    => $judul,
					'penulis'  => $penulis,
					'penerbit' => $penerbit,
					'tahun'    => $tahun
				];
			}

			$insert = $this->db->insert('buku', $data);

			if ($insert) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
			}

			redirect('buku', 'refresh');
		}
	}

	public function edit($id)
	{
		$this->load->model('M_Buku');

		$buku = $this->M_Buku->getOneBuku($id);

		$data = [
			'title' => 'Edit Buku',
			'page'  => 'buku/v_editBuku',
			'buku'  => $buku
		];

		$this->load->view('index', $data);
	}

	public function update()
	{
		$this->load->model('M_Buku');
		$id = $this->input->post('id', true);

		$this->form_validation->set_rules('judul', 'Judul', 'required', [
			'required' => 'Judul harus diisi'
		]);
		$this->form_validation->set_rules('penulis', 'penulis', 'required', [
			'required' => 'Penulis harus diisi'
		]);
		$this->form_validation->set_rules('penerbit', 'Penerbit', 'required', [
			'required' => 'Penerbit harus diisi'
		]);
		$this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|min_length[4]|max_length[4]', [
			'required' => 'Tahun harus diisi',
			'numeric' => 'Tahun harus berupa angka'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->edit($id);
		} else {
			$judul    = $this->input->post('judul', true);
			$penulis  = $this->input->post('penulis', true);
			$penerbit = $this->input->post('penerbit', true);
			$tahun    = $this->input->post('tahun', true);

			$cover = $_FILES['cover']['name'];

			if ($cover) {
				$this->load->library('upload');
				$config['upload_path']   = './upload';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size']      = 5000; // 5 mb
				$config['remove_spaces'] = TRUE;
				$config['detect_mime']   = TRUE;
				$config['encrypt_name']  = TRUE;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('cover')) {
					$this->session->set_flashdata('error', $this->upload->display_errors());

					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				} else {
					$upload_data = $this->upload->data();

					$data = [
						'judul'    => $judul,
						'penulis'  => $penulis,
						'penerbit' => $penerbit,
						'tahun'    => $tahun,
						'cover'    => $upload_data['file_name']
					];
				}
			} else {
				$data = [
					'judul'    => $judul,
					'penulis'  => $penulis,
					'penerbit' => $penerbit,
					'tahun'    => $tahun
				];
			}
		}

		$buku = $this->M_Buku->getOneBuku($id);

		$this->db->where('id', $id);
		$update = $this->db->update('buku', $data);

		if ($update) {
			if ($cover) {
				if ($buku->cover != null) {
					unlink(FCPATH . 'upload/' . $buku->cover);
				}
			}

			$this->session->set_flashdata('success', 'Data berhasil diedit');
		} else {
			$this->session->set_flashdata('error', 'Data gagal diedit');
		}

		redirect('buku', 'refresh');
	}

	public function delete($id)
	{
		$this->load->model('M_Buku');

		$buku = $this->M_Buku->getOneBuku($id);

		$this->db->where('id', $id);
		$delete = $this->db->delete('buku');

		if ($delete) {
			if ($buku->cover != null) {
				unlink(FCPATH . 'upload/' . $buku->cover);
			}

			$this->session->set_flashdata('success', 'Data berhasil dihapus');
		} else {
			$this->session->set_flashdata('error', 'Data gagal dihapus');
		}

		redirect('buku', 'refresh');
	}
}

  /* End of file User.php */
