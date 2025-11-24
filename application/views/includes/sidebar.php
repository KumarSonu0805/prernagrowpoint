
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
                            <li class="nav-item">
                                <a href="<?= base_url('home/'); ?>" class="nav-link <?= activate_menu('home'); ?>">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Home</p>
                                </a>
                            </li>
                            <?php if(false && $this->session->role=='admin'){ ?>
                            <li class="nav-item has-treeview <?= activate_dropdown('masterkey'); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown('masterkey','a'); ?>">
                                    <i class="nav-icon fas fa-key"></i>
                                    <p>Master Key <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('masterkey/'); ?>" class="nav-link <?= activate_menu('masterkey'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>State</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('masterkey/district/'); ?>" class="nav-link <?= activate_menu('masterkey/district'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>District</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('masterkey/area/'); ?>" class="nav-link <?= activate_menu('masterkey/area'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Area</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('masterkey/beat/'); ?>" class="nav-link <?= activate_menu('masterkey/beat'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Beat</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('masterkey/brand/'); ?>" class="nav-link <?= activate_menu('masterkey/brand'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Brand</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('masterkey/finance/'); ?>" class="nav-link <?= activate_menu('masterkey/finance'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Finance Company</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('masterkey/bank/'); ?>" class="nav-link <?= activate_menu('masterkey/bank'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Banks</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview <?= activate_dropdown('employees'); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown('employees','a'); ?>">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Employees<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('employees/'); ?>" class="nav-link <?= activate_menu('employees'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Employee</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('employees/employeelist/'); ?>" class="nav-link <?= activate_menu('employees/employeelist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Employee List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('employees/trackemployee/'); ?>" class="nav-link <?= activate_menu('employees/trackemployee'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Track Employee</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('employees/assignbeat/'); ?>" class="nav-link <?= activate_menu('employees/assignbeat'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Assign Beat</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('employees/assignedbeats/'); ?>" class="nav-link <?= activate_menu('employees/assignedbeats'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Assigned Beat</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview <?= activate_dropdown('dealers'); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown('dealers','a'); ?>">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Dealers<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('dealers/'); ?>" class="nav-link <?= activate_menu('dealers'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Dealer</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('dealers/dealerlist/'); ?>" class="nav-link <?= activate_menu('dealers/dealerlist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Dealer List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('dealers/dealermap/'); ?>" class="nav-link <?= activate_menu('dealers/dealermap'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Dealer Map</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview <?= activate_dropdown('expenses'); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown('expenses','a'); ?>">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Expenses<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('expenses/'); ?>" class="nav-link <?= activate_menu('expenses'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Expense</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('expenses/expenselist/'); ?>" class="nav-link <?= activate_menu('expenses/expenselist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Expense List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('expenses/expensehead/'); ?>" class="nav-link <?= activate_menu('expenses/expensehead'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Expense Heads</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview d-none <?= activate_dropdown('settings'); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown('settings','a'); ?>">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>Settings<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('settings/'); ?>" class="nav-link <?= activate_menu('settings'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>General</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item d-none <?= activate_dropdown('customize'); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown('customize','a'); ?>">
                                    <i class="nav-icon fas fa-wrench"></i>
                                    <p>
                                        Customize
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item d-none">
                                        <a href="<?= base_url('customize/'); ?>" class="nav-link <?= activate_menu('customize'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Banner Images</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php 
                                }
                                elseif(false && $this->session->role=='dso'){ 
                            ?>
                            <li class="nav-item has-treeview <?= activate_dropdown(['dealers']); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown(['dealers'],'a'); ?>">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Dealers<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('dealers/'); ?>" class="nav-link <?= activate_menu('dealers'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Dealer</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('dealers/dealerlist/'); ?>" class="nav-link <?= activate_menu('dealers/dealerlist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Dealer List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('dealers/dealermap/'); ?>" class="nav-link <?= activate_menu('dealers/dealermap'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Dealer Map</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview <?= activate_dropdown(['beats']); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown(['beats'],'a'); ?>">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Beats<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('beats/assignedbeats/'); ?>" class="nav-link <?= activate_menu('beats/assignedbeats'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Assigned Beats</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('beats/'); ?>" class="nav-link <?= activate_menu('beats'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Beat Wise Dealer List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('beats/beatmap/'); ?>" class="nav-link <?= activate_menu('beats/beatmap'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Beat Map</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview <?= activate_dropdown(['visitreport']); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown(['visitreport'],'a'); ?>">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>Dealer Visit Report<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('visitreport/'); ?>" class="nav-link <?= activate_menu('visitreport'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add DVR</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview <?= activate_dropdown('expenses'); ?>">
                                <a href="#" class="nav-link <?= activate_dropdown('expenses','a'); ?>">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Expenses<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('expenses/'); ?>" class="nav-link <?= activate_menu('expenses'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Expense</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('expenses/expenselist/'); ?>" class="nav-link <?= activate_menu('expenses/expenselist'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Expense List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('expenses/expensehead/'); ?>" class="nav-link <?= activate_menu('expenses/expensehead'); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Expense Heads</p>
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
