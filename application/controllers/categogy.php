<?php
class Categogy extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ajax_pagination');
		
		$this->load->model('m_categogy');
	}

	public function index()
	{
		$limit = 4;
		$total= count($this->m_categogy->read_all_cate());

		//pagination configuation
		$config['target']   = '#data_cate_child';
		$config['base_url'] = base_url(). 'categogy/ajax_pagination_data';
		$config['total_rows']= $total;
		$config['per_page']= $limit;
		$this->ajax_pagination->initialize($config);


		$data['list_cate'] = $this->m_categogy->read_all_cate($limit,0);
		$data['view'] = 'admin/categogy/v_list_categogy';
		//load view
		$this->load->view('layouts/admin/layout',$data);
	}

    public function list_categogy($id=-1)
    {
		
		//echo "day la ds loai san pham";
		$main_cate=$this->m_categogy->read_cate_by_parentID(0);
		$list = $this->m_categogy->read_all_cate();

		$data['list_cate'] = $list;
		$data['main_categogy']=$main_cate;
		$data['view'] = 'admin/categogy/v_list_categogy';
		$this->load->view('layouts/admin/layout',$data);
        
	}
	
	public function ajax_get_categogy_by_parenID(){
		
		$parenID = $_POST['parenID'];
		if($parenID >0)
		{
			$list_cate_child=$this->m_categogy->read_cate_by_parentID($parenID);
		}
		else
		{
			$list_cate_child = $this->m_categogy->read_all_cate();
		}
		

		foreach($list_cate_child as $l)
		{
		echo '<tr role="row" class="even">
                  <td class="sorting_1">'.$l->ten_loai.'</td>
                  <td>'.$l->mo_ta.'</td>
                  <td>'.$l->ma_loai_cha.'</td>
				</tr>';
		}
	}

	public function ajax_pagination_data()
	{
		$page = $this->input->post('page');
		if(!$page)
		{
            $offset = 0;
		}
		else
		{
            $offset = $page;
		}
		
		$limit = 4;
		$total= count($this->m_categogy->read_all_cate());

		//pagination configuation
		$config['target']   = '#data_cate_child';
		$config['base_url'] = base_url(). 'categogy/ajax_pagination_data/';
		$config['total_rows']= $total;
		$config['per_page']= $limit;
		$this->ajax_pagination->initialize($config);


		$data['list_cate'] = $this->m_categogy->read_all_cate($limit,$offset);
		$data['view'] = 'admin/categogy/v_list_categogy';
		//load view
		$this->load->view('layouts/admin/layout',$data);

	}

	
}
?>
