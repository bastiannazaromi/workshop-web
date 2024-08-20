<?php if ($this->session->flashdata('error')) : ?>
	<div class="alert alert-danger" role="alert">
		<?php echo $this->session->flashdata('error'); ?>
	</div>
<?php endif; ?>

<div class="row">
	<div class="col-xl-4">
		<div class="card">
			<div class="card-header bg-primary">
				<h3 class="card-title">Form Tambah Buku</h3>
			</div>
			<div class="card-body">
				<form action="<?php echo base_url('buku/store'); ?>" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label>Judul</label>
						<input type="text" name="judul" class="form-control" autocomplete="off" value="<?php echo set_value('judul'); ?>">
						<span class="text-danger"><?php echo form_error('judul'); ?></span>
					</div>
					<div class="form-group">
						<label>Penulis</label>
						<input type="text" name="penulis" class="form-control" autocomplete="off" value="<?php echo set_value('penulis'); ?>">
						<span class="text-danger"><?php echo form_error('penulis'); ?></span>
					</div>
					<div class="form-group">
						<label>Penerbit</label>
						<input type="text" name="penerbit" class="form-control" autocomplete="off" value="<?php echo set_value('penerbit'); ?>">
						<span class="text-danger"><?php echo form_error('penerbit'); ?></span>
					</div>
					<div class="form-group">
						<label>Tahun</label>
						<input type="number" name="tahun" class="form-control" autocomplete="off" value="<?php echo set_value('tahun'); ?>">
						<span class="text-danger"><?php echo form_error('tahun'); ?></span>
					</div>
					<div class="form-group">
						<label>Cover</label>
						<input type="file" name="cover" class="form-control">
					</div>
					<button type="submit" class="btn btn-success">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>