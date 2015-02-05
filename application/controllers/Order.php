<?php

/**
 * Order handler
 * 
 * Implement the different order handling usecases.
 * 
 * controllers/welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Order extends Application {

    function __construct() {
        parent::__construct();
    }

    // start a new order
    function neworder() {
        //FIXME
        $order_num = $this->orders->highest() + 1;
        $newOrder = $this->orders->create();
        $newOrder->num = $order_num;
        $newOrder->date = date('Y-m-d H:i:s');
        $newOrder->status = 'a';
        
        $this->orders->add($newOrder);
        redirect('/order/display_menu/' . $order_num);
    }

    // add to an order
    function display_menu($order_num = null) {
        if ($order_num == null)
            redirect('/order/neworder');

        $this->data['pagebody'] = 'show_menu';
        $this->data['order_num'] = $order_num;
        //FIXME
        
        $order = $this->orders->get($order_num);
        
        // Make the columns
        $this->data['meals'] = $this->make_column('m', $order_num);
        $this->data['drinks'] = $this->make_column('d', $order_num);
        $this->data['sweets'] = $this->make_column('s', $order_num);
        $this->data['title'] = 'Order #' . $order_num . ' (' .
                money_format('%n',$this->orders->total($order_num)).')';
        $this->render();
    }

    // make a menu ordering column
    function make_column($category, $order_num) {
        //FIXME
        $items = $this->menu->some('category',$category);
        foreach($items as $item) {
            $item->order_num = $order_num;
        }
        return $items;
    }

    // add an item to an order
    function add($order_num, $item) {
        //FIXME
        $this->orders->add_item($order_num, $item);
        redirect('/order/display_menu/' . $order_num);
    }

    // checkout
    function checkout($order_num) {
        $this->data['title'] = 'Checking Out';
        $this->data['pagebody'] = 'show_order';
        $this->data['order_num'] = $order_num;
        //FIXME
        $this->data['total'] = money_format('%n', $this->orders->total($order_num));
        $this->data['items'] = $this->orders->details($order_num);
        $this->render();
    }

    // proceed with checkout
    function proceed($order_num) {
        //FIXME
        redirect('/');
    }

    // cancel the order
    function cancel($order_num) {
        //FIXME
        redirect('/');
    }

}
