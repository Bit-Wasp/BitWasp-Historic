<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

	public function __construct(){ 
		parent::__construct();
		$this->load->model('orders_model');
		$this->load->model('items_model');
		$this->load->model('users_model');
		$this->load->model('currency_model');
		$this->load->library('my_session');
	}

	public function index(){
		$data['title'] = 'Orders';
		$data['page'] = 'orders/index';
		$data['orders'] = $this->orders_model->myOrders();
		$this->load->library('layout',$data);
	}

	public function orderItem($itemHash){
		$itemInfo = $this->items_model->getInfo($itemHash);
		if($itemInfo === NULL){
			// Item not fond
			$data['title'] = 'Not Found';
			$data['page'] = 'orders/index';
			$data['returnMessage'] = 'That item was not found.';
			$this->load->library('layout',$data);

		} else {
			$userInfo = $this->users_model->get_user($this->my_session->userdata('userHash'));
			
			$currentOrder = $this->orders_model->check($userInfo['userHash'],$itemInfo['sellerID']);

			if($currentOrder === NULL){
				// No current order to that seller
				$placeOrder = array(	'buyerHash' => $userInfo['userHash'],
							'sellerHash' => $itemInfo['sellerID'],
							'items' => $itemHash."-1",
							'totalPrice' => $itemInfo['price'],
							'currency' => $itemInfo['currency'],
							'time' => time() );

				if($this->orders_model->createOrder($placeOrder)){
					// Order placed.
					$data['title'] = 'Order Placed';
					$data['page'] = 'orders/index';
					$data['returnMessage'] = 'Your order has been created.';
					$data['orders'] = $this->orders_model->myOrders();
			
				} else {
					// Unable to place this order!
					$data['title'] = 'Orders';
					$data['page'] = 'orders/index';
					$data['returnMessage'] = 'Unable to add this item to your order, please try again.';
					$data['orders'] = $this->orders_model->myOrders();
				}
			} else {
	
				$placeOrder = array(	'id' => $currentOrder['id'],
							'price' => $itemInfo['price'],
							'currency' => $itemInfo['currency'],
							'itemHash' => $itemHash );

				if($this->orders_model->updateOrder($placeOrder)){
					// Order updated with new information
					$data['title'] = 'Item Added';
					$data['page'] = 'orders/index';
					$data['returnMessage'] = 'The item has been added to your order.';
					$data['orders'] = $this->orders_model->myOrders();
				} else {
					$data['title'] = 'Orders';
					$data['page'] = 'orders/index';
					$data['returnMessage'] = 'Unable to add this item to your order, please try again.';
						$data['orders'] = $this->orders_model->myOrders();	
				}
			}
		
		}
		$this->load->library('layout',$data);
	}

	public function place($sellerHash){
		$this->load->model('messages_model');
		$currentUser = $this->my_session->userdata('userHash');
		$currentOrder = $this->orders_model->check($currentUser,$sellerHash);

		if($currentOrder === NULL){
			// Order placed.
			$data['title'] = 'Error';
			$data['page'] = 'orders/index';
			$data['returnMessage'] = 'You currently have no orders for this user.';
			$data['orders'] = $this->orders_model->myOrders();
		} else {
			if($currentOrder['step'] == '0'){
				if($this->orders_model->nextStep($currentOrder['id']) === TRUE){

					$sellerInfo = $this->users_model->get_user($sellerHash);
					$currentUserInfo = $this->users_model->get_user($currentUser);

					// Send the seller a message about the order
					$messageText = "You have received a new order from ".$currentUserInfo['userName']."\n\n";

					$items = explode(":",$currentOrder['items']);
					foreach($items as $item){
						$info = explode("-",$item);
						$itemInfo = $this->items_model->getInfo($info[0]);	
						$quantity = $info[1];
						$messageText.= "$quantity x {$itemInfo['name']}\n";
					}

					$currencySymbol = $this->currency_model->get_symbol($currentOrder['currency']);
					$messageText.= "Total price: {$currencySymbol}{$currentOrder['totalPrice']}";

					$messageHash = $this->general->uniqueHash('messages','messageHash');
					$messageArray = array(  'toId' => $sellerInfo['id'],
							        'fromId' => $currentUserInfo['id'],
							        'messageHash' => $messageHash,
								'orderID' => $currentOrder['id'],
								'subject' => "New Order from ".$currentUserInfo['userName'],
								'message' => nl2br($messageText),
								'encrypted' => '0',
								'time' => time() );

					if($this->messages_model->addMessage($messageArray) === TRUE){

						$data['title'] = 'Order Placed';
						$data['page'] = 'orders/index';
						$data['returnMessage'] = 'Your order has been placed. Please authorize payment to this sellers account to continue.';
						$data['orders'] = $this->orders_model->myOrders();	
					} else {
						echo "Unable to send seller a message..";
					}

				} else {
					$data['title'] = 'Error';
					$data['page'] = 'orders/index';
					$data['returnMessage'] = 'Unable to progress this order, please try again later.';
					$data['orders'] = $this->orders_model->myOrders();
				}
			} else {
				$data['title'] = 'Error';
				$data['page'] = 'orders/index';
				$data['returnMessage'] = 'This order has already been placed.';
				$data['orders'] = $this->orders_model->myOrders();
			}	
		}
		$this->load->library('layout',$data);
	}

};

