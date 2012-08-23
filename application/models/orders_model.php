<?php

class Orders_model extends CI_Model {
		
	public function __construct(){
		$this->load->library('my_session');
		$this->load->model('currency_model');
		$this->load->model('items_model');
	}

	public function nextStep($orderID,$fromStep){
		$orderInfo = $this->getOrderByID($orderID);
		if($orderInfo === NULL){
			return NULL;
		} else {
			$this->db->select('step');
			$this->db->where('id',$orderID);
			$query = $this->db->get('orders');
			$result = $query->result();
			if($result[0]->step !== $fromStep){
				return NULL;
			}
			$this->db->where('id',$orderID);
			$query = $this->db->update('orders',array('step' => ($result[0]->step+1)));
			if($query){
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

	public function myOrders($sellerHash = NULL){
		$this->load->model('users_model');
		$buyer = $this->my_session->userdata('userHash');

		if($sellerHash !== NULL && $this->users_model->get_user(array('userHash' => $sellerHash)) !== FALSE){
			$getOrders = $this->db->get_where('orders',array('buyerHash' => $buyer,
									 'sellerHash' => $sellerHash)
							);
		} else {
			$getOrders = $this->db->get_where('orders',array('buyerHash' => $buyer));
		}

		$orders = $this->buildOrderArray($getOrders);
		
		if($orders === FALSE){
			return NULL;
		} else {
			return $orders;
		}
	}	

	public function buildOrderArray($order){
		if($order->num_rows() > 0){
			$i = 0;
				//print_r($result);
			foreach($order->result() as $result){
				
				$tmp = $result->items;
				$items = explode(":", $tmp);
				$j = 0;
				
				foreach($items as $item){
					$array = explode("-", $item);
					$itemInfo[$j] = $this->items_model->getInfo($array[0]);
					$itemInfo[$j++]['quantity'] = $array[1];
				}

				if($result->step == '0'){
					$stepMessage = anchor('order/place/'.$result->sellerHash,'Place Order');
				} else if($result->step == '1'){
					$stepMessage = 'Vendor awaiting payment.';
				} else if($result->step == '2'){
					$stepMessage = 'Awaiting dispatch.';
				} else if($result->step == '3'){
					$stepMessage = "Completed. ".anchor('order/review/'.$result->sellerHash,'Please Review');
				} else {//Error..
					$stepMessage = 'Gone on too long!';
				}

				$orders[$i++] = array(	'id' => $result->id,
							'seller' => $this->users_model->get_user(array('userHash'=> $result->sellerHash)),
							'buyer' => $this->users_model->get_user(array('userHash'=> $result->buyerHash)),
							'totalPrice' => $result->totalPrice,
							'currency' => $result->currency,
							'currencySymbol' => $this->currency_model->get_symbol($result->currency),
							'time' => $result->time,
							'dispTime' => $this->general->displayTime($result->time),
							'items' => $itemInfo,
							'step' => $result->step,
							'progress' => $stepMessage );
				unset($itemInfo);
			}
//			print_r($orders);
			return $orders;
		} else {
			return FALSE;
		}
	}

	public function ordersByStep($userID,$step){
		$query = $this->db->get_where('orders', array('sellerHash' => $userID,
							  'step' => $step ) );
		$orders = $this->buildOrderArray($query);

		if($orders === FALSE){
			return NULL;
		} else {
			return $orders;
		}
	}

	public function check($buyer,$seller){
		$query = $this->db->get_where('orders',array(	'buyerHash' => $buyer,
								'sellerHash' => $seller));
		if($query->num_rows() > 0){
			return $this->buildOrderArray($query);
		} else {
			return NULL;
		}
	}

	public function createOrder($orderInfo){
		$query = $this->db->insert('orders',$orderInfo);
		if($query){ 
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function getOrderByID($id){
		$query = $this->db->get_where('orders', array('id' => $id));
		if($query->num_rows() > 0){
			return $query->row_array();
		} else {
			return NULL;
		}
	}

	public function updateOrder($orderInfo){
		$info = $this->getOrderByID($orderInfo['id']);

		$items = explode(':',$info['items']);
		$found = false;
		$newItems = '';
		$place = 0;
		foreach($items as $item){
			$order = explode('-', $item);
			$quantity = $order[1];
			$hash = $order[0];
		
			if($hash == $orderInfo['itemHash']){
				$quantity = ($order[1]+1);
				$found = true;
			}
			if($place++ !== 0)
				$newItems .= ":";

			$newItems.= $hash."-".$quantity;
		}

		if($found === false){
			$newItems.= ":".$orderInfo['itemHash']."-1";
		}

		$order = array( 'items' => $newItems,
				'totalPrice' => $info['totalPrice']+$orderInfo['price'],
				'currency' => $orderInfo['currency'],
				'time' => time() );

		$this->db->where('id',$info['id']);
		if($this->db->update('orders',$order)){
			return TRUE;
		} else {
			return FALSE;
		}
	}


};


