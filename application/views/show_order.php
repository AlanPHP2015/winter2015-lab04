<p class="lead">
    Order # {order_num} for {total}
</p>
<table style="table-layout:fixed;">
    <tr>
        <th>Item</th>
        <th>Description</th>
        <th>Quantity</th>
    </tr>
{items}
    <tr>
        <td style="word-wrap: break-word">
        {code}
        </td>
        <td style="word-wrap: break-word">
            {description}
        </td>
        <td style="word-wrap: break-word">
            {quantity}
        </td>
    </tr>

{/items}

</table>
<div class="row">
    <a href="/order/commit/{order_num}" class="btn btn-large btn-success {okornot}">Proceed</a>
    <a href="/order/display_menu/{order_num}" class="btn btn-large btn-primary">Keep shopping</a>
    <a href="/order/cancel/{order_num}" class="btn btn-large btn-danger">Forget about it</a>
</div>