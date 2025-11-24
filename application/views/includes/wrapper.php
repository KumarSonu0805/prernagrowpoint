                <?php
                    if($page_type=='auth'){
                        !empty($content)?$this->load->view($content):'';
                    }
                    else{
                ?>
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="m-0"><?= $title ?></h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <?php
                                    if(!empty($breadcrumbs)){
                                    ?>
                                    <ol class="breadcrumb float-sm-right">
                                        <?php
                                        if(!isset($breadcrumb['active']) && $this->uri->segment(1)!=''){ $breadcrumb['active']=$title; }
                                        foreach($breadcrumb as $link=>$crumb){
                                            if($link=='active'){
                                                echo '<li class="breadcrumb-item active" aria-current="page">'.$crumb.'</li>';
                                            }
                                            else{
                                                echo '<li class="breadcrumb-item"><a href="'.base_url($link).'">'.$crumb.'</a></li>';
                                            }
                                        }	
                                        ?>
                                    </ol>
                                    <?php
                                    }
                                    ?>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </div>
                    <!-- /.content-header -->
                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <?php
                                    if(!empty($content_script)){
                                        foreach($content_script as $key=>$script){
                                            if($key=="link"){
                                                if(is_array($script)){
                                                    foreach($script as $single_script){
                                                        echo "<script src='$single_script'></script>\n\t";
                                                    }
                                                }
                                                else{
                                                    echo "<script src='$script'></script>\n\t";
                                                }
                                            }
                                            elseif($key=="file"){
                                                if(is_array($script)){
                                                    foreach($script as $single_script){
                                                        echo "<script src='".file_url("$single_script")."'></script>\n\t";
                                                    }
                                                }
                                                else{
                                                    echo "<script src='".file_url("$script")."'></script>\n\t";
                                                }
                                            }
                                        }
                                    }
                                ?>
                                <?php !empty($content)?$this->load->view($content):''; ?>
                            </div>
                        </div>
                    </div>      
                </div>
                <!-- /.content-wrapper -->
                <?php
                    }
                ?>