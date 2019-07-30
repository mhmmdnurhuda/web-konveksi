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

    		$this->reCalculate() ;

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

    private function reCalculate($update = true)
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
