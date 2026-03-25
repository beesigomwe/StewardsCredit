<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model{
	public function set_filter_query() {
		$this->db->join('users', 'posts.userid = users.id');
		$this->db->join('categories', 'posts.category_id = categories.id');
		$this->db->select('posts.* , users.username as username, users.slug as user_slug, categories.name as category_name, categories.slug as category_slug, categories.parent_id as category_parent_id, (SELECT slug FROM categories WHERE id = category_parent_id) as parent_category_slug');
		$this->db->where('posts.visibility', 1);
		$this->db->where('posts.status', 1);
		// $this->db->where('posts.lang_id', $this->selected_lang->id);
	}

	//get balance on date
	public function getinterestearned($date, $post_id, $total, $refresh = false){
		$account = $this->get_post_by_id($post_id);
		$refresh = $this->input->get('refresh', true);
		if($refresh == "true"){
			$this->calculatebalances($post_id);
			$this->calculateinterest($post_id, $date, $total);
		}else{
			$this->calculateinterest($post_id, $date, $total);
		}
		$this->db->select('count(id) as counted, sum(interest_amount) as amount');
		$this->db->where('post_id', $post_id);
		// $this->db->where('account_closed <>', '1');
		$this->db->where('left(date, 7) =', date('Y-m', strtotime( '-1 day', strtotime($date))));
		$this->db->group_by('left(date, 7)');
		$this->db->order_by('date', 'ASC');
		$query = $this->db->get('interest');
		$post = $query->row();
		if(isset($post->counted) && $post->counted > 0){
			if($post->counted == $total){
				return $post->amount;
			}
			return $post->amount;
		}
		return 0;
	}

	private function calculatebalances($post_id){
		$this->db->select('trans_id, type, amount, dr, cr, opening_balance, closing_balance');
		$this->db->where('account_id', $post_id);
		$this->db->order_by('trans_date', 'ASC');
		$query = $this->db->get('transaction');
		$result = $query->result();
		if(isset($result) && count($result) > 0){
			$i = 0;
			$ob = 0;
			$cb = 0;
			foreach ($result as $txn) {
				if($i == 0){$ob = 0; }
				$cb = $ob + $txn->cr - $txn->dr;
				$data = [
					'opening_balance' => $ob,
					'closing_balance' => $cb
				];
				$this->db->where('trans_id', $txn->trans_id);
				$this->db->limit(1);
				$this->db->update('transaction', $data);
				$ob = $cb;
				$i++;	
			}
		}
	}

	public function getfirsttransactiondate($post_id){
		$this->db->select('trans_date');
		$this->db->where('account_id', $post_id);
		$this->db->order_by('trans_date', 'ASC');
		$this->db->limit(1);
		$query = $this->db->get('transaction');
		$result = $query->row_array();
		if(isset($result) && isset($result['trans_date'])){
			return $result['trans_date'];
		}
		return null;
	}

	private function calculateinterest($post_id, $date, $total){
		$post = $this->get_post_by_id($post_id);
		$firsttransaction = $this->getfirsttransactiondate($post_id);
		if(null !== $firsttransaction){
			$startdate = date('Y-m-d', strtotime($firsttransaction));
		}else{
			$startdate = date('Y-m-d', strtotime($post->startdate));
		}
		$interestrate = 0;
		if(isset($post->interestrate) && $post->interestrate > 0){
		 $interestrate = $post->interestrate;
		}else{
			$post->interestrate = 0;
		}
		$interestperiod = $post->interestperiod;

		switch ($interestperiod) {
			case 'Annually':
			if($post->category_id == 1){
				$rate = $interestrate / 36400;
			}else{
				$rate = $interestrate / 36500;
			}
			break;
			case 'Monthly':
			if($post->category_id == 1){
				$rate = $interestrate * 12 / 36400;
			}else{
				$rate = $interestrate * 12 / 36500;
			}
			break;
		}

		$firstday = date('Y-m-01', strtotime( '-1 day', strtotime($date)));

		if(date('Y-m-d', strtotime($startdate)) > date('Y-m-d', strtotime($firstday))) $firstday = $startdate;

		$begin = new DateTime(date('Y-m-d', strtotime($firstday)));
		$end = new DateTime(date('Y-m-d', strtotime( '-0 day' ,strtotime($date))));

		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);

		$total = 0;

		foreach ($period as $dt) { 
			$total = $total + 1;
			$date = $dt->format("Y-m-d");
			// CALCULATE THE CLOSING BALANCE
			$closing_balance = $this->getclosingbalance($post_id, $date, $post->category_id);

			$interest_earned = $rate * $closing_balance;
			$datestring = date('Ymd', strtotime($date));
			$status = 0;
			if(date('Y-m-d') > $date) $status = 1;
			$data = [
				"datestring" => $datestring,
				"date" => $date,
				"closing_balance" => $closing_balance,
				"interest_rate" => $rate,
				"interest_amount" => $interest_earned,
				"status" => $status,
				"post_id" => $post_id
			];
			
			$this->db->select('id');
			$this->db->where('datestring', $datestring);
			$this->db->where('post_id', $post_id);
			$this->db->order_by('date', 'ASC');
			$this->db->limit(1);
			$query = $this->db->get('interest');
			$result = $query->num_rows();
			if($result > 0){
				$this->db->where('datestring', $datestring);
				$this->db->where('post_id', $post_id);
				$this->db->limit(1);
				$this->db->update('interest', $data);
			}else{
				$this->db->insert('interest', $data);	
			}
		}
	}

	public function getclosingbalance($account_id, $date, $account_type = null){
		$this->db->select('closing_balance');
		$this->db->where('account_id', $account_id);
		$this->db->where('trans_date <', date('Y-m-d', strtotime( '+1 day', strtotime($date))));
		$this->db->limit(1);
		$this->db->order_by('trans_date', 'DESC');
		$query = $this->db->get('transaction');
		$result = $query->row_array();
		if(isset($result) && isset($result['closing_balance']) && $result['closing_balance'] !== 0){
			$balance = (double) str_replace(',','',$result['closing_balance']);
			switch ($account_type) {
				case '1':
					return $balance;
				break;
				case '2':
					if($balance < 0){
						return $balance;
					}else{
						$this->closeaccount($account_id);
					}
				break;
			}
		}
		return 0;
	}

	public function get_closing_balance($account_id, $date){
		$this->db->select('closing_balance');
		$this->db->where('post_id', $account_id);
		$this->db->limit(1);
		$this->db->order_by('date', 'DESC');
		$query = $this->db->get('interest_cummulative');
		$result = $query->row_array();
		if(isset($result['closing_balance'])){
			return $result['closing_balance'];
		}
		return 0;
	}

	public function get_closing_balance_on_date($account_id, $date){
		$this->db->select('closing_balance');
		$this->db->where('post_id', $account_id);
		$this->db->where('date', $date);
		$this->db->limit(1);
		$this->db->order_by('date', 'DESC');
		$query = $this->db->get('interest_cummulative');
		$result = $query->row_array();
		if(isset($result['closing_balance'])){
			return $result['closing_balance'];
		}
		return 0;
	}

	private function closeaccount(){

	}

	public function uuid($data = null){
		$data = $data ?? random_bytes(16);
		assert(strlen($data) == 16);
	    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
	    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

	    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}

	//get post
	public function get_post($slug) {
		$this->set_filter_query();
		$this->db->where('posts.title_slug', $slug);
		$this->db->limit(1);
		$query = $this->db->get('posts');
		$post = $query->row();
		if(isset($post->id)){
			$post->amount = $this->comment_model->getopeningbalance($post->id);
		}
		return $post;
	}

	//get post by id
	public function get_post_by_id($id){

		$this->db->where('posts.id', $id);
		$query = $this->db->get('posts');
		$result = $query->row();
		if(isset($result->category_id) && $result->category_id > 0){
			$result->category = $this->category_model->get_category($result->category_id);
			$result->fullname = $this->auth_model->get_fullname($result->userid);
		}
		return $result;
	}

	public function get_account_number($id){

		$this->db->select('title_slug');
		$this->db->where('posts.id', $id);
		$query = $this->db->get('posts');
		$result = $query->row();
		return $result->title_slug;
	}

	//get all posts
	public function get_posts(){

		$this->set_filter_query();
		$this->db->order_by('posts.created_at', 'DESC');
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get all posts
	public function get_paginated_posts($per_page, $offset){

		$this->set_filter_query();
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($per_page, $offset);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get post count
	public function get_post_count(){

		$this->set_filter_query();
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	//get unpublished post count
	public function get_draft_count(){

		$this->set_filter_query();
		$this->db->where('posts.visibility', 0);
		$this->db->where('posts.status', 0);
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	//get slider posts
	public function get_slider_posts(){

		$this->set_filter_query();
		$this->db->where('is_slider', 1);
		$this->db->order_by('slider_order');
		$this->db->limit(20);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get popular posts
	public function get_popular_posts($limit){

		$this->set_filter_query();
		$this->db->order_by('hit', 'DESC');
		$this->db->limit($limit);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get picked posts
	public function get_our_picks($limit){

		$this->set_filter_query();
		$this->db->where('is_picked', 1);
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($limit);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get random posts
	public function get_random_posts($limit){

		$this->set_filter_query();
		$this->db->order_by('rand()');
		$this->db->limit($limit);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get category post count
	public function get_post_count_by_category($category_id){

		$category_ids = $this->category_model->get_category_tree_ids_string($category_id);
		$this->set_filter_query();
		$this->db->where("posts.category_id IN (" . $category_ids . ")", NULL, FALSE);
		$this->db->where('posts.visibility', 1);
		$this->db->where('posts.status', 1);
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	//get posts by category
	public function get_posts_by_category($category_id){

		$category_ids = $this->category_model->get_category_tree_ids_string($category_id);
		$this->set_filter_query();
		$this->db->where("posts.category_id IN (" . $category_ids . ")", NULL, FALSE);
		$this->db->order_by('posts.created_at', 'DESC');
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get paginated category posts
	public function get_paginated_category_posts($category_id, $per_page, $offset){

		$category_ids = $this->category_model->get_category_tree_ids_string($category_id);
		$this->set_filter_query();
		$this->db->where("posts.category_id IN (" . $category_ids . ")", NULL, FALSE);
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($per_page, $offset);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get posts by user
	public function get_paginated_user_posts($user_id, $per_page, $offset){

		$this->set_filter_query();
		$this->db->where('posts.userid', $user_id);
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($per_page, $offset);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get post count by user
	public function get_post_count_by_user($user_id){

		$this->set_filter_query();
		$this->db->where('posts.userid', $user_id);
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	//get related posts
	public function get_related_posts($category_id, $post_id){

		$this->set_filter_query();
		$this->db->where('posts.id !=', $post_id);
		$this->db->where('posts.category_id', $category_id);
		$this->db->order_by('rand()');
		$this->db->limit(3);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get post count by tag
	public function get_tag_post_count($tag_slug){

		$this->set_filter_query();
		$this->db->join('tags', 'posts.id = tags.post_id');
		$this->db->where('tags.tag_slug', $tag_slug);
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	//get posts by tag
	public function get_paginated_tag_posts($tag_slug, $per_page, $offset){
		$this->set_filter_query();
		$this->db->join('tags', 'posts.id = tags.post_id');
		$this->db->where('tags.tag_slug', $tag_slug);
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($per_page, $offset);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get search posts
	public function get_paginated_search_posts($q, $per_page, $offset){
		$this->set_filter_query();
		$this->db->group_start();
		$this->db->like('posts.title', $q);
		$this->db->or_like('posts.content', $q);
		$this->db->or_like('posts.summary', $q);
		$this->db->group_end();
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($per_page, $offset);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get search posts
	public function get_paginated_search_users($q, $per_page, $offset){
		// $this->set_filter_query();
		$this->db->group_start();
		$this->db->like('users.firstname', $q);
		$this->db->or_like('users.lastname', $q);
		$this->db->or_like('users.email', $q);
		$this->db->group_end();
		$this->db->order_by('users.created_at', 'DESC');
		$this->db->limit($per_page, $offset);
		$query = $this->db->get('users');
		return $query->result();
	}

	//get search post count
	public function get_search_post_count($q){

		$this->set_filter_query();
		$this->db->group_start();
		$this->db->like('posts.title', $q);
		$this->db->or_like('posts.content', $q);
		$this->db->or_like('posts.summary', $q);
		$this->db->group_end();
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	//increase post hit
	public function increase_post_hit($post){

		if (!empty($post)):
			if (!isset($_COOKIE['inf_post_' . $post->id])) :
				//increase hit
				helper_setcookie('inf_post_' . $post->id, '1');

				$data = array(
					'hit' => $post->hit + 1
				);

				$this->db->where('id', $post->id);
				$this->db->update('posts', $data);

			endif;
		endif;
	}
}
