<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-calculator"></i> Data Perhitungan
	<?php if (isset($_POST['hitung'])) {if($_POST['metode'] == "saw") {echo "Metode SAW";}}?>
	<?php if (isset($_POST['hitung'])) {if($_POST['metode'] == "wp") {echo "Metode WP";}}?>
	</h1>
</div>

<div class="card shadow mb-4">
	<!-- /.card-header -->
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Hitung Berdasarkan Metode</h6>
	</div>

	<div class="card-body">
		<form action="<?= base_url('Perhitungan'); ?>" method="POST">
			<div class="row">
				<div class="input-group mb-3 col-10">
					<div class="input-group-prepend">
						<label class="input-group-text" for="inputGroupSelect01">Pilih Metode</label>
					</div>
					<select name="metode" class="custom-select" required>
						<option value="">--Pilih Metode Perhitungan--</option>
						<option value="saw" <?php if (isset($_POST['hitung'])) {if($_POST['metode'] == "saw") {echo "selected";}}?>>Perhitungan Metode SAW</option>
						<option value="wp" <?php if (isset($_POST['hitung'])) {if($_POST['metode'] == "wp") {echo "selected";}}?>>Perhitungan Metode WP</option>
					</select>
				</div>

				<div class="col-2">
					<button name="hitung" type="submit" class="btn btn-success w-100"><i class="fa fa-search"></i> Hitung</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php
	if (isset($_POST['hitung'])) {
		if($_POST['metode'] == "saw") {
			$total_kriteria = $this->Perhitungan_model->total_kriteria();
?>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Matrix Keputusan (X)</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th width="5%" rowspan="2">No</th>
						<th rowspan="2">Nama Alternatif</th>
						<th colspan="<?= $total_kriteria['total_kriteria']; ?>">Kriteria</th>
					</tr>
					<tr align="center">
						<?php foreach ($kriteria as $key): ?>
						<th><?= $key->kode_kriteria ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php 
						$no=1;
						foreach ($alternatif as $keys): ?>
					<tr align="center">
						<td><?= $no; ?></td>
						<td align="left"><?= $keys->nama ?></td>
						<?php foreach ($kriteria as $key): ?>
						<td>
						<?php 
							$data_pencocokan = $this->Perhitungan_model->data_nilai($keys->id_alternatif,$key->id_kriteria);
							echo $data_pencocokan['nilai'];
						?>
						</td>
						<?php endforeach ?>
					</tr>
					<?php
						$no++;
						endforeach
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Matrix Ternormalisasi (R)</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th width="5%" rowspan="2">No</th>
						<th rowspan="2">Nama Alternatif</th>
						<th colspan="<?= $total_kriteria['total_kriteria']; ?>">Kriteria</th>
					</tr>
					<tr align="center">
						<?php foreach ($kriteria as $key): ?>
						<th><?= $key->kode_kriteria ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						foreach ($alternatif as $keys): ?>
					<tr align="center">
						<td><?= $no; ?></td>
						<td align="left"><?= $keys->nama ?></td>
						<?php foreach ($kriteria as $key): ?>
						<td>
						<?php 
							$data_pencocokan = $this->Perhitungan_model->data_nilai($keys->id_alternatif,$key->id_kriteria);
							$min_max=$this->Perhitungan_model->get_max_min($key->id_kriteria);
							if($min_max['jenis']=='Benefit'){
								echo @($data_pencocokan['nilai']/$min_max['max']);
							}else{
								echo @($min_max['min']/$data_pencocokan['nilai']);
							}
						?>
						</td>
						<?php endforeach ?>
					</tr>
					<?php
						$no++;
						endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Bobot Kriteria (W)</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<?php foreach ($kriteria as $key): ?>
						<th><?= $key->kode_kriteria ?> (<?= $key->jenis ?>)</th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<tr align="center">
						<?php foreach ($kriteria as $key): ?>
						<td>
						<?php 
						echo $key->bobot;
						?>
						</td>
						<?php endforeach ?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Perhitungan Nilai (Vi)</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th width="5%">No</th>
						<th>Nama Alternatif</th>
						<th width="15%">Nilai Vi</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$this->Perhitungan_model->hapus_hasil_saw();
						$no=1;
						foreach ($alternatif as $keys): ?>
					<tr align="center">
						<td><?= $no; ?></td>
						<td align="left"><?= $keys->nama ?></td>
						<?php
						$nilai_v = 0;
						foreach ($kriteria as $key): ?>
						<?php 
							$bobot = $key->bobot;
							$data_pencocokan = $this->Perhitungan_model->data_nilai($keys->id_alternatif,$key->id_kriteria);
							$min_max=$this->Perhitungan_model->get_max_min($key->id_kriteria);
							if($min_max['jenis']=='Benefit'){
								$nilai_r = @($data_pencocokan['nilai']/$min_max['max']);
							}else{
								$nilai_r = @($min_max['min']/$data_pencocokan['nilai']);
							}
							$nilai_penjumlahan = $bobot*$nilai_r;
							$nilai_v += $nilai_penjumlahan;
						endforeach; ?>
						<td>
							<?php
								echo $nilai_v;
								$hasil_akhir = [
									'id_alternatif' => $keys->id_alternatif,
									'nilai' => $nilai_v
								];
								$this->Perhitungan_model->insert_hasil_saw($hasil_akhir);
							?>
						</td>
					</tr>
					<?php
						$no++;
						endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
	}elseif($_POST['metode'] == "wp") {
		$total_kriteria = $this->Perhitungan_model->total_kriteria();
?>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Matrix Keputusan (X)</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th width="5%" rowspan="2">No</th>
						<th rowspan="2">Nama Alternatif</th>
						<th colspan="<?= $total_kriteria['total_kriteria']; ?>">Kriteria</th>
					</tr>
					<tr align="center">
						<?php foreach ($kriteria as $key): ?>
						<th><?= $key->kode_kriteria ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php 
						$no=1;
						foreach ($alternatif as $keys): ?>
					<tr align="center">
						<td><?= $no; ?></td>
						<td align="left"><?= $keys->nama ?></td>
						<?php foreach ($kriteria as $key): ?>
						<td>
						<?php 
							$data_pencocokan = $this->Perhitungan_model->data_nilai($keys->id_alternatif,$key->id_kriteria);
							echo $data_pencocokan['nilai'];
						?>
						</td>
						<?php endforeach ?>
					</tr>
					<?php
						$no++;
						endforeach
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Bobot Kriteria (W)</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<?php foreach ($kriteria as $key): ?>
						<th><?= $key->kode_kriteria ?> (<?= $key->jenis ?>)</th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<tr align="center">
						<?php foreach ($kriteria as $key): ?>
						<td>
						<?php 
						echo $key->bobot;
						?>
						</td>
						<?php endforeach ?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>


<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Normalisasi Bobot Kriteria (W)</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<?php foreach ($kriteria as $key): ?>
						<th><?= $key->kode_kriteria ?> (<?= $key->jenis ?>)</th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<tr align="center">
						<?php 
						foreach ($kriteria as $key):
						$total_bobot=$this->Perhitungan_model->get_total_kriteria();
						?>
						<td>
						<?php 
							if ($key->jenis == "Benefit") {
								echo @(($key->bobot/$total_bobot['total_bobot'])*1);
							}else {
								echo @(($key->bobot/$total_bobot['total_bobot'])*-1);
							}
						?>
						</td>
						<?php endforeach ?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Nilai Vektor (S)</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th width="5%" rowspan="2">No</th>
						<th rowspan="2">Nama Alternatif</th>
						<th colspan="<?= $total_kriteria['total_kriteria']; ?>">Kriteria</th>
						<th rowspan="2" width="15%">Nilai (S)</th>
					</tr>
					<tr align="center">
						<?php foreach ($kriteria as $key): ?>
						<th><?= $key->kode_kriteria ?></th>
						<?php endforeach ?>
						
					</tr>
				</thead>
				<tbody>
					<?php 
						$no=1;
						$total_vs = 0;
						foreach ($alternatif as $keys): ?>
					<tr align="center">
						<td><?= $no; ?></td>
						<td align="left"><?= $keys->nama ?></td>
						<?php 
						$total_s = 1;
						foreach ($kriteria as $key): ?>
						<td>
						<?php 
							$data_pencocokan = $this->Perhitungan_model->data_nilai($keys->id_alternatif,$key->id_kriteria);
							$total_bobot=$this->Perhitungan_model->get_total_kriteria();
							if ($key->jenis == "Benefit") {
								$bobot_r = @(($key->bobot/$total_bobot['total_bobot'])*1);
								echo $nilai_s = pow($data_pencocokan['nilai'],$bobot_r);
							}else {
								$bobot_r = @(($key->bobot/$total_bobot['total_bobot'])*-1);
								echo $nilai_s = pow($data_pencocokan['nilai'],$bobot_r);
							}
							$total_s *= $nilai_s;
						?>
						</td>
						<?php endforeach; ?>
						<td><?= $total_s; ?></td>
					</tr>
					<?php
						$total_vs += $total_s;
						$no++;
						endforeach;
					?>
					<tr align="center">
						<td colspan="<?= $total_kriteria['total_kriteria']+2; ?>" class="bg-light">Total</td>
						<td class="bg-light"><?= $total_vs;?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Nilai Vektor (V)</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th width="5%">No</th>
						<th>Nama Alternatif</th>
						<th>Perhitungan</th>
						<th width="15%">Nilai (V)</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$this->Perhitungan_model->hapus_hasil_wp();
						$no=1;
						foreach ($alternatif as $keys): ?>
					<tr align="center">
						<td><?= $no; ?></td>
						<td align="left"><?= $keys->nama ?></td>
						<?php 
						$total_s = 1;
						foreach ($kriteria as $key): ?>
						<?php 
							$data_pencocokan = $this->Perhitungan_model->data_nilai($keys->id_alternatif,$key->id_kriteria);
							$total_bobot=$this->Perhitungan_model->get_total_kriteria();
							if ($key->jenis == "Benefit") {
								$bobot_r = @(($key->bobot/$total_bobot['total_bobot'])*1);
								$nilai_s = pow($data_pencocokan['nilai'],$bobot_r);
							}else {
								$bobot_r = @(($key->bobot/$total_bobot['total_bobot'])*-1);
								$nilai_s = pow($data_pencocokan['nilai'],$bobot_r);
							}
							$total_s *= $nilai_s;
						?>
						<?php endforeach; ?>
						<td><?=$total_s; ?> / <?=$total_vs; ?></td>
						<td><?php echo $nilai_v = $total_s/$total_vs; ?></td>
					</tr>
					<?php
						$hasil_akhir = [
							'id_alternatif' => $keys->id_alternatif,
							'nilai' => $nilai_v
						];
						$this->Perhitungan_model->insert_hasil_wp($hasil_akhir);
						$no++;
						endforeach;
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
	}
}
$this->load->view('layouts/footer_admin');
?>