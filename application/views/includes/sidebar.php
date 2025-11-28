
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar <?= SIDEBAR_COLOR ?> elevation-4">
                <!-- Brand Logo -->
                <a href="<?= base_url(); ?>" class="brand-link">
                    <img src="<?= file_url('assets/images/icon.png') ?>" alt="<?= PROJECT_NAME ?> Logo" class="brand-image bg-white img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light"><?= PROJECT_NAME ?></span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="<?=file_url('includes/dist/img/user2-160x160.jpg'); ?>" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block"><?= $this->session->name; ?></a>
                        </div>
                    </div>

                    <!-- SidebarSearch Form -->
                    <div class="form-inline d-none">
                        <div class="input-group" data-widget="sidebar-search">
                            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar nav-compact flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <?php if($this->session->sess_type=='admin_access'){ ?>
                            <li class="nav-item">
                                <a href="<?= base_url('login/backtoadmin'); ?>" class="nav-link ">
                                    <i class="nav-icon fas fa-arrow-left"></i>
                                    <p>Back to Admin Panel</p>
                                </a>
                            </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a href="<?= base_url('home/'); ?>" class="nav-link <?= activate_menu('home'); ?>">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Home</p>
                                </a>
                            </li>
                            <?php
                            if($this->session->role!='admin'){
                            ?>
                            <li class="nav-item has-treeview <?php echo activate_dropdown('profile'); ?>">
                                <a href="#" class="nav-link <?php echo activate_dropdown('profile','a'); ?>">
                                    <i class="nav-icon far fa-user"></i>
                                    <p>My Profile <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url("profile/"); ?>" class="nav-link <?php echo activate_menu('profile'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Profile</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url("changepassword/"); ?>" class="nav-link <?php echo activate_menu('home/changepassword'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Change Password</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url("profile/accdetails/"); ?>" class="nav-link <?php echo activate_menu('profile/accdetails'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Account Details</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url("profile/kyc/"); ?>" class="nav-link <?php echo activate_menu('profile/kyc'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Upload KYC</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php 
                                }else{
                            ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url('changepassword/'); ?>" class="nav-link <?php echo activate_menu('home/changepassword'); ?>">
                                    <i class="nav-icon fas fa-key"></i>
                                    <p>Change Password</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('profile/adminaccdetails/'); ?>" class="nav-link <?= activate_menu('profile/adminaccdetails'); ?>">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Admin Account Details</p>
                                </a>
                            </li>
                            <?php
                                } 
                            ?>
                            <li class="nav-item has-treeview <?= activate_dropdown('members'); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown('members','a'); ?>">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Members <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url("members/"); ?>" class="nav-link <?= activate_menu('members'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Member Registration</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url("members/memberlist/"); ?>" class="nav-link <?= activate_menu('members/memberlist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Member List</p>
                                        </a>
                                    </li>
                                    <?php /*?><li class="nav-item">
                                        <a href="<?= base_url("members/activelist/"); ?>" class="nav-link <?= activate_menu('members/activelist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Active Member List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url("members/inactivelist/"); ?>" class="nav-link <?= activate_menu('members/inactivelist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>In-Active Member List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url("members/renewals/"); ?>" class="nav-link <?= activate_menu('members/renewals'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Member Renewals</p>
                                        </a>
                                    </li><?php */?>
                                    <?php if($this->session->role=='admin'){ ?>
                                    
                                    <li class="nav-item d-none">
                                        <a href="<?= base_url("members/activationrequests/"); ?>" class="nav-link <?= activate_menu('members/activationrequests'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Activation Request List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item d-none">
                                        <a href="<?= base_url("members/approvedactivations/"); ?>" class="nav-link <?= activate_menu('members/approvedactivations'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Approved Activation List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url("members/entertomember/"); ?>" class="nav-link <?= activate_menu('members/entertomember'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Enter to Member</p>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php /*if($this->session->role=='admin'){ ?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url("members/kyc/"); ?>" class="nav-link <?php echo activate_menu("members/kyc"); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>KYC Requests</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url("members/approvedkyc/"); ?>" class="nav-link <?php echo activate_menu("members/approvedkyc"); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Approved KYC</p>
                                        </a>
                                    </li>
                                    <?php }*/ ?>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview d-none <?= activate_dropdown('deposits'); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown('deposits','a'); ?>">
                                    <i class="nav-icon fas fa-money-bill"></i>
                                    <p>Money Transfer <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php if($this->session->role=='admin'){ ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url("deposits/requestlist/"); ?>" class="nav-link <?= activate_menu('deposits/requestlist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Deposit Request List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url("deposits/approvedlist/"); ?>" class="nav-link <?= activate_menu('deposits/approvedlist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Approved Deposit List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url("deposits/transferrequest/"); ?>" class="nav-link <?= activate_menu('deposits/transferrequest'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Transfer Request</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url("deposits/transferrequestlist/"); ?>" class="nav-link <?= activate_menu('deposits/transferrequestlist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Transfer Request List</p>
                                        </a>
                                    </li>
                                    <?php }else{ ?>
                                    <!-- <li class="nav-item">
                                        <a href="<?= base_url("deposits/"); ?>" class="nav-link <?= $this->uri->segment(1)!='activateaccount'?activate_menu('deposits'):''; ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Transfer Money</p>
                                        </a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a href="<?= base_url("deposits/depositlist/"); ?>" class="nav-link <?= activate_menu('deposits/depositlist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Deposit List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url("deposits/requestlist/"); ?>" class="nav-link <?= activate_menu('deposits/requestlist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Deposit Request List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url("deposits/approvedlist/"); ?>" class="nav-link <?= activate_menu('deposits/approvedlist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Approved Deposit List</p>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php if($this->session->role=='member'){  ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url('wallet/incomes/'); ?>" class="nav-link <?php echo activate_menu('wallet/incomes'); ?>">
                                    <i class="nav-icon fas fa-money-bill-alt"></i>
                                    <p>My Incomes</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview <?php echo activate_dropdown('wallet','li',array('incomes')); ?>">
                                <a href="#" class="nav-link <?php echo activate_dropdown('wallet','a',array('incomes')); ?>">
                                    <i class="nav-icon fas fa-wallet"></i>
                                    <p>Wallet <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url("wallet/"); ?>" class="nav-link <?php echo activate_menu("wallet"); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>My Wallet</p>
                                        </a>
                                    </li>
                                    <li class="nav-item hidden">
                                        <a href="<?php echo base_url("wallet/wallettransfer/"); ?>" class="nav-link <?php echo activate_menu("wallet/wallettransfer"); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Wallet Transfer</p>
                                        </a>
                                    </li>
                                    <li class="nav-item hidden">
                                        <a href="<?php echo base_url("wallet/walletreceived/"); ?>" class="nav-link <?php echo activate_menu("wallet/walletreceived"); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Wallet Received</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url("wallet/withdrawal/"); ?>" class="nav-link <?php echo activate_menu("wallet/withdrawal"); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Request Withdrawal</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                            }else{
                            ?>
                            <li class="nav-item d-none">
                                <a href="<?php echo base_url('wallet/wallettransfer/'); ?>" class="nav-link <?php echo activate_menu('wallet/wallettransfer'); ?>">
                                    <i class="nav-icon fas fa-money-bill-alt"></i>
                                    <p>Fund Transfer</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview d-none <?php echo activate_dropdown('wallet','li',array('wallettransfer')); ?>">
                                <a href="#" class="nav-link <?php echo activate_dropdown('wallet','a',array('wallettransfer')); ?>">
                                    <i class="nav-icon fas fa-wallet"></i>
                                    <p>Member Payment <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url("wallet/membercommission/"); ?>" class="nav-link <?php echo activate_menu('wallet/membercommission'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Member Commission</p>
                                        </a>
                                    </li>
                                    <li class="nav-item d-none">
                                        <a href="<?php echo base_url("wallet/memberrewards/"); ?>" class="nav-link <?php echo activate_menu('wallet/memberrewards'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Member Rewards</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url("wallet/requestlist/"); ?>" class="nav-link <?php echo activate_menu('wallet/requestlist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Withdrawal Request</p>
                                        </a>
                                    </li>
                                    <li class="nav-item d-none">
                                        <a href="<?php echo base_url("wallet/dailypaymentreport/"); ?>" class="nav-link <?php echo activate_menu('wallet/dailypaymentreport'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Daily Payment List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url("wallet/paymentreport/"); ?>" class="nav-link <?php echo activate_menu('wallet/paymentreport'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Payment Report</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
