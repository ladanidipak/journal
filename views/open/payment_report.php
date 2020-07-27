<hr>
<br>
<br>

<table cellspacing="0" cellpadding="5" width="100%" style="text-align: left;">
    <tr>
        <td width="150"><b>transaction mode : </b></td>
        <td>Online</td>
    </tr>
    <tr>
        <td width="150"><b>transaction status : </b></td>
        <td><?= $instamojo->w_status; ?></td>
    </tr>
    <tr>
        <td width="150"><b>transaction id : </b></td>
        <td><?= $instamojo->payment_id; ?></td>
    </tr>
    <tr>
        <td width="150"><b>amount : </b></td>
        <td><?= $instamojo->w_amount_recieved; ?></td>
    </tr>
    <tr>
        <td width="150"><b>transfer done by : </b></td>
        <td><?= $instamojo->w_buyer_name; ?></td>
    </tr>
    <tr>
        <td width="150"><b>time and date : </b></td>
        <td><?= $instamojo->created_dt; ?></td>
    </tr>
    <tr>
        <td width="150"><b>hard copy : </b></td>
        <td><?= (isset($items['hard_copy'])?"Yes":"No"); ?></td>
    </tr>
    <tr>
        <td width="150"><b>plagiarism report : </b></td>
        <td><?= (isset($items['plagiarism_report'])?"Yes":"No"); ?></td>
    </tr>
    <tr>
        <td width="150"><b>additional charges : </b></td>
        <td><?= (isset($items['additional'])?"{$additional->item_desc} -  Rs. {$additional->item_price}":"N/A"); ?></td>
    </tr>
</table>
<br>
