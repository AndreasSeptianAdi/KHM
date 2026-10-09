<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// function humanize($text){
// 	return ucwords(strtolower($text));
// }

	function harga_group($id='')
	{
		$harga = 450000;
		if ($id == 1){
			$harga = 300000;
		}else if ($id == 8){
			$harga = 250000;
		}else if ($id == 6){
			$harga = 450000;
		}else if ($id == 11){
			$harga = 450000;
		}

		return $harga;
	}

	if (! function_exists('hitung')){
		function hitung($n, $precision = 2) {
	    if ($n < 10000) {
	    	$n_format = number_format($n,0,',','.');
	    }else if ($n < 1000000) {
        // Anything less than a million
        $n_format = number_format($n/1000,0,',','.').' Rb';
	    } else if ($n < 1000000000) {
        // Anything less than a billion
        $n_format = number_format($n / 1000000, $precision, ',','.') . ' Jt';
	    } else {
        // At least a billion
        $n_format = number_format($n / 1000000000, $precision, ',','.') . ' Mil';
	    }

	    return $n_format;
	  }
	}

 function get_kategori($no='')
	{
		if ($no == '1'){
			return 'umum';
		}else if ($no == '2'){
			return 'pelajar';
		}else if ($no == '3'){
			return 'difabel';
		}
	}

	if( ! function_exists('relative_time'))
	{
	    function relative_time($datetime)
	    {
	        $CI =& get_instance();
	        $CI->lang->load('date');

	        if(!is_numeric($datetime))
	        {
	            $val = explode(" ",$datetime);
	           $date = explode("-",$val[0]);
	           $time = explode(":",$val[1]);
	           $datetime = mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
	        }

	        $difference = time() - $datetime;
	        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	        $lengths = array("60","60","24","7","4.35","12","10");

	        if ($difference >= 0) 
	        { 
	            $ending = ' lalu';
	        } 
	        else 
	        { 
	            $difference = -$difference;
	            $ending = ' lagi';
	        }
	        for($j = 0; $difference >= $lengths[$j]; $j++)
	        {
	            $difference /= $lengths[$j];
	        } 
	        $difference = round($difference);

	        if($difference != 1) 
	        { 
	            $period = strtolower($CI->lang->line('date_'.$periods[$j].'s'));
	        } else {
	            $period = strtolower($CI->lang->line('date_'.$periods[$j]));
	        }

	        return "$difference $period $ending";
	    }


	}

	function set_title($title) {
	    $ci =& get_instance();
	    $ci->header_title = $title;
	}

	function set_active($title = 'index') {
	    $ci =& get_instance();
	    $ci->active_link = $title;
	}

	function get_active() {
	    $ci =& get_instance();
	    return $ci->active_link;
	}

	function set_before($title) {
	    $ci =& get_instance();
	    $ci->before_title = $title;
	}

	function get_before() {
	    $ci =& get_instance();
	    $ret = '';
	    if (isset($ci->before_title)){
	    	$ret = $ci->before_title;
	    }
	    return $ret;
	}

	function get_title() {
	    $ci =& get_instance();
	    return $ci->header_title;
	}


	function userid()
	{
		$CI =& get_instance();
		return $CI->session->userdata('user_id');
	}

	function userdata( $where_data = null )
	{
		$CI =& get_instance();

		if ( $where_data != null ):
			foreach ($where_data as $key => $value) :

				$CI->db->where( $key , $value);

			endforeach;
		else:

			$CI->db->where('user_id', userid() );

		endif;

		$CI->db->join('master_pelari', 'pelari_user = user_id', 'left');
		$get 	= $CI->db->get('master_user');
		if ( $get->num_rows() == 1 ) {
			
			return $get->row();
			
		} else if ( $get->num_rows() > 1 ) {

			return $get->result();

		}
	}

	if ( ! function_exists('option'))
	{

		function option($option_name ='null')
		{
			$CI 	=& get_instance();
			$get 	= $CI->db->get_where('master_options', array('option_name' => $option_name) );
			if ( $get->num_rows() == 1 ) {
				return $get->row()->option_value;
			}
		}
	}

	if ( ! function_exists('option_update'))
	{

		function option_update($option_name ='null', $update = '')
		{
			$CI 	=& get_instance();
			$get 	= $CI->db->get_where('master_options', array('option_name' => $option_name) );
			if ( $get->num_rows() == 1 ) {
				$CI->db->where('option_name', $option_name);
				$CI->db->update('master_options', ['option_value' => $update]);
			}
		}

	}

	if ( ! function_exists( 'post' ) ) {

		function post( $key = null )
		{
			$return     = null;
			if( $key != null ){

				$CI =& get_instance();
				$return     = $CI->input->post( $key );

			}

			return $return;

		}
	}

	if ( ! function_exists( 'get' ) ) {

		function get( $key = null )
		{
			$return     = null;
			if( $key != null ){

				$CI =& get_instance();
				$return     = $CI->input->get( $key );

			}

			return $return;

		}
	}

	if ( ! function_exists( 'uang' ) ) {

		function uang( $uang = null, $delimeter = '' )
		{
			$delimeter = ($delimeter == '')? 'Rp. ' : '';
			return $delimeter.number_format($uang,0,',','.');

		}
	}

	if ( ! function_exists( 'makeNotif' ) ) {
		function makeNotif($title='',$text='',$to = '1')
	  {
	  	$CI =& get_instance();
	  	$to = ($to == '')? userid() : $to;
	  	$obje['notif_text'] = $text;
	  	$obje['notif_title'] = $title;
	  	$obje['notif_user'] = $to;
	  	$CI->db->insert('master_notif', $obje);
	  }
	}

	if ( ! function_exists( 'key_answer' ) ) {
		function key_answer($key='')
	  {
	    if ($key == 0){
	      $return = 'A';
	    }else if ($key == 1){
	      $return = 'B';
	    }else if ($key == 2){
	      $return = 'C';
	    }else if ($key == 3){
	      $return = 'D';
	    }else if ($key == 4){
	      $return = 'E';
	    }else if ($key == 5){
	      $return = 'F';
	    }else if ($key == 6){
	      $return = 'G';
	    }else if ($key == 7){
	      $return = 'H';
	    }else if ($key == 8){
	      $return = 'I';
	    }else if ($key == 9){
	      $return = 'J';
	    }else if ($key == 10){
	      $return = 'K';
	    }else if ($key == 11){
	      $return = 'L';
	    }else if ($key == 12){
	      $return = 'M';
	    }else if ($key == 13){
	      $return = 'N';
	    }else if ($key == 14){
	      $return = 'O';
	    }else if ($key == 15){
	      $return = 'P';
	    }else if ($key == 16){
	      $return = 'Q';
	    }else if ($key == 17){
	      $return = 'R';
	    }else if ($key == 18){
	      $return = 'S';
	    }else if ($key == 19){
	      $return = 'T';
	    }else if ($key == 20){
	      $return = 'U';
	    }else if ($key == 21){
	      $return = 'V';
	    }else if ($key == 22){
	      $return = 'W';
	    }else if ($key == 23){
	      $return = 'X';
	    }else if ($key == 24){
	      $return = 'Y';
	    }else{
	      $return = 'Z';
	    }
	    return $return;
	  }
	}