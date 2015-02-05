<?php

/**
 * Data access wrapper for "orders" table.
 *
 * @author jim
 */
class Orders extends MY_Model {

    // constructor
    function __construct() {
        parent::__construct('orders', 'num');
    }

    // add an item to an order
    function add_item($num, $code) {
        $existingItem = $this->
                        db->
                        get_where('orderitems',
                                array('item' => $code, 'order' => $num))->row();
        if ($existingItem != null) {
            $existingItem->quantity += 1;
            $this->orderitems->update($existingItem);
        } else {
            $newOrderItem = $this->orderitems->create();
            $newOrderItem->item = $code;
            $newOrderItem->order = $num;
            $newOrderItem->quantity = 1;
            $this->orderitems->add($newOrderItem);
        }
    }

    // calculate the total for an order
    function total($num) {
        $total = 0.0;
        $items = $this->db->query('SELECT quantity, price '.
                'FROM `menu` '.
                'INNER JOIN `orderitems` ON menu.code = orderitems.item '.
                'WHERE orderitems.order = '.$num)->result();
        if($items != null) {
            foreach($items as $item) {
                $total += $item->quantity * $item->price;
            }
        }
        return $total;
    }

    // retrieve the details for an order
    function details($num) {
        $this->db->select('quantity, item AS "code", description');
        $this->db->from('orderitems');
        $this->db->join('menu', 'orderitems.item = menu.code');
        $this->db->where('orderitems.order', $num);
        $details = $this->db->get()->result();
//        die(var_dump($details));
        return $details;
    }

    // cancel an order
    function flush($num) {
        
    }

    // validate an order
    // it must have at least one item from each category
    function validate($num) {
        return false;
    }

}
