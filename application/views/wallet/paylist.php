
<table class="table data-table" id="bootstrap-data-table-export">
    <thead>
        <tr>
            <th>Sl No.</th>
            <th>Approve Date</th>
            <th>Member ID</th>
            <th>Member Name</th>
            <th>Account No</th>
            <th>IFSC Code</th>
            <th>Amount</th>
            <th>TDS (5%)</th>
            <th>Admin Charge (5%)</th>
            <th>Paid Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $members=$members;
            if(is_array($members)){$i=0;
                foreach($members as $member){
                    $i++;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo date('d-m-Y',strtotime($member['approve_date'])); ?></td>
            <td><?php echo $member['username']; ?></td>
            <td><?php echo $member['name']; ?></td>
            <td><?php echo $member['account_no']; ?></td>
            <td><?php echo $member['ifsc']; ?></td>
            <td><?php echo $this->amount->toDecimal($member['amount']); ?></td>
            <td><?php echo $this->amount->toDecimal($member['tds']); ?></td>
            <td><?php echo $this->amount->toDecimal($member['admin_charge']); ?></td>
            <td><?php echo $this->amount->toDecimal($member['paidamount']); ?></td>
        </tr>
        <?php
                }
            }
        ?>
    </tbody>
</table>