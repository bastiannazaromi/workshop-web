<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Buku extends CI_Model
{
	public function getAllBuku()
	{
		return $this->db->get('buku')->result();
	}

	public function getOneBuku($id)
	{
		$this->db->where('id', $id);

		return $this->db->get('buku')->row();
	}
}

/* End of file M_Buku.php */
