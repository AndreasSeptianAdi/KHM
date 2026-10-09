<?php 
	$this->db->order_by('pelari_kaos', 'desc');
	$this->db->where('pelari_bib >=', '1');
	$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
	$this->db->select('pelari_id,pelari_bib,pelari_kaos,pelari_kategori,kategori_name, count(pelari_id) as jml');
	$this->db->group_by('pelari_kaos');
	$this->db->group_by('pelari_kategori');
	$pelari = $this->db->get('master_pelari');

	$this->db->order_by('pelari_kaosfinish', 'desc');
	$this->db->where('pelari_bib >=', '1');
	$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
	$this->db->select('pelari_id,pelari_bib,pelari_kaosfinish,pelari_kategori,kategori_name, count(pelari_id) as jml');
	$this->db->group_by('pelari_kaosfinish');
	$this->db->group_by('pelari_kategori');
	$this->db->where('pelari_kategori >', 2);
	$pelari2 = $this->db->get('master_pelari');

	?>
	<div class="table-responsive">
		<table class="table table-sm text-center">
			<thead>
			<tr>
				<th class="text-center">Ukuran Kaos</th>
				<th class="text-center">Kategori</th>
				<th class="text-center">Jumlah</th>
			</tr>
			</thead>
			<?php
			foreach ($pelari->result() as $data) {
				echo '<tr>';
					echo '<td>'.$data->pelari_kaos.'</td>';
					echo '<td>'.$data->kategori_name.'</td>';
					echo '<td>'.$data->jml.'</td>';
				echo '</tr>';
			}
		?>
		</table>
	</div>

	<div class="table-responsive">
		<table class="table table-sm text-center">
			<thead>
			<tr>
				<th class="text-center">Ukuran Jaket</th>
				<th class="text-center">Kategori</th>
				<th class="text-center">Jumlah</th>
			</tr>
			</thead>
			<?php
			foreach ($pelari2->result() as $data) {
				echo '<tr>';
					echo '<td>'.$data->pelari_kaosfinish.'</td>';
					echo '<td>'.$data->kategori_name.'</td>';
					echo '<td>'.$data->jml.'</td>';
				echo '</tr>';
			}
		?>
		</table>
	</div>