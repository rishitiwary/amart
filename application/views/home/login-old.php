<?php $this->load->view('home/header');?>
<main id="content" class="page-main">
            

<div class="main-container container">
    <ul class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i></a></li>
        <li><a href="#">Account</a></li>
        <li><a href="#">Login</a></li>
    </ul>

    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="page-login">

                <div class="account-border">
                    <div class="row">
                        <div class="col-sm-6 new-customer">
                            <div class="well">
                                <h2><i class="fa fa-file-o" aria-hidden="true"></i> New Customer</h2>
                                <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
                            </div>
                            <div class="bottom-form">
                                <a href="<?php echo base_url();?>home/signup" class="btn btn-default pull-right">Register</a>
                            </div>
                        </div>

                        <div>
                            <div class="col-sm-6 customer-login">
        <form action="" method="post" id="AccountLoginForm">
        <div class="well">
        <h2><i class="fa fa-file-text-o" aria-hidden="true"></i> Customer Login</h2>
        <p><strong>
            <div class="alert " role="alert" id="errMsg" style="padding:10px;"></div>
        </strong></p>
        <div class="form-group">
            <label class="control-label " for="input-email">E-Mail Address</label>
            <input class="form-control" name="email" type="email" value="" required>
        </div>
        <div class="form-group">
            <label class="control-label " for="input-password">Password</label>
            <input class="form-control"  name="password" type="password" value="" required>
            <input class="form-control"  name="fcm_token" type="hidden" value="Q545345seerw4345e3e343eer45r454ee4r5" required>
        </div>
    </div>
    <div class="bottom-form">
        <a href="<?php echo base_url();?>home/forget" class="forgot">Forgotten Password</a>
        <input type="submit" value="Login" class="btn btn-default pull-right">
    </div>
</form>                   
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

        </main>
<?php $this->load->view('home/footer');?>