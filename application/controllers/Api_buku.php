<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_buku extends CI_Controller
{
	public function getBuku()
	{
		$this->load->model('M_Buku');

		$buku = $this->M_Buku->getAllBuku();

		$newBuku = [];

		foreach ($buku as $bk) {
			array_push($newBuku, [
				'id'       => (int) $bk->id,
				'judul'    => $bk->judul,
				'penulis'  => $bk->penulis,
				'penerbit' => $bk->penerbit,
				'tahun'    => (int) $bk->tahun,
				'cover'    => ($bk->cover != null) ? base_url('upload/' . $bk->cover) : null
			]);
		}

		$res = [
			'status'  => true,
			'message' => 'Data buku ditemukan',
			'data'    => $newBuku
		];

		$this->output->set_header('Content-Type: application/json');
		echo json_encode($res);
	}

	public function addBuku()
	{
		$this->form_validation->set_rules('judul', 'Judul', 'required', [
			'required' => 'judul harus diisi'
		]);
		$this->form_validation->set_rules('penulis', 'penulis', 'required', [
			'required' => 'penulis harus diisi'
		]);
		$this->form_validation->set_rules('penerbit', 'Penerbit', 'required', [
			'required' => 'penerbit harus diisi'
		]);
		$this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|min_length[4]|max_length[4]', [
			'required' => 'tahun harus diisi',
			'numeric'  => 'Tahun harus berupa angka'
		]);

		if ($this->form_validation->run() == FALSE) {
			$res = [
				'status'  => false,
				'message' => rtrim(str_replace("\n", ", ", strip_tags(validation_errors())), ', ')
			];

			$this->output->set_header('Content-Type: application/json');
			echo json_encode($res);
		} else {
			$judul    = $this->input->post('judul', true);
			$penulis  = $this->input->post('penulis', true);
			$penerbit = $this->input->post('penerbit', true);
			$tahun    = $this->input->post('tahun', true);

			$cover = (isset($_FILES['cover']) ? $_FILES['cover']['name'] : '');

			if ($cover) {
				$this->load->library('upload');
				$config['upload_path']   = './upload';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size']      = 5000;            // 5 mb
				$config['remove_spaces'] = TRUE;
				$config['detect_mime']   = TRUE;
				$config['encrypt_name']  = TRUE;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('cover')) {
					$res = [
						'status'  => false,
						'message' => strip_tags($this->upload->display_errors())
					];

					$this->output->set_header('Content-Type: application/json');
					echo json_encode($res);
				} else {
					$upload_data = $this->upload->data();

					$data = [
						'judul'    => $judul,
						'penulis'  => $penulis,
						'penerbit' => $penerbit,
						'tahun'    => $tahun,
						'cover'    => $upload_data['file_name']
					];

					$insert = $this->db->insert('buku', $data);

					if ($insert) {
						$res = [
							'status'  => true,
							'message' => 'Data berhasil disimpan'
						];
					} else {
						$res = [
							'status'  => false,
							'message' => 'Data gagal disimpan'
						];
					}

					$this->output->set_header('Content-Type: application/json');
					echo json_encode($res);
				}
			} else {
				$data = [
					'judul'    => $judul,
					'penulis'  => $penulis,
					'penerbit' => $penerbit,
					'tahun'    => $tahun
				];

				$insert = $this->db->insert('buku', $data);

				if ($insert) {
					$res = [
						'status'  => true,
						'message' => 'Data berhasil disimpan'
					];
				} else {
					$res = [
						'status'  => false,
						'message' => 'Data gagal disimpan'
					];
				}

				$this->output->set_header('Content-Type: application/json');
				echo json_encode($res);
			}
		}
	}

	public function editBuku()
	{
		$this->load->model('M_Buku');

		$this->form_validation->set_rules('id', 'ID Buku', 'required', [
			'required' => 'id harus diisi'
		]);
		$this->form_validation->set_rules('judul', 'Judul', 'required', [
			'required' => 'judul harus diisi'
		]);
		$this->form_validation->set_rules('penulis', 'penulis', 'required', [
			'required' => 'penulis harus diisi'
		]);
		$this->form_validation->set_rules('penerbit', 'Penerbit', 'required', [
			'required' => 'penerbit harus diisi'
		]);
		$this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|min_length[4]|max_length[4]', [
			'required' => 'tahun harus diisi',
			'numeric'  => 'Tahun harus berupa angka'
		]);

		if ($this->form_validation->run() == FALSE) {
			$res = [
				'status'  => false,
				'message' => rtrim(str_replace("\n", ", ", strip_tags(validation_errors())), ', ')
			];

			$this->output->set_header('Content-Type: application/json');
			echo json_encode($res);
		} else {
			$id       = $this->input->post('id', true);
			$judul    = $this->input->post('judul', true);
			$penulis  = $this->input->post('penulis', true);
			$penerbit = $this->input->post('penerbit', true);
			$tahun    = $this->input->post('tahun', true);

			$cover = (isset($_FILES['cover']) ? $_FILES['cover']['name'] : '');

			if ($cover) {
				$this->load->library('upload');
				$config['upload_path']   = './upload';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size']      = 5000;            // 5 mb
				$config['remove_spaces'] = TRUE;
				$config['detect_mime']   = TRUE;
				$config['encrypt_name']  = TRUE;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('cover')) {
					$res = [
						'status'  => false,
						'message' => strip_tags($this->upload->display_errors())
					];

					$this->output->set_header('Content-Type: application/json');
					echo json_encode($res);
				} else {
					$upload_data = $this->upload->data();

					$data = [
						'judul'    => $judul,
						'penulis'  => $penulis,
						'penerbit' => $penerbit,
						'tahun'    => $tahun,
						'cover'    => $upload_data['file_name']
					];

					$buku = $this->M_Buku->getOneBuku($id);

					$this->db->where('id', $id);
					$update = $this->db->update('buku', $data);

					if ($update) {
						if ($cover) {
							if ($buku->cover != null) {
								unlink(FCPATH . 'upload/' . $buku->cover);
							}
						}

						$res = [
							'status'  => true,
							'message' => 'Data berhasil diedit'
						];
					} else {
						$res = [
							'status'  => false,
							'message' => 'Data gagal diedit'
						];
					}

					$this->output->set_header('Content-Type: application/json');
					echo json_encode($res);
				}
			} else {
				$data = [
					'judul'    => $judul,
					'penulis'  => $penulis,
					'penerbit' => $penerbit,
					'tahun'    => $tahun
				];

				$this->db->where('id', $id);
				$update = $this->db->update('buku', $data);

				if ($update) {
					$res = [
						'status'  => true,
						'message' => 'Data berhasil diedit'
					];
				} else {
					$res = [
						'status'  => false,
						'message' => 'Data gagal diedit'
					];
				}

				$this->output->set_header('Content-Type: application/json');
				echo json_encode($res);
			}
		}
	}

	public function deleteBuku()
	{
		$this->load->model('M_Buku');

		$id   = $this->input->get('id');

		if (!$id) {
			$res = [
				'status'  => false,
				'message' => 'id harus diisi'
			];

			$this->output->set_header('Content-Type: application/json');
			echo json_encode($res);
		} else {
			$buku = $this->M_Buku->getOneBuku($id);

			$this->db->where('id', $id);
			$delete = $this->db->delete('buku');

			if ($delete) {
				if ($buku->cover != null) {
					unlink(FCPATH . 'upload/' . $buku->cover);
				}

				$res = [
					'status'  => true,
					'message' => 'Data berhasil dihapus'
				];

				$this->output->set_header('Content-Type: application/json');
				echo json_encode($res);
			} else {
				$res = [
					'status'  => false,
					'message' => 'Data gagal dihapus'
				];

				$this->output->set_header('Content-Type: application/json');
				echo json_encode($res);
			}
		}
	}
}

    /* End of file Api_buku.php */
