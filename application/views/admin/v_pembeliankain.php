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
				<li class="active">Pembelian Kain</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Pembelian Kain</h1>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
				<center><?php echo $this->session->flashdata('msg');?></center>
					<div class="panel-heading">
					
						Input Pembelian Kain
						<div class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#largeModal"><span class="fa fa-search"></span> Cari Kain</a></div>
						
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
						
            <form action="<?php echo base_url().'admin/pembeliankain/add_to_cart'?>" method="post">
            <table>
			<tr>
                    <th style="width:130px;padding-bottom:5px;">Kode Rencana</th>
                    <th style="width:300px;padding-bottom:5px;"> <select name="koderencana" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Kode Rencana" data-width="67%" placeholder="Pilih Kode Rencana" required>
                                <?php foreach ($data2->result_array() as $b2) {
                                    $id_renc=$b2['rencana_kode'];
									$id_bj=$b2['produk_id'];
                                    $nm_bj=$b2['produk_nama'];
									$wrn_bj=$b2['produk_warna'];
									if($id_renc==$this->session->userdata('koderencana'))
                                        echo "<option value='$id_renc' selected>$id_renc - $nm_bj - $wrn_bj</option>";
                                    else
                                        echo "<option value='$id_renc'>$id_renc - $nm_bj - $wrn_bj</option>";
                                    ?>
                                        
                                <?php }?> 
                                </select></th>
                    
                </tr>
                <tr>
                    <th style="width:100px;padding-bottom:5px;">No. Nota</th>
                    <th style="width:300px;padding-bottom:5px;"><input type="text" name="nofak" value="<?php echo $this->session->userdata('nofak');?>" class="form-control input-sm" style="width:200px;" required></th>
                    
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>
                        <div class='input-group date' id='datepicker' style="width:200px;">
                            <input type='text' name="tgl" class="form-control" value="<?php echo $this->session->userdata('tglfak');?>" placeholder="Tanggal..." required/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </td>
                </tr>
            </table><hr/>
            <table style="font-size:12px;">
                <tr>
                    <th>Kode Kain</th>
                </tr>
                <tr>
                    <th><input type="text" name="kode_kain" id="kode_kain" class="form-control input-sm"></th>                     
                </tr>
                    <div id="detail_kain" style="position:absolute;">
                    </div>
            </table>
			
             </form>
            <table class="table table-bordered table-condensed" style="font-size:12px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>Kode Kain</th>
                        <th>Nama Kain</th>
                        <th style="text-align:center;">Warna</th>
						<th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Harga</th>
                        <th style="text-align:center;">Jumlah Beli</th>
                        <th style="text-align:center;">Sub Total</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($this->cart->contents() as $items): ?>
                    <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
                    <tr>
                         <td><?=$items['id'];?></td>
                         <td><?=$items['name'];?></td>
						 <td style="text-align:center;"><?=$items['warna'];?></td>
                         <td style="text-align:center;"><?=$items['satuan'];?></td>
                         <td style="text-align:right;"><?php echo number_format($items['price']);?></td>
                         <td style="text-align:center;"><?php echo number_format($items['qty']);?></td>
                         <td style="text-align:right;"><?php echo number_format($items['subtotal']);?></td>
                         <td style="text-align:center;"><a href="<?php echo base_url().'admin/pembeliankain/remove/'.$items['rowid'];?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a></td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" style="text-align:center;">Total</td>
                        <td style="text-align:right;">Rp. <?php echo number_format($this->cart->total());?></td>
                    </tr>
                </tfoot>
            </table>
            <a href="<?php echo base_url().'admin/pembeliankain/simpan_pembelian'?>" class="btn btn-primary btn-lg"><span class="fa fa-save"></span> Simpan</a>
            </div>
        </div>
        <!-- /.row -->


    </div>
	
	        <!-- ============ KAIN =============== -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Daftar Kain</h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:400px;">

                  <table class="table table-bordered table-condensed" style="" id="">
                    <thead>
                        <tr>
                            <th style="text-align:center;width:40px;">No</th>
							<th>Kode Kain</th>
							<th>Nama Kain</th>
							<th>Warna Kain</th>
							<th>Satuan</th>
							<th>Perkiraan Harga</th>
							<th style="width:130px;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $no=0;
                        foreach ($data->result_array() as $a):
                            $no++;
                            $id=$a['kain_id'];
							$nm=$a['kain_nama'];
							$warna=$a['warna_nama'];
							$satuan=$a['kain_satuan'];
							$harga=$a['kain_harga'];                     
							$stok=$a['kain_stok'];
							$k_warna_id=$a['k_warna_id'];                   

                    ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $no;?></td>
                            <td><?php echo $id;?></td>
                            <td><?php echo $nm;?></td>
							<td><?php echo $warna;?></td>
							<td><?php echo $satuan;?></td>
                            <td style="text-align:right;"><?php echo 'Rp '.number_format($harga);?></td>

							
                            <td style="text-align:center;">
                            <form action="<?php echo base_url().'admin/pembeliankain/add_to_cart'?>" method="post">
                            <input type="hidden" name="kode_kain" value="<?php echo $id?>">
                            <input type="hidden" name="namakain" value="<?php echo $nm;?>">
                            <input type="hidden" name="warna" value="<?php echo $warna;?>">
							<input type="hidden" name="satuan" value="<?php echo $satuan;?>">
                            <input type="hidden" name="harga" value="<?php echo number_format($harga);?>">
                            <input type="hidden" name="jumlah" value="1" required>
                                <button type="submit" class="btn btn-xs btn-info" title="Pilih"><span class="fa fa-edit"></span> Pilih</button>
                            </form>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>          

                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    
                </div>
            </div>
            </div>
        </div>

    <!-- /.container -->
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

                $('#timepicker').datetimepicker({
                    format: 'HH:mm'
                });
            });
    </script>
    <script type="text/javascript">
        $(function(){
            $('.harga').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            //Ajax kabupaten/kota insert
            $("#kode_kain").focus();
            $("#kode_kain").keyup(function(){
                var kodekain = {kode_kain:$(this).val()};
                   $.ajax({
               type: "POST",
               url : "<?php echo base_url().'admin/pembeliankain/get_kain';?>",
               data: kodekain,
               success: function(msg){
               $('#detail_kain').html(msg);
               }
            });
            }); 

            $("#kode_kain").keypress(function(e){
                if(e.which==13){
                    $("#jumlah").focus();
                }
            });
        });
    </script>