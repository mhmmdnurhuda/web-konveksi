<!-- Navigation -->
   <?php 
        $this->load->view('admin/templates/v_header');
		$this->load->view('admin/templates/v_sidebar');
   ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Rencana Produksi</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Rencana Produksi</h1>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
				<center><?php echo $this->session->flashdata('msg');?></center>
					<div class="panel-heading">
					
						<div class="btn btn-sm btn-success" data-toggle="modal" data-target="#largeModal"><span class="fa fa-plus"></span> Tambah Rencana Produksi</a></div> 
						
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<div class="canvas-wrapper">
						
							<div class="table-responsive">
                <table class="table table-bordered" id="mydata" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="text-align:center;width:40px;">No</th>
                        <th>Kode Rencana</th>
                        <th>Nama Produk Baju</th>
                        <th>Tanggal Mulai</th>
                        <th>Rencana Tanggal Selesai</th>
                        <th>Rencana Jumlah Produksi</th>
                        <th>Hasil Jumlah Produksi</th>
                        <th style="width:190px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['rencana_id'];
                        $produkid=$a['produk_id'];
						$produknama=$a['produk_nama'];
						$tgl_mulai=$a['tgl_mulai'];
                        $tgl_selesai=$a['tgl_selesai'];
                        $rencanajumlah=$a['rencana_jumlahproduksi'];                     
                        $hasiljumlah=$a['hasil_jumlahproduksi'];


                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $id;?></td>
                        <td><?php echo $produknama;?></td>
						<td><?php echo $tgl_mulai;?></td>
						<td><?php echo $tgl_selesai;?></td>
						<td><?php echo $rencanajumlah;?></td>
						<td><?php echo $hasiljumlah;?></td>
		
						
					

                        <td style="text-align:center;">
                            <a class="btn btn-xs btn-info" href="#modalEditPelanggan<?php echo $id?>" data-toggle="modal" title="Edit"> Update Produksi</a>
                            <a class="btn btn-xs btn-danger" href="#modalHapusPelanggan<?php echo $id?>" data-toggle="modal" title="Hapus">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            </div>
		
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
        <!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Rencana Produksi</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/rencana/tambah_rencana'?>" enctype="multipart/form-data">
                <div class="modal-body">

                    <!--<div class="form-group">
                        <label class="control-label col-xs-3" >Kode Barang</label>
                        <div class="col-xs-9">
                            <input name="kobar" class="form-control" type="text" placeholder="Kode Barang..." style="width:335px;" required>
                        </div>
                    </div>-->
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Nama Produk Baju</label>
                            <div class="col-xs-9">
                                <select name="namabaju" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Produk Baju" data-width="80%" placeholder="Pilih Produk Baju" required>
                                <?php foreach ($baju2->result_array() as $b2) {
                                    $id_baju=$b2['produk_id'];
                                    $nm_baju=$b2['produk_nama'];
									$wrn_baju=$b2['produk_warna'];
                                    ?>
                                        <option value="<?php echo $id_baju;?>"><?php echo $nm_baju . " - " . $wrn_baju;?></option>
                                <?php }?> 
                                </select>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Warna</label>
                            <div class="col-xs-9">
                                <input name="warnarencana" class="form-control" type="text" placeholder="Warna Produk..." style="width:335px;" required>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Tanggal Mulai</label>
                            <div class="col-xs-9">
								<div class='input-group date' id='datepicker' style="width:335px;">
									<input type='text' name="tgl_mulai" class="form-control"  placeholder="Tanggal Mulai..." required/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Rencana Selesai</label>
                            <div class="col-xs-9">
								<div class='input-group date' id='datepicker2' style="width:335px;">
									<input type='text' name="rencana_selesai" class="form-control"  placeholder="Rencana Selesai..." required/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Rencana Jumlah Produksi</label>
                            <div class="col-xs-9">
                                <input name="rencanaproduksi" class="form-control" type="text" placeholder="Rencana Jumlah Produksi..." style="width:335px;" required>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Kain yang dibutuhkan</label>
                            <div class="col-xs-9">
                                <input name="rencanaproduksi" class="form-control" type="text" placeholder="Rencana Jumlah Produksi..." style="width:335px;" required>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Tanggal Selesai</label>
                            <div class="col-xs-9">
								<div style="width:335px;">
									<input type='date' name="tgl_selesai" class="form-control"  placeholder="Tanggal Selesai..." readonly/>
								</div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Hasil Jumlah Produksi</label>
                            <div class="col-xs-9">
                                <input name="hasilproduksi" class="form-control" type="text" placeholder="Hasil Jumlah Produksi..." style="width:335px;" readonly>
                            </div>
                        </div>  
					

                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info">Simpan</button>
                </div>
            </form>
            </div>
            </div>
        </div>

        <!-- ============ MODAL EDIT =============== -->
        <?php
                    foreach ($data->result_array() as $a) {
                       $no++;
                        $id=$a['rencana_id'];
                        $produkid=$a['produk_id'];
						$produknama=$a['produk_nama'];
						$tgl_mulai=$a['tgl_mulai'];
                        $tgl_selesai=$a['tgl_selesai'];
                        $rencanajumlah=$a['rencana_jumlahproduksi'];                     
                        $hasiljumlah=$a['hasil_jumlahproduksi'];
                    ?>
                <div id="modalEditPelanggan<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Update Rencana Produksi</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/rencana/edit_rencana'?>">
                        <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3" >Kode Rencana</label>
                            <div class="col-xs-9">
                                <input name="koderencana" class="form-control" type="text" value="<?php echo $id;?>" placeholder="Kode Rencana..." style="width:335px;" readonly>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Nama Produk Baju</label>
                            <div class="col-xs-9">
                                <select name="namabaju" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Produk Baju" data-width="80%" placeholder="Pilih Produk Baju" required>
                                <?php foreach ($baju2->result_array() as $b2) {
                                    $id_baju=$b2['produk_id'];
                                    $nm_baju=$b2['produk_nama'];
                                     if($id_baju==$produkid)
                                        echo "<option value='$id_baju' selected>$nm_baju</option>";
                                    else
                                        echo "<option value='$id_baju'>$nm_baju</option>";
                                }
                                ?>
                                </select>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Tanggal Mulai</label>
                            <div class="col-xs-9">
                                <input name="tgl_mulai" class="form-control" type="date" value="<?php echo $tgl_mulai;?>" placeholder="Tanggal Mulai..." style="width:335px;" required>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Tanggal Selesai</label>
                            <div class="col-xs-9">
                                <input name="tgl_selesai" class="form-control" type="date" value="<?php echo $tgl_selesai;?>" placeholder="Tanggal Selesai..." style="width:335px;" required>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Rencana Jumlah Produksi</label>
                            <div class="col-xs-9">
                                <input name="rencanaproduksi" class="form-control" type="text" value="<?php echo $rencanajumlah;?>" placeholder="Rencana Jumlah Produksi..." style="width:335px;" required>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-xs-3" >Hasil Jumlah Produksi</label>
                            <div class="col-xs-9">
                                <input name="hasilproduksi" class="form-control" type="text" value="<?php echo $hasiljumlah;?>" placeholder="Hasil Jumlah Produksi..." style="width:335px;" required>
                            </div>
                        </div>

                    </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                            <button type="submit" class="btn btn-info">Update</button>
                        </div>
                    </form>
                </div>
                </div>
                </div>
            <?php
        }
        ?>

        <!-- ============ MODAL HAPUS =============== -->
        <?php
                    foreach ($data->result_array() as $a) {
                        $no++;
                        $id=$a['rencana_id'];
                        $produkid=$a['produk_id'];
						$produknama=$a['produk_nama'];
						$tgl_mulai=$a['tgl_mulai'];
                        $tgl_selesai=$a['tgl_selesai'];
                        $rencanajumlah=$a['rencana_jumlahproduksi'];                     
                        $hasiljumlah=$a['hasil_jumlahproduksi'];
                    ?>
                <div id="modalHapusPelanggan<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Hapus Rencana Produksi</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/rencana/hapus_rencana'?>">
                        <div class="modal-body">
                            <p>Yakin mau menghapus data rencana ini..?</p>
                                    <input name="koderencana" type="hidden" value="<?php echo $id; ?>">
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                            <button type="submit" class="btn btn-primary">Hapus</button>
                        </div>
                    </form>
                </div>
                </div>
                </div>
            <?php
        }
        ?>

        <!--END MODAL-->
 
<?php 
	$this->load->view('admin/templates/v_footer');
?>

<script type="text/javascript">
            $(function () {
                $('#datetimepicker').datetimepicker({
                    format: 'DD MMMM YYYY HH:mm',
                });
                
                $('#datepicker').datetimepicker({
                    format: 'YYYY-MM-DD',
                });
                $('#datepicker2').datetimepicker({
                    format: 'YYYY-MM-DD',
                });
				$('#datepicker3').datetimepicker({
                    format: 'YYYY-MM-DD',
                });
                $('#datepicker4').datetimepicker({
                    format: 'YYYY-MM-DD',
                });

                $('#timepicker').datetimepicker({
                    format: 'HH:mm'
                });
            });
    </script>
