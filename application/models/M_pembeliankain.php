<?php
class M_pembeliankain extends CI_Model{

	function simpan_pembelian($nofak,$tglfak,$koderencana,$beli_kode){
		$idadmin=$this->session->userdata('idadmin');
		$this->db->query("INSERT INTO t_belikain (beli_nofak,beli_tanggal,beli_user_id,beli_kode,beli_rencana_kode) VALUES ('$nofak','$tglfak','$idadmin','$beli_kode','$koderencana')");
		foreach ($this->cart->contents() as $item) {
			$data=array(
				'd_beli_nofak' 		=>	$nofak,
				'd_beli_kain_id'	=>	$item['id'],
				'd_beli_kain_nama'	=>	$item['name'],
				'd_beli_kain_warna'	=>	$item['warna'],
				'd_beli_kain_satuan'=>	$item['satuan'],
				'd_beli_harga'		=>	$item['price'],
				'd_beli_jumlah'		=>	$item['qty'],
				'd_beli_total'		=>	$item['subtotal'],
				'd_beli_kode'		=>	$beli_kode
			);
			$this->db->insert('t_belikain_detail',$data);
			$this->db->query("update t_kain set kain_stok=kain_stok+'$item[qty]',kain_harga='$item[price]' where kain_id='$item[id]'");
		}
		return true;
	}
	function get_kobel(){
		$q = $this->db->query("SELECT MAX(RIGHT(beli_kode,4)) AS kd_max FROM t_belikain");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        return "BL".$kd;
	}
}