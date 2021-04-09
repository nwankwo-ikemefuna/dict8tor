<?php 
function paginate($records, $total_rows, $per_page = 15, $url = '', $uri_segment = 2) {
    // pretty_print(func_get_args()); die;
    $ci =& get_instance();
    $config['base_url'] = strlen($url) ? base_url($url) : base_url($ci->c_controller.'/'.$ci->c_method);
    $config['uri_segment'] = $uri_segment;
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['display_pages'] = TRUE; //show pagination link digits
    $config['num_links'] = 3; //number of digit links
    $config['next_link'] = '&raquo;';
    $config['prev_link'] = '&laquo;';
    $config['first_link'] = 'First';
    $config['last_link'] = 'Last';
    $config['cur_tag_open'] = '<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['first_tag_open'] = $config['last_tag_open'] = $config['prev_tag_open'] = $config['next_tag_open'] = $config['num_tag_open'] = '<li>';
    $config['first_tag_close'] = $config['last_tag_close'] = $config['prev_tag_close'] = $config['next_tag_close'] = $config['num_tag_close'] = '</li>';
    //initialize
    $ci->pagination->initialize($config);
    $data['pagination_links'] = explode('&nbsp;', $ci->pagination->create_links());
    $data['records'] = $records;
    $data['total_rows'] = $total_rows;
    return $data;
}

function paginate_ajax($records, $total_rows, $per_page = 15, $url = '') {
    // pretty_print(func_get_args()); die;
    $ci =& get_instance();
    $config['base_url'] = strlen($url) ? base_url($url) : base_url($ci->c_controller.'/'.$ci->c_method);
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['next_link'] = '&raquo;';
    $config['prev_link'] = '&laquo;';
    $config['first_link'] = 'First';
    $config['last_link'] = 'Last';
    $config['full_tag_open'] = '<ul>';
    $config['full_tag_close'] = '</ul>';
    $config['cur_tag_open'] = '<li><a class="active clickable">';
    $config['cur_tag_close'] = '</a></li>';
    $config['first_tag_open'] = $config['last_tag_open'] = $config['prev_tag_open'] = $config['next_tag_open'] = $config['num_tag_open'] = '<li>';
    $config['first_tag_close'] = $config['last_tag_close'] = $config['prev_tag_close'] = $config['next_tag_close'] = $config['num_tag_close'] = '</li>';
    $ci->pagination->initialize($config);
    $data['pagination'] = $ci->pagination->create_links();
    $data['records'] = $records;
    $data['total_rows'] = $total_rows;
    $data['total_rows_formatted'] = number_format($total_rows);
    return $data;
}

function paginate_offset($page, $per_page) {
    if ($page == 0) return $page;
    return ($page - 1) * $per_page;
}

function pagination_links($links_arr, $ul_class = '') {
    // var_dump($links_arr);
	$links = '';
	foreach ($links_arr as $link) {
		$links .= '<li>' . $link . '</li>';
	} 
    $pagination_links = '<ul class="' . $ul_class . '">';
    $pagination_links .= $links;
    $pagination_links .= '</ul>';
	return $pagination_links;
}