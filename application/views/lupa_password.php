<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>M Gym Fitness</title>

        <!-- Custom fonts for this template-->
        <link href="<?= base_url('assets/')?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

        <!-- Custom styles for this template-->
        <link href="<?= base_url('assets/')?>css/sb-admin-2.min.css" rel="stylesheet" />
		<link rel="shortcut icon" href="<?= base_url('assets/')?>img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?= base_url('assets/')?>img/favicon.ico" type="image/x-icon">
        <style>
.text1 {
  text-shadow: 0px 4px 3px rgba(0,0,0,0.4),
             0px 8px 13px rgba(0,0,0,0.1),
             0px 18px 23px rgba(0,0,0,0.1);
}

.text2 {
text-shadow: 0 1px 0 #ccc, 
               0 2px 0 #c9c9c9,
               0 3px 0 #bbb,
               0 4px 0 #b9b9b9,
               0 5px 0 #aaa,
               0 6px 1px rgba(0,0,0,.1),
               0 1px 3px rgba(0,0,0,.3),
               0 3px 5px rgba(0,0,0,.2),
               0 5px 10px rgba(0,0,0,.25),
               0 10px 10px rgba(0,0,0,.2),
               0 20px 20px rgba(0,0,0,.15);
               0 30px 20px rgba(0,0,0,.1);              
}

.text3 {
  text-shadow: 0px 3px 2px #ccc, 
               0px 8px 10px rgba(0,0,0,0.15), 
               0px 12px 2px rgba(0,0,0,0.7);
        
}

.text4 {
  text-shadow: 0px 4px 3px rgba(0,0,0,0.4),
             0px 8px 13px rgba(0,0,0,0.1),
             0px 18px 23px rgba(0,0,0,0.1);
}

.text5 {
 -webkit-text-stroke: 1px #F8F8F8;
  text-shadow: 0px 1px 4px #23430C;
  color: #4a7e4e;
}

.text6 {
     text-shadow: 0 13.36px 8.896px #2c482e, 0 -2px 1px #aeffb4;
    letter-spacing: -4px;
    color: #6fb374;
}
</style>
    </head>

    <body class="bg-gradient-primary">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg pb-3 pt-3 font-weight-bold">
            <div class="container">
                <a class="navbar-brand text-primary" style="font-weight: 900;" href="<?= base_url('')?>"> <i class="fa fa-database mr-2 rotate-n-15"></i>M GYM FITNESS</a>
            </div>
        </nav>

        <div class="container">
            <!-- Outer Row -->
            <div class="row d-plex justify-content-between mt-5">
                <div class="col-xl-6 col-lg-6 col-md-6 mt-5" style="background-image:url('<?php echo base_url()?>assets/img/bg.png');background-size:cover;">
                    <div class="card bg-none o-hidden border-0 my-5 text-white" style="background: none;">
                        <div class="text-justify card-body p-0">
                            <h4 style="font-weight: 800;" class="text1">M Gym Fitness</h4>
                            <!-- <p class="pt-4 text1">
                                M Gym Fitness yang berlokasi di Jalan Raya Babakan-Bogor Desa Kertayasa Kecamatan Kramat Kabupaten Tegal. Buka hari Senin-Sabtu di jam Pagi pukul 07.00-11.00 dan di jam Sore pukul 16.00-21.00. 
                            </p> -->
                            <!-- <p class="text1">
                                M Gym Fitness menyediakan alat latihan beban termasuk dumbel, barbel sebagai alat-alat latihan fisik yang sekitarnya dipasangi cermin untuk mengawasi dan menjaga postur tubuh yang benar ketika berolah raga. Terdapat banyak fasilitas termasuk Mushola untuk melakukan ibadah sholat bagi yang Muslim.
                            </p> -->
                        </div>
                    </div>
                </div>
				
				<div class="col-xl-5 col-lg-5 col-md-5 mt-5">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Lupa password</h1>
                                        </div>
										<?php 
										if($this->session->flashdata('error')) {?>
										<div class="alert alert-danger alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
										<?php echo $this->session->flashdata('error'); ?>                    
										</div>
										<?php }elseif($this->session->flashdata('message')){?>
                                            <div class="alert alert-success alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
										<?php echo $this->session->flashdata('message'); ?>                    
										</div>
                                        <?php }?>

                                        <form class="user" action="<?php echo site_url('Login/kirim_link'); ?>" method="post">
                                        <div class="form-group">
                                                <input required autocomplete="off" type="email" class="form-control form-control-user" id="exampleInputUser" placeholder="Email" name="email" />
                                            </div>
                                            <button name="submit" type="submit" class="btn btn-primary btn-user btn-block"><i class="fas fa-fw fa-sign-in-alt mr-1"></i> Kirim</button>
                                        </form>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href='<?php echo base_url()?>login'>Login</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="<?= base_url('assets/')?>vendor/jquery/jquery.min.js"></script>
        <script src="<?= base_url('assets/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="<?= base_url('assets/')?>vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="<?= base_url('assets/')?>js/sb-admin-2.min.js"></script>
    </body>
</html>


