
<table class="table data-table table-bordered" id="bootstrap-data-table-export">
    <thead>
        <tr>
            <th>Sl No.</th>
            <th>Member ID</th>
            <th>Member Name</th>
            <th>Sponsor ID</th>
            <th>Sponsor Name</th>
            <th>Joining Date</th>
            <th>Activation Date</th>
            <th>Package</th>
            <th class="select-filter">Status</th>
            <?php if($this->session->role=='admin'){ ?>
           	<th>Password</th>
            <th>Action</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
            $members=$members;
            if(is_array($members)){$i=0;
                foreach($members as $member){
                    $i++;
                    $status="<span class='text-danger'>Not activated</span>";
                    if($member['status']==1){
                        $status="<span class='text-success'>Activated</span>";
                    }
					elseif($member['status']==2){
                        $status="<span class='text-danger'>ID Blocked</span>";
                    }
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $member['username']; ?></td>
            <td><?php echo $member['name']; ?></td>
            <td><?php echo $member['ref']; ?></td>
            <td><?php echo $member['refname']; ?></td>
            <td><?php echo date('d-m-Y',strtotime($member['date'])); ?></td>
            <td><?php if($member['activation_date']!='0000-00-00')echo date('d-m-Y',strtotime($member['activation_date'])); ?></td>
            <td><?php echo $member['package']; ?></td>
            <td><?php echo $status; ?></td>
            <?php if($this->session->role=='admin'){ ?>
            <td>
                <a href="#" onClick="$(this).hide();$(this).parent().find('span').removeClass('hidden');">View Password</a>
                <span class="hidden"><?php echo $member['password']; ?></span>
                <span class="hidden text-danger" onClick="$(this).parent().find('span').addClass('hidden');$(this).parent().find('a').show();"><i class="fa fa-times"></i></span>
            </td>
            <td>
            	<?php /*?><a href="<?php echo base_url('members/editmember/'.$member['regid']); ?>" class="btn btn-xs btn-info"><i class=" fa fa-edit"></i> Edit</a><?php */?>
            </td>
            <?php } ?>
        </tr>
        <?php
                }
            }
        ?>
    </tbody>
</table>