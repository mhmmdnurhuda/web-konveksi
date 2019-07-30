<?php

class PurchaseItem extends CI_Controller
{
    
    protected $plan_id ;

    protected $plan_data;

	public function __construct()
	{
		parent::__construct();
		header('Content-Type: application/json');
	}

    public function fetch_plan()
    {
        $plan_code = $this->input->get('plan_code');

        $this->plan_id = $plan_code;

        $fetch = $this->get();

        switch ($fetch->result) {
        	case true:
        		echo json_encode(array(
	        		"success" => array(
						"data" => $fetch->data
					)
	        	));

        		break;
        	
        	default:
	        	echo json_encode(array(
	        		"error" => array(
						"reason" =>  "NOT_FOUND"
					)
	        	));
        		break;
        }
    }

    public function delete_plan_item()
    {
    	$id_plan_item = $this->input->post('plan_item');
    	$plan_code = $this->input->post('plan_code');

    	$this->plan_id = $plan_code;

    	$this->db->where('d_rencana_id', $id_plan_item);
    	$delete = $this->db->delete('t_rencanabaru_detail');

    	if ($delete) {

    		$this->reCalculatePlan() ;

	        $fetch = $this->get();

    		echo json_encode(array(
        		"success" => array(
					"data" => $fetch->data
				)
        	));
    	}
    }

    public function get_product()
    {
        $product_code = $this->input->get('product_code');

        $fetch = $this->db->query("SELECT
                                      *
                                    FROM
                                      t_kain AS k
                                      INNER JOIN `t_kain_warna` AS w
                                        ON k.`k_warna_id` = w.`warna_id`
                                    WHERE k.`kain_id` = ?;
                                    ", [$product_code]);

        switch ($fetch->num_rows()) {
            case 1:
                echo json_encode(array(
                    "success" => array(
                        "data" => $fetch->row()
                    )
                ));
                break;
            
            default:
                # code...
                break;
        }
    }

    public function add_new_product()
    {
        $post = $this->input->post();

        $this->plan_id = $post['plan_id'];

        $object = array(
            "d_rencana_kode" => $post['plan_id'],
            "d_rencana_kain_id" => $post['product']['kain_id'],
            "d_rencana_kain_nama" => $post['product']['kain_nama'],
            "d_rencana_kain_warna" => $post['product']['warna_nama'],
            "d_rencana_kain_satuan" => $post['product']['kain_satuan'],
            "d_rencana_harga" => $post['product']['price'],
            "d_rencana_jumlah" => $post['product']['quantity'],
            "d_rencana_total" => (int)$post['product']['quantity'] * (int)$post['product']['price'],
        );

        $insert = $this->db->insert('t_rencanabaru_detail', $object);

        if ($insert) {
            $this->reCalculatePlan() ;

            $fetch = $this->get();

            echo json_encode(array(
                "success" => array(
                    "data" => $fetch->data
                )
            ));
        }
    }

    private function get($w_items = true)
    {
    	$this->db->where('rencana_kode', $this->plan_id);
        $fetch = $this->db->get('t_rencanabaru');

    	switch ($fetch->num_rows()) {
        	case 1:
        		$fetch = $fetch->row();

        		$this->db->where('d_rencana_kode', $fetch->rencana_kode);
        		$fetch_plan_detail = $this->db->get('t_rencanabaru_detail');

        		$fetch->items = $fetch_plan_detail->result();

        		$this->plan_data = $fetch ;

        		return (object)[
        			"result" => true,
        			"data" => $fetch
        		];
        		break;
        	
        	default:
	        	return (object)[
        			"result" => false,
        			"code" => "NOT_FOUND",
        			"data" => []
        		];
        		break;
        }
    }

    private function reCalculatePlan($update = true)
    {	
    	$this->get($this->plan_id);

    	$total = 0 ;

    	foreach ($this->plan_data->items as $key => $item) {
    		$total += $item->d_rencana_total;
    	}

    	if ($update) {
    		$this->db->where('rencana_kode', $this->plan_id);
    		$this->db->update('t_rencanabaru', array(
    			"rencana_total" => $total
    		));
    	}

    	return $total;
    }

}
