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

	// URI: orders
	public function index(){
		$this->load->library('form_validation');
		$data['title'] = 'Orders';
		$data['page'] = 'orders/index';
		$data['orders'] = $this->orders_model->myOrders();
		$this->load->library('layout',$data);
	}
	
	// URI: orders/recount
	// Auth: Buyer
	public function recount(){
		$this->load->library('form_validation');

		// Take the array of information about the various orders.
		$list = $this->input->post('quantity');

		// Get the buyers hash.
		$buyerHash = $this->my_session->userdata('userHash');
		
		$orders = array();

		// Loop through each order to the Vendors.
		foreach($list as $byseller){
			// The current entry of the items in the resultant array.
			$count = 0;

			// Load a list of item hashs in the order to this vendor.
			$keys = array_keys($byseller);

			// Loop through each item in the list.
			foreach($byseller as $quantity){
			
				// Take the item hash from the list of array keys.
				$itemHash = $keys[$count];

				// Load information about the item.
				$itemInfo = $this->items_model->getInfo($itemHash);
				
				// Load the current order. 
				$currentOrder = $this->orders_model->check($buyerHash,$itemInfo['sellerID']);

				// Build an array of the info to update.
				$updateOrder = array(	'id' => $currentOrder[0]['id'],
							'itemHash' => $itemInfo['itemHash'],
							'quantity' => $quantity);
	
				// Try update the order.
				if($this->orders_model->updateOrder($updateOrder) === TRUE){
					$data['returnMessage'] = "Your order has been updated.";
					// Success!
				} else {
					$data['returnMessage'] = 'Unable to update your order.';
					// Failure
				}
				$count++; // Increase the item position by one.
			}
			
		}
		$data['title'] = 'Orders';
		$data['page'] = 'orders/index';
		$data['orders'] = $this->orders_model->myOrders();
		$this->load->library('layout',$data);
	}
	
	// URI: order/
	// 
	public function orderItem($itemHash){
		$this->load->library('form_validation');

		// Load information about the item
		$itemInfo = $this->items_model->getInfo($itemHash);

		// Check the item exists.
		if($itemInfo === NULL){
			$data['title'] = 'Not Found';
			$data['page'] = 'orders/index';
			$data['returnMessage'] = 'That item was not found.';
			$data['orders'] = $this->orders_model->myOrders();
			// Failure; item not found.
		} else {
			// Item found.

			// Load information about the buyer.
			$userInfo = $this->users_model->get_user(array('userHash' => $this->my_session->userdata('userHash')));
			
			// Load the order to be placed to the vendor.
			$currentOrder = $this->orders_model->check($userInfo['userHash'],$itemInfo['sellerID']);

			if($currentOrder === NULL){
				// No current order to that seller

				// Build array used to create the order.
				$placeOrder = array(	'buyerHash' => $userInfo['userHash'],
							'sellerHash' => $itemInfo['sellerID'],
							'items' => $itemHash."-1",
							'totalPrice' => $itemInfo['price'],
							'currency' => $itemInfo['currency'],
							'time' => time() );

				// Create the order.
				if($this->orders_model->createOrder($placeOrder)){
					// Success; Order placed.
					$data['title'] = 'Order Placed';
					$data['returnMessage'] = 'Your order has been created.';
			
				} else {
					$data['title'] = 'Orders';
					$data['returnMessage'] = 'Unable to add this item to your order, please try again.';
					// Failure; unable to submit the order.
				}
			} else {
				// There is currently an order to that Vendor.

				// Check the order can still be updated.
				if($currentOrder[0]['step'] == '0'){
					// Order has not yet been placed.

					// Load the current quantity of the item in the order.			
					$currentQuantity = $this->orders_model->getQuantity($itemHash);

					// Build the array for updating the order, increasing the current quantity by one.
					$updateOrder = array(	'id' => $currentOrder[0]['id'],
								'itemHash' => $itemHash,
								'quantity' =>  $currentQuantity+1);

					// Check submission is successful
					if($this->orders_model->updateOrder($updateOrder)){
						$data['title'] = 'Item Added';
						$data['returnMessage'] = 'The item has been added to your order.';
						// Success; order updated with new quantity.
					} else {
						$data['title'] = 'Orders';
						$data['returnMessage'] = 'Unable to add this item to your order, please try again.';
						// Failure; unable to update order.
					}
				} else {
					// Order cannot be changed.
					$data['title'] = 'Order already placed';
					$data['returnMessage'] = 'This order has already been placed. Please contact your vendor to discuss any further changes.';

				}
			}
		}

		$data['page'] = 'orders/index';

		// Load a list of the Buyers orders.
		$data['orders'] = $this->orders_model->myOrders();	
		$this->load->library('layout',$data);
	}

	// URI: order/place/
	// Auth: Buyer
	public function place($sellerHash){
		$this->load->library('form_validation');
		$this->load->model('messages_model');

		// Load the Buyers hash.
		$currentUser = $this->my_session->userdata('userHash');

		// Load the current order.
		$currentOrder = $this->orders_model->check($currentUser,$sellerHash);

		// Check the order currently exists.
		if($currentOrder === NULL){
			$data['title'] = 'Error';
			$data['returnMessage'] = 'You currently have no orders for this user.';
			// Failure; Order does not exist.
		} else {
			// Order exists.

			// Check the order has not already been placed.
			if($currentOrder[0]['step'] == "0"){
				// Order has not already been placed.

				// Update the specified order from step 0 to 1.
				if($this->orders_model->nextStep($currentOrder[0]['id'],'0') === TRUE){

					// Send the seller a message about the order
					$messageText = "You have received a new order from ".$currentOrder[0]['buyer']['userName']."\n\n";

					// Loop through the items in the order.
					for($i = 0; $i < count($currentOrder[0]['items']); $i++){
						// Add the item and quantity to the message.
						$messageText.= "{$currentOrder[0]['items'][$i]['quantity']} x {$currentOrder[0]['items'][$i]['name']}\n";
					}

					// Info about the total price.	
					$messageText .= "Total price: {$currentOrder[0]['currencySymbol']}{$currentOrder[0]['totalPrice']}";

					// Generate hash for the message, and the messages thread.
					$messageHash = $this->general->uniqueHash('messages','messageHash');
					$threadHash = $this->general->uniqueHash('messages','threadHash');

					// Build an array of information about the message.
					$messageArray = array(  'toId' => $currentOrder[0]['seller']['id'],
							        'fromId' => $currentOrder[0]['buyer']['id'],
							        'messageHash' => $messageHash,
								'orderID' => $currentOrder[0]['id'],
								'subject' => "New Order from ".$currentOrder[0]['buyer']['userName'],
								'message' => nl2br($messageText),
								'encrypted' => '0',
								'time' => time(),
								'threadHash' => $threadHash
					);

					$data['title'] = 'Order Placed';
					$data['returnMessage'] = 'Your order has been placed. Please authorize payment to this sellers account to continue.';

					// Check whether the message could be sent.
					if($this->messages_model->addMessage($messageArray) !== TRUE){
						// Unable to send the Vendor a message.
						$data['returnMessage'].= "Unable to send a message to {$currentOrder[0]['buyer']['userName']}";
					}
					// Success; Order submitted.

				} else {
					$data['title'] = 'Error';
					$data['returnMessage'] = 'Unable to progress this order, please try again later.';
					// Failure; Unable to progress the order.
				}
			} else {
				$data['title'] = 'Error';
				$data['returnMessage'] = 'This order has already been placed.';
				// Failure; Order is already past step 0.
			}	
		}

		$data['page'] = 'orders/index';
		$data['orders'] = $this->orders_model->myOrders();
		$this->load->library('layout',$data);
	}

	// URI: order/review/
	// Auth: Buyer
	public function review($id){	
		$this->load->library('form_validation');

		// Load the buyer hash
		$buyerHash = $this->my_session->userdata('userHash');

		// Load information about the current order. 
		$currentOrder = $this->orders_model->getOrderByID($id);

		// Load information about the order.
		$data['order'] = $currentOrder[0];

		// Check the order exists.
		if($currentOrder !== NULL){
			// Order has been found.

			// Check the buyerHash matches that of the currently logged in user.
			if($data['order']['buyer']['userHash'] == $buyerHash){			
				// Check the order can be reviewed.	
				if($data['order']['step'] == 3){
	
					if($this->form_validation->run('reviewOrder')===TRUE){
						// Load the comments and rating from post data.
						$comments = $this->input->post('comment');
						$rating = $this->input->post('rating');

						// Build an array of information about the review.
						$reviewOrder = array(	'reviewedID' => $data['order']['seller']['id'],
								     	'comments' => $comments,
									'rating' => $rating,
									'orderID' => $id );
			
						// Review the vendor after the order.
						if($this->orders_model->review($reviewOrder,'Vendor') === TRUE){
							$data['title'] = "Orders";
							$data['returnMessage'] = "Your review for order #$id has been submitted.";
							$data['page'] = 'orders/index';
							$data['orders'] = $this->orders_model->myOrders();
							// Success; Submission Successful.
						} else {
							$data['title'] = "Review: #$id";
							$data['returnMessage'] = "An error occured during your submission, please try again.";
							$data['page'] = "orders/review";
							// Failure; Unable to insert the review.
						}
					} else {
						$data['title'] = "Review: #$id";
						$data['returnMessage'] = "";
						$data['page'] = 'orders/review';
						// Failure; Form submission unsuccessful; display the form again.
					}
				} else {
					$data['title'] = "Not Allowed";
					$data['returnMessage'] = "You are not allowed to review this order.";
					$data['page'] = 'orders/index';
					$data['orders'] = $this->orders_model->myOrders();
					// Failure; Order is not ready for the order.
				}
			} else {
				$data['title'] = "Not Allowed";
				$data['returnMessage'] = "You are not allowed to review this order.";
				$data['page'] = 'orders/index';
				$data['orders'] = $this->orders_model->myOrders();
				// Failure; Currently logged in user did not place the order.
			}
		} else {
			$data['title'] = "Not Found";
			$data['returnMessage'] = "This order can not be found.";
			$data['orders'] = $this->orders_model->myOrders();
			$data['page'] = 'orders/index';
			// Failure; Order does not exist.
		}
		$this->load->library('layout',$data);
	}



	// For the Vendors

	// Confirm Item Dispatch
	// URI: dispatch/confirm/
	// Auth: Vendor
	public function confirmDispatch($buyerHash){
		$this->load->model('messages_model');
		$sellerHash = $this->my_session->userdata('userHash');
		$orderInfo = $this->orders_model->check($buyerHash,$sellerHash);

		// Confirm order exists & buyer/seller is correct.
		if($orderInfo === NULL){
			$data['title'] = 'Not Found';
			$data['page'] = 'orders/purchases';
			$data['returnMessage'] = 'This order does not exist.';
			// Failure; order cannot be found.
		} else {
			// Order found.
			
			// Check the order can be progressed from step 2.
			if($this->orders_model->nextStep($orderInfo[0]['id'],'2') === TRUE){
				// Order has been progressed.	
	
				// Build a message informing the user the order has been dispatched.
				$messageHash = $this->general->uniqueHash('messages','messageHash');
				$messageText = "Your item has now been dispatched by {$orderInfo[0]['seller']['userName']}. For delivery information please contact your Vendor.";
				$messageArray = array(  'toId' => $orderInfo[0]['buyer']['id'],
						        'fromId' => $orderInfo[0]['seller']['id'],
						        'messageHash' => $messageHash,
							'orderID' => $orderInfo[0]['id'],
							'subject' => "Order has been dispatched: ".$orderInfo[0]['id'],
							'message' => nl2br($messageText),
							'encrypted' => '0',
							'time' => time() );

				$data['returnMessage'] = "You have confirmed this item has been dispatched. ";
				// Check the message was sent.
				if($this->messages_model->addMessage($messageArray) !== TRUE){
					$data['returnMessage'] .= "Payment has been confirmed. The item may now be dispatched. An error occurred sending a message to {$orderInfo[0]['buyer']['userName']}.";
				}			
				// Success; order confirmed as dispatched.
			} else {
				$data['title'] = "Error";
				$data['page'] = 'orders/purchases';
				$data['returnMessage'] = "An error was encountered while trying to progress your order, please try again.";
				// Failure; unable to dispatch the order.
			}
		}

		// Get userHash from the session.
		$hash = $this->my_session->userdata('userHash');
		// Load the current users items.
		$data['items'] = $this->items_model->userListings($sellerHash);
		// Load unconfirmed orders for the current user.
		$data['newOrders'] = $this->orders_model->ordersByStep($sellerHash,1);
		// Load orders for dispatch
		$data['dispatchOrders'] = $this->orders_model->ordersByStep($sellerHash,2);

		$this->load->library('layout',$data);
	}

	// Confirm Receipt of Payment
	// URI: payment/confirm
	// Auth: Vendor
	public function confirmPayment($buyerHash){
		$this->load->model('messages_model');

		$sellerHash = $this->my_session->userdata('userHash');
		$orderInfo = $this->orders_model->check($buyerHash,$sellerHash);

		// Check if the order exists, or whether user is the buyer/seller.
		if($orderInfo === NULL){
			// Not found, or neither user corrent.
			$data['title'] = 'Not Found';
			$data['returnMessage'] = 'This order does not exist.';
		} else {
			// Move the order from step 1 to 2.
			if($this->orders_model->nextStep($orderInfo[0]['id'],'1') === TRUE){
				// Order has been progressed. 
			
				// Generate a message hash.
				$messageHash = $this->general->uniqueHash('messages','messageHash');
	
				// Send a message informing the Buyer payment was received.
				$messageText = "Your payment has been confirmed as received by {$orderInfo[0]['seller']['userName']}. The order will now be dispatched.";

				$messageArray = array(  'toId' => $orderInfo[0]['buyer']['id'],
						        'fromId' => $orderInfo[0]['seller']['id'],
						        'messageHash' => $messageHash,
							'orderID' => $orderInfo[0]['id'],
							'subject' => "Ready for dispatch: ".$orderInfo[0]['id'],
							'message' => nl2br($messageText),
							'encrypted' => '0',
							'time' => time() );

				$data['title'] = "Payment Confirmed";
				$data['returnMessage'] = 'Payment has been received. The item may now be dispatched.';				

				// Check whether the message was sent successfully.
				if($this->messages_model->addMessage($messageArray) !== TRUE){
					$data['returnMessage'] .= "An error occurred sending a message to {$orderInfo[0]['buyer']['userName']}.";
				}
				// Success; Payment confirmed by Vendor.
			} else {
				$data['title'] = 'Error';
				$data['returnMessage'] = 'Unable to confirm payment.';
				// Failure; Unable to confirm the payment.
			}
		}

		$data['items'] = $this->items_model->userListings($sellerHash);
	
		// Load unconfirmed orders for the current user.
		$data['newOrders'] = $this->orders_model->ordersByStep($sellerHash,1);
	
		// Load orders for dispatch
		$data['dispatchOrders'] = $this->orders_model->ordersByStep($sellerHash,2); 

		$data['page']= 'orders/purchases';
	
		$this->load->library('layout',$data);
	}


	public function purchases(){
		$data['title'] = 'Purchases';
		$data['page'] = 'orders/purchases';

		$sellerHash = $this->my_session->userdata('userHash');
				
		// Load unconfirmed orders for the current user.
		$data['newOrders'] = $this->orders_model->ordersByStep($sellerHash,1);
		
		// Load orders for dispatch
		$data['dispatchOrders'] = $this->orders_model->ordersByStep($sellerHash,2); 

		$this->load->library('layout',$data);
	}

	public function callback_check_rating($param){
		if(is_numeric($param) && $param >= 1 && $param <= 5){
			return TRUE;
		} else {
			return FALSE;
		}
	}
};

