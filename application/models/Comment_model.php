<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends CI_Model {

	public function initial_transaction($postid){
		$trans = $this->input->post('category_id');
		switch ($trans) {
			case '1':
			$trans_type = 'CR';
			break;
			case '2':
			$trans_type = 'DR';
			break;
			default:
			$trans_type = '';
		}
		
		$userid = $this->input->post('userid', true);
		$name = $this->auth_model->get_fullname($userid);
		$amount = str_replace(',','',$this->input->post('amount', true));
		$opening_balance = 0;
		$closing_balance = $this->getclosingbalance($opening_balance, $trans_type, $amount);
		$data = array(
			'post_id' => $postid,
			'uuid' => $this->input->post('uuid', true),
			'user_id' => user()->id,
			'userid' => $userid,
			'name' => $name,
			'payment_method' => $this->input->post('payment_method', true),
			'account' => $this->input->post('account', true),
			'currency' => $this->input->post('currency', true),
			'amount' => $amount,
			'post_type' => $this->input->post('post_type', true),
			'startdate' => date('y-m-d', strtotime($this->input->post('startdate', true))),
			'enddate' => date('y-m-d', strtotime($this->input->post('enddate', true))),
			'day_count' => $this->numberofdays($this->input->post('startdate', true), $this->input->post('enddate', true)),
			'trans_date' => date('y-m-d', strtotime($this->input->post('startdate', true))),
			'interestrate' => str_replace("%", "", trim($this->input->post('interestrate', true))),
			'rate_type' => $this->input->post('interestperiod', true),
			'scheduled' => 0,
			'trans_type' => $trans_type,
			'comment' => 'Initial transaction',
			'status' => 1,
			'created_at' => date("Y-m-d H:i:s"),
			'opening_balance' => $opening_balance,
			'closing_balance' => $closing_balance
		);
		if ($this->general_settings->comment_approval_system == 1) {
			$data["status"] = 0;
		}
		if (!empty($data['post_id']) && !empty(trim($data['amount']))) {
			if ($data['userid'] != 0) {
				$user = $this->auth_model->get_user($data['userid']);
				if (!empty($user)) {
					$data['name'] = $user->username;
					$data['email'] = $user->email;
				}
			}
			$this->db->insert('comments', $data);
		}
	}

	private function numberofdays($start, $end){
		if($end == '' || date('y-m-d', strtotime($end)) == '1970-01-01'){
			return 365;
		}
		// FIX: Return difference in days, not seconds
		return (int) round((strtotime($end) - strtotime($start)) / 86400);
	}

	//add comment
	public function add_comment() {
		$trans = $this->input->post('category_id');
		switch ($trans) {
			case '1':
			$trans_type = 'CR';
			break;
			case '2':
			$trans_type = 'DR';
			break;
			default:
			$trans_type = '';
		}
		$userid = $this->input->post('userid', true);
		$name = $this->auth_model->get_fullname($userid);
		$account_id = $this->input->post('post_id', true);
		$amount = str_replace(',','',$this->input->post('amount', true));

		$opening_balance = $this->getopeningbalance($account_id);
		$closing_balance = $this->getclosingbalance($account_id, $opening_balance, $trans_type, $amount);

		$data = array(
			'parent_id' => $this->input->post('parent_id', true),
			'uuid' => $this->input->post('uuid', true),
			'post_id' => $this->input->post('post_id', true),
			'user_id' => user()->id,
			'userid' => $userid,
			'payment_method' => $this->input->post('payment_method', true),
			'account' => $this->input->post('account', true),
			'currency' => $this->input->post('currency', true),
			'category' => $this->input->post('category', true),
			'amount' => $amount,
			'trans_type' => $trans_type,
			'name' => $name,
			'email' => $this->input->post('email', true),
			'comment' => $this->input->post('comment', true),
			'status' => 1,
			'created_at' => date("Y-m-d H:i:s"),
			'payment_method' => $this->input->post('payment_method', true),
			'account' => $this->input->post('account', true),
			'trans_date' => date('y-m-d', strtotime($this->input->post('today', true))), 
			'opening_balance' => $opening_balance,
			'closing_balance' => $closing_balance
		);
		if ($this->general_settings->comment_approval_system == 1) {
			$data["status"] = 0;
		}
		if (!empty($data['post_id']) && !empty(trim($data['comment']))) {
			if ($data['user_id'] != 0) {
				$user = $this->auth_model->get_user($data['user_id']);
				if (!empty($user)) {
					$data['name'] = $user->username;
					$data['email'] = $user->email;
				}
			}
			$this->db->insert('comments', $data);
		}
	}

	//get comment
	public function get_comment($id){
		$this->db->where('id', $id);
		$query = $this->db->get('comments');
		return $query->row();
	}

	public function getopeningbalance($account_id){
		$this->db->select('closing_balance');
		$this->db->where('account_id', $account_id);
		$this->db->limit(1);
		$this->db->order_by('trans_id', 'DESC');
		$query = $this->db->get('transaction');
		$result = $query->row_array();
		if(isset($result) && isset($result['closing_balance']) && $result['closing_balance'] !== 0){
			return (double) str_replace(',','',$result['closing_balance']);
		}
		return 0;
	}

	private function getclosingbalance($opening_balance = 0, $trans_type, $amount, $account_id = null){
		$closing_balance = 0;
		switch ($trans_type) {
			case 'CR':
				$closing_balance = (double) $opening_balance + (double) $amount;
			break;
			case 'DR':
				$closing_balance = (double) $opening_balance - (double) $amount;
			break;
		}
		return (double) $closing_balance;
	}


	//post comment count
	public function post_comment_count($post_id) {
		$this->db->join('posts', 'comments.post_id = posts.id');
		$this->db->where('post_id', $post_id);
		$this->db->where('parent_id', 0);
		$this->db->where('comments.status', 1);
		$query = $this->db->get('comments');
		return $query->num_rows();
	}

	//get comments
	public function get_comments($post_id, $limit) {
		$this->db->join('posts', 'comments.post_id = posts.id');
		$this->db->where('post_id', $post_id);
		$this->db->where('parent_id', 0);
		$this->db->where('comments.status', 1);
		$this->db->select('comments.*');
		$this->db->limit($limit);
		$this->db->order_by('comments.trans_date', 'ASC');
		$query = $this->db->get('comments');
		return $query->result();
	}

	//get pending comments
	public function get_pending_count($post_id = null, $limit = 10) {
		$this->db->join('posts', 'comments.post_id = posts.id');
		if(null !== $post_id) $this->db->where('post_id', $post_id);
		$this->db->where('parent_id', 0);
		$this->db->where('comments.status', 0);
		$this->db->select('comments.*');
		$this->db->limit($limit);
		$this->db->order_by('comments.id', 'ASC');
		$query = $this->db->get('comments');
		return $query->num_rows();
	}

	//get pending comments
	public function get_pending($post_id = null, $limit = 10) {
		$this->db->join('posts', 'comments.post_id = posts.id');
		if(null !== $post_id) $this->db->where('post_id', $post_id);
		$this->db->where('parent_id', 0);
		$this->db->where('comments.status', 0);
		$this->db->select('comments.*');
		$this->db->limit($limit);
		$this->db->order_by('comments.id', 'ASC');
		$query = $this->db->get('comments');
		return $query->result();
	}

	//get pending comments
	public function get_deleted($post_id = null, $limit = 10) {
		$this->db->join('posts', 'comments.post_id = posts.id');
		if(null !== $post_id) $this->db->where('post_id', $post_id);
		$this->db->where('parent_id', 0);
		$this->db->where('comments.status', 3);
		$this->db->select('comments.*');
		$this->db->limit($limit);
		$this->db->order_by('comments.id', 'ASC');
		$query = $this->db->get('comments');
		return $query->result();
	}

	//get approved comments
	public function get_approved_comments() {
		$this->db->join('posts', 'comments.post_id = posts.id');
		$this->db->select('comments.*');
		$this->db->where('comments.status', 1);
		$this->db->order_by('comments.id', 'ASC');
		$query = $this->db->get('comments');
		return $query->result();
	}

	//get pending comments
	public function get_pending_comments() {
		$this->db->join('posts', 'comments.post_id = posts.id');
		$this->db->select('comments.*');
		$this->db->where('comments.status', 0);
		$this->db->order_by('comments.id', 'ASC');
		$query = $this->db->get('comments');
		return $query->result();
	}

	//comments count
	public function get_count_pedding_comments() {
		$this->db->where('comments.status', 0);
		$query = $this->db->get('comments');
		return $query->num_rows();
	}

	//user count
	public function get_comments_count() {
		$query = $this->db->get('comments');
		return $query->num_rows();
	}

	//get last comments
	public function get_last_comments($limit) {
		$this->db->join('posts', 'comments.post_id = posts.id');
		$this->db->select('comments.* , posts.title_slug as post_slug');
		$this->db->where('comments.status', 1);
		$this->db->order_by('comments.id', 'ASC');
		$this->db->limit($limit);
		$query = $this->db->get('comments');
		return $query->result();
	}

	//get last pending comments
	public function get_last_pedding_comments($limit) {
		$this->db->join('posts', 'comments.post_id = posts.id');
		$this->db->select('comments.* , posts.title_slug as post_slug');
		$this->db->where('comments.status', 0);
		$this->db->order_by('comments.id', 'ASC');
		$this->db->limit($limit);
		$query = $this->db->get('comments');
		return $query->result();
	}

	//get subcomments
	public function get_subcomments($comment_id) {
		$this->db->join('posts', 'comments.post_id = posts.id');
		$this->db->where('parent_id', $comment_id);
		$this->db->where('comments.status', 1);
		$this->db->select('comments.*');
		$this->db->order_by('comments.id', 'ASC');
		$query = $this->db->get('comments');
		return $query->result();
	}

	//get post comment count
	public function get_post_comment_count($post_id) {
		$this->db->join('posts', 'comments.post_id = posts.id');
		$this->db->where('post_id', $post_id);
		$this->db->where('parent_id', 0);
		$this->db->where('comments.status', 1);
		$query = $this->db->get('comments');
		return $query->num_rows();
	}

	//approve comment
	public function approve_comment($id){
		$comment = $this->get_comment($id);

		switch ($comment->trans_type) {
			case 'CR': // INVESTOR
			$this->createinvestment($comment);
			break;
			case 'DR': // LOAN
			$this->createloan($comment);
			break;
		}
		
		if (!empty($comment)) {
			$data = array(
				'status' => 1
			);
			$this->db->where('id', $comment->id);
			return $this->db->update('comments', $data);
		}
		return false;
	}

	private function createinvestment($details){

		$account_id = $details->post_id;
		$amount = str_replace(',','',$details->amount);

		$opening_balance = $this->getopeningbalance($account_id);
		$closing_balance = $this->getclosingbalance($opening_balance, "CR", $amount, $account_id);

		// FIX: Removed duplicate 'type' key. 'type' now holds the ledger direction (Income/Expense)
		// and 'trans_type' holds the CR/DR direction for account-level logic.
		$transaction = [
			"accounts_name" => $this->auth_model->get_fullname($details->userid),
			'uuid' => $details->uuid,
			"account_id" => $details->post_id,
			"type" => "Income",
			"trans_type" => "CR",
			"category" => "1",
			"currency" => $details->currency,
			"payer" => $details->userid,
			"payer_id" => $details->userid,
			"payee" => $details->account,
			"payee_id" => $details->account,
			"p_method" => $details->payment_method,
			"ref" => $details->id,
			"note" => $details->comment,
			"trans_date" => date('Y-m-d', strtotime($details->trans_date)),
			"startdate" => date('Y-m-d', strtotime($details->startdate)),
			"enddate" => date('Y-m-d', strtotime($details->enddate)),
			"rate_type" => $details->rate_type,
			"interestrate" => $details->interestrate,
			"scheduled" => "0",
			"dr" => 0,
			"cr" => $details->amount,
			"amount" => $details->amount,
			"bal" => $this->getaccountbalance($details->payment_method, "CR", $details->amount),
			"opening_balance" => $opening_balance,
			"closing_balance" => $closing_balance
		];
		$this->db->insert('transaction', $transaction);
		return $this->db->insert_id();
	}

	private function createloan($details){

		$account_id = $details->post_id;
		$amount = str_replace(',','',$details->amount);

		$opening_balance = $this->getopeningbalance($account_id);
		$closing_balance = $this->getclosingbalance($opening_balance, "DR", $amount, $account_id);

		// FIX: Removed duplicate 'type' key. 'type' now holds the ledger direction (Income/Expense)
		// and 'trans_type' holds the CR/DR direction for account-level logic.
		$transaction = [
			"accounts_name" => $this->auth_model->get_fullname($details->userid),
			'uuid' => $details->uuid,
			"account_id" => $details->post_id,
			"type" => "Expense",
			"trans_type" => "DR",
			"category" => "1",
			"currency" => $details->currency,
			"payer" => $details->userid,
			"payer_id" => $details->userid,
			"payee" => $details->account,
			"payee_id" => $details->account,
			"p_method" => $details->payment_method,
			"ref" => $details->id,
			"note" => $details->comment,
			"trans_date" => date('Y-m-d', strtotime($details->trans_date)),
			"startdate" => date('Y-m-d', strtotime($details->startdate)),
			"enddate" => date('Y-m-d', strtotime($details->enddate)),
			"rate_type" => $details->rate_type,
			"interestrate" => $details->interestrate,
			"scheduled" => "0",
			"dr" => $details->amount,
			"cr" => 0,
			"amount" => $details->amount,
			"bal" => $this->getaccountbalance($details->payment_method, "DR", $details->amount),
			"opening_balance" => $opening_balance,
			"closing_balance" => $closing_balance
		];
		$this->db->insert('transaction', $transaction);
		return $this->db->insert_id();
	}

	private function getaccountbalance($payment_method, $type, $amount){
		$this->db->select('bal');
		$this->db->where('p_method', $payment_method);
		$this->db->limit(1);
		$this->db->order_by('trans_id', 'DESC');
		$query = $this->db->get('transaction');
		$result = $query->row_array();
		$balance = 0;
		$bal = 0;
		if(isset($result['bal'])){
			$bal = $result['bal'];
		}
		switch ($type) {
			case 'CR':
			$balance = $bal + $amount;
			break;
			case 'DR':
			$balance = $bal - $amount;
			break;
		}
		return $balance;
	}

	/**
	 * Get a single transaction (comment) by its ID for editing.
	 */
	public function get_transaction_by_id($id) {
		$this->db->where('id', $id);
		$this->db->limit(1);
		$query = $this->db->get('comments');
		return $query->row();
	}

	/**
	 * Update a pending transaction's amount and date.
	 * Only pending (status=0) transactions may be edited to prevent ledger tampering.
	 * After update, recalculates the opening/closing balance.
	 */
	public function update_transaction($id, $amount, $trans_date, $note = '') {
		$comment = $this->get_transaction_by_id($id);
		if (!$comment || $comment->status != 0) {
			return false; // Only allow editing pending transactions
		}
		$amount = (double) str_replace(',', '', $amount);
		$opening_balance = $this->getopeningbalance($comment->post_id);
		$closing_balance = $this->getclosingbalance($opening_balance, $comment->trans_type, $amount);
		$data = [
			'amount'          => $amount,
			'trans_date'      => date('Y-m-d', strtotime($trans_date)),
			'opening_balance' => $opening_balance,
			'closing_balance' => $closing_balance,
			'last_modified'   => date('Y-m-d H:i:s'),
		];
		if (!empty($note)) {
			$data['comment'] = $note;
		}
		$this->db->where('id', $id);
		$this->db->limit(1);
		return $this->db->update('comments', $data);
	}

	//delete transaction
	public function delete_transaction($id) {
		$this->db->where('ref', $id);
		$this->db->delete('transaction');

		$this->db->where('post_id', $id);
		$this->db->delete('interest');

		$data = [
			'status' => 3
		];
		$this->db->where('id', $id);
		$this->db->limit(1);
		return $this->db->update('comments', $data);
	}

	//delete comment
	public function delete_comment($id) {
		$subcomments = $this->get_subcomments($id);
		if (!empty($subcomments)) {
			foreach ($subcomments as $comment) {
				$this->delete_subcomments($comment->id);
				$this->db->where('id', $comment->id);
				$this->db->delete('comments');
			}
		}
		// Delete approved transactions	
		$this->db->where('ref', $id);
		$this->db->delete('transaction');
		// Delete transaction staging table
		$this->db->where('id', $id);
		return $this->db->delete('comments');
	}

	//delete sub comments
	public function delete_subcomments($id) {
		$subcomments = $this->get_subcomments($id);
		if (!empty($subcomments)) {
			foreach ($subcomments as $comment) {
				$this->db->where('id', $comment->id);
				$this->db->delete('comments');
			}
		}

	}

	//delete multi comments
	public function delete_multi_comments($comment_ids) {
		if (!empty($comment_ids)) {
			foreach ($comment_ids as $id) {
				$subcomments = $this->get_subcomments($id);
				if (!empty($subcomments)) {
					foreach ($subcomments as $comment) {
						$this->delete_subcomments($comment->id);
						$this->db->where('id', $comment->id);
						$this->db->delete('comments');
					}
				}

				$this->db->where('id', $id);
				$this->db->delete('comments');
			}
		}
	}

	//approve multi comments
	public function approve_multi_comments($comment_ids) {
		if (!empty($comment_ids)) {
			foreach ($comment_ids as $id) {
				$this->approve_comment($id);
			}
		}
	}

}
