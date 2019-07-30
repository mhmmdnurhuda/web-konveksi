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
                    <th style="width:300px;padding-bottom:5px;"> <select name="koderencana" id="kode-rencana" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Kode Rencana" data-width="67%" placeholder="Pilih Kode Rencana" required>
                                <?php foreach ($data2->result_array() as $b2) {
                                    $id_renc=$b2['rencana_kode'];
									$id_bj=$b2['produk_id'];
                                    $nm_bj=$b2['produk_nama'];
									$wrn_bj=$b2['produk_warna'];
									
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
                    <th>
                        <select id="kode_kain" class="selectpicker show-tick form-control" placeholder="Pilih Kode Kain" title="Pilih Kode Kain">
                            <?php foreach ($data->result() as $key => $kain): ?>
                                <option value="<?= $kain->kain_id ?>"><?= $kain->kain_id ?></option>
                            <?php endforeach; ?>
                        </select>
                    </th>                     
                </tr>
            </table>

            <div id="detail_kain" style="display:block;">

            </div>
			
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

            <div class="row">
                <div class="co-xs-12">
                    <button class="btn btn-sm btn-primary" id="add-new-item">Tambah Item</button>
                </div>
            </div>

            <table id="items" class="table table-bordered table-condensed" style="font-size:12px;margin-top:10px;">
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
                    
                </tbody>
            </table>

            <dl class="row">
                <dt class="col-sm-3">Total</dt>
                <dd class="col-sm-9"><span id="total-numeric">0</span></dd>
            </dl>

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

        <!-- Modal -->
        <div id="new-item-modal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
              </div>
              <div class="modal-body">
                <p>Some text in the modal.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
            
            const state = {
                items: []
            };

            class TableManagement {
                constructor() {
                    this.body = [];
                    this.table = $('table#items');
                    this.tbody = this.table.find('tbody');
                }

                setItems( items = [], autoRender = true ){
                    this.body = items
                    if (autoRender) {
                        this.renderBody();
                    }
                }

                renderBody() {
                    this.tbody.html(null);

                    let rows = '';

                    $.each(this.body, function(index, val) {
                        let row = `<tr item-id="${val.d_rencana_id}">` ;

                        row += `<td>${val.d_rencana_kain_id}</td>`;
                        row += `<td>${val.d_rencana_kain_nama}</td>`;
                        row += `<td style="text-align:center;">${val.d_rencana_kain_warna}</td>`;
                        row += `<td style="text-align:center;">${val.d_rencana_kain_satuan}</td>`;
                        row += `<td style="text-align:center;">${val.d_rencana_harga}</td>`;
                        row += `<td style="text-align:center;">${val.d_rencana_jumlah} Beli</td>`;
                        row += `<td style="text-align:center;">${val.d_rencana_total}</td>`;
                        row += `<td style="width:100px;text-align:center;"><button class="btn btn-success btn-sm btn-delete">Batal</button></td>`;
                        row += '</tr>\n';

                        rows += row ;

                    });

                    this.tbody.html(rows);
                }

                empty() {
                    this.tbody.html(null);
                    this.tbody.html('<tr><td colspan="9" style="text-align:center; padding-top: 10px; padding-bottom: 10px;"><strong style="color: #DDD">Kosong</strong></td></tr>');
                }

            }

            let Table = new TableManagement();
            Table.empty();

            $('table#items').delegate('.btn-delete', 'click', function(event) {
                const item_id = $(this).parents('tr[item-id]').attr('item-id');

                $.ajax({
                    url: '<?= base_url('rest/purchase/plan/delete-item') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        plan_item: item_id,
                        plan_code: $("#kode-rencana").val(),
                    },
                })
                .done(function(response) {
                    if ("success" in response) {
                        let {data} = response.success;
                        Table.setItems(data.items);
                        $('#total-numeric').html(data.rencana_total)
                    }
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
            });

            $("#kode-rencana").on('change', function () {
                const this_picker = $(this);

                const value = this_picker.val();

                $.ajax({
                    url: '<?= base_url('rest/purchase/get-plan') ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: {plan_code: value},
                })
                .done(function(response) {
                    if ("success" in response) {
                        let {data} = response.success;
                        $('#total-numeric').html(data.rencana_total)
                        Table.setItems(data.items);
                    }
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
            });

            $('#add-new-item').click(function(event) {
                $('#new-item-modal').modal('show');
            });

            $("#kode_kain").on('change', function () {
                const body = {
                    kode_kain:$(this).val()
                };

                $.ajax({
                    type: "POST",
                    url: "<?= base_url().'admin/pembeliankain/get_kain';?>",
                    data: body,
                    dataType: "html",
                    success: function (response) {
                        $('#detail_kain').html(response);
                    }
                });
            });

        });
    </script>