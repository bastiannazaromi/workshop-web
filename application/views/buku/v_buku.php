<div class="row mb-3">
	<div class="col-xl-12">
		<a href="<?php echo base_url('buku/add'); ?>" class="btn btn-primary">Tambah</a>
	</div>
</div>

<?php if ($this->session->flashdata('success')) : ?>
	<div class="alert alert-success" role="alert">
		<?php echo $this->session->flashdata('success'); ?>
	</div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')) : ?>
	<div class="alert alert-danger" role="alert">
		<?php echo $this->session->flashdata('error'); ?>
	</div>
<?php endif; ?>

<div class="row">
	<div class="col-xl-12">
		<table class="table table-bordered tabled-striped">
			<tr>
				<th>No</th>
				<th>Judul</th>
				<th>Penulis</th>
				<th>Penerbit</th>
				<th>Tahun</th>
				<th>Cover</th>
				<th>Action</th>
			</tr>
			<?php foreach ($buku as $i => $bk) : ?>
				<tr>
					<td><?php echo $i + 1; ?></td>
					<td><?php echo $bk->judul; ?></td>
					<td><?php echo $bk->penulis; ?></td>
					<td><?php echo $bk->penerbit; ?></td>
					<td><?php echo $bk->tahun; ?></td>
					<td>
						<?php if ($bk->cover != null) : ?>
							<a href="<?= base_url('upload/' . $bk->cover); ?>" target="cover">
								<img src="<?= base_url('upload/' . $bk->cover); ?>" alt="<?= $bk->judul; ?>" class="img img-thumbnail">
							</a>
						<?php endif; ?>
					</td>
					<td>
						<a href="<?php echo base_url('buku/edit/') . $bk->id; ?>" class="btn btn-warning">Edit</a>
						<a href="<?php echo base_url('buku/delete/') . $bk->id; ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin data akan dihapus?')">Hapus</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>