<html>
    <head>
        <title>Purchasing</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="assets/logo/logo.png" size="200x200" />
        <link rel="stylesheet" href="assets/vendor/sketchmaster/sketch.css">
        <!-- <link rel="stylesheet" href="assets/vendor/sketchmaster/loginplugins/bootstrap.min.css"> -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/vendor/fontawesome-free/css/all.min.css">
        <link href="assets/vendor/alertifyjs/css/alertify.css" rel="stylesheet">
        <link href="assets/vendor/alertifyjs/css/alertify.min.css" rel="stylesheet">
        <link href="assets/vendor/iziModal-master/css/iziModal.min.css" rel="stylesheet">
        <link href="assets/vendor/iziModal-master/css/iziModal.css" rel="stylesheet">

        <style type="text/css">
            html, body 
            {
                margin: auto;
                padding: 0;
                background-image: url("assets/vendor/sketchmaster/bg1.jpg");
                opacity : 0.99;
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
                font-family: sans-serif;
            }

            .iziModal 
            {
              border-radius : 50px !important;
              width: 600px !important;
            }

            #particles-js 
            {

                position: fixed;top: 0;left: 0;z-index: -1;width: 100%;height: 100%;
            }

            div#loginForm 
            {

                z-index: 99 !important; position: relative;
            }

            #loginForm 
            {
                top: 50%;
                left: 50%;
                width:30em;
                height:18em;
                margin-top: -9em; /*set to a negative number 1/2 of your height*/
                margin-left: -15em; /*set to a negative number 1/2 of your width*/
            }

            .panel
            {
                border: 0px;
                background: rgba(249,146,102,0.4);
                color: #fff;
                text-align: center;
                padding-top: 50px;
                border: 2px outset #65ccdb;
                border-radius: 50px 50px 0px 0px;
            }
            .panel:hover
            {

                    background: rgba(0,0,0,0.7);
            }

            .panel p
            {
                text-align: left;
                margin: 0;
                padding: 0;
                font-weight: bold;
                color: #fff;
            }
            .panel input
            {
                width: 100%;
                margin-bottom: 10px;

            }
            .panel input[type="text"], .panel input[type="password"]
            {
                border: none;
                border-bottom: 1px solid #fff;
                background: transparent;
                outline: none;
                height: 40px;
                color: #fff;
                font-size: 16px;
            }
            .panel button
            {
                border: none;
                outline: none;
                height: 40px;
                color: black;
                font-size: 16px;
                background: #65ccdb;
                cursor: pointer;
                border-radius: 20px;
                font-weight: bold;
                width: 50%;
            }
            ::placeholder
            {
                color: rgba(255,255,255,0.5);
            }
        </style>
    </head>

    <body>

        <div id="container">

            <div id="particles-js"></div>

        </div>
        
        <script src="assets/vendor/sketchmaster/sketch.js"></script>
        <script src="assets/vendor/sketchmaster/sketchjs.js"></script>
        <script src="assets/vendor/sketchmaster/loginplugins/jquery-2.2.3.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/alertifyjs/alertify.js" ></script>
        <script src="assets/vendor/alertifyjs/alertify.min.js" ></script>
        <script src="assets/vendor/sketchmaster/loginplugins/particles.js"></script>
        <script src="assets/vendor/sketchmaster/loginplugins/app.js"></script>
        <script src="assets/vendor/iziModal-master/js/iziModal.min.js"></script>
        <script type="text/javascript" src="assets/scripts/login/login.js"></script>

    </body>
</html>

<!-- LOGIN -->
<div id="modalLogin" data-iziModal-title="PURCHASING PORTAL" data-iziModal-icon="fas fa-lock" >
    <form method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="row">

        <div class="col-md-1"></div>
        <div class="col-md-10">
            <br/>
            <label for="">ID Number</label>
            <input type="text" class="form-control center-align" id="txtUsername" name="txtUsername" onkeyup="this.value = this.value.toUpperCase()" style="text-align: center;">
            <br/>
            <label for="">Password</label>
            <input type="password" class="form-control center-align" id="txtPassword" name="txtPassword" style="text-align: center;">
        </div>
        <div class="col-md-1"></div>

        <div class="col-md-12">
            <center>
                <br/>
                <button type="button" class="btn btn-outline-info" onclick='Login.loginCheck()'>PROCEED</button>
                <button type="button" class="btn btn-outline-info" onclick='Login.reset_password()'>RESET PASSWORD <span class="fa fa-arrow-right"></span></button>
            </center>
        </div>


    </div>
    </form>
</div>

<!-- REGISTRATION -->
<div id="modalRegister" data-iziModal-title="User Management" data-iziModal-icon="fas fa-user-circle" >
    <form method="post" id="modalFormRegister" enctype="multipart/form-data" autocomplete="off">
    <div class="row">

        <div class="col-md-6">
            <label for="">ID Number</label>
            <input type="text" class="form-control center-align" id="txtRegisterIdNumber" onkeyup="this.value = this.value.toUpperCase()">
        </div>

        <div class="col-md-6">
            <label for="">Fullname</label>
            <input type="text" class="form-control center-align" id="txtRegisterFullname" onkeyup="this.value = this.value.toUpperCase()">
            <br/>
        </div>

        <div class="col-md-6">
            <label for="">Password</label>
            <input type="password" class="form-control center-align" id="txtRegisterPassword" onkeyup="this.value = this.value.toUpperCase()">
        </div>
        
        <div class="col-md-6">
            <label for="">Section</label>
            <input type="text" class="form-control center-align" id="txtRegisterSection" onkeyup="this.value = this.value.toUpperCase()">
            <br/>
        </div>

        <div class="col-md-6">
            <label for="">Re-type Password</label>
            <input type="password" class="form-control center-align" id="txtRegisterReType" onkeyup="this.value = this.value.toUpperCase()">
        </div>
        
        <div class="col-md-6">
            <label for="">Position</label>
            <input type="text" class="form-control center-align" id="txtRegisterPosition" onkeyup="this.value = this.value.toUpperCase()">
            <br/>
        </div>

        <div class="col-md-12">
            <label for="">Email</label>
            <input type="text" class="form-control center-align" id="txtRegisterEmail" onkeyup="this.value = this.value.toUpperCase()">
        </div>

        <div class="col-md-6">
            <br/>
            <center>
                <button type="button" class="btn btn-success btn-lg" onclick='Login.registerRegistration();'>
                    <i class="fas fa-plus-circle"></i> Register
                </button>
            </center>
        </div>
        <div class="col-md-6">
            <br/>
            <center>
                <button type="button" class="btn btn-danger btn-lg" onclick='Login.registerClear();'>
                    <i class="fas fa-eraser"></i> Clear
                </button>
            </center>
        </div>

    </div>
    </form>
</div>

<!-- FORGOT PASSWORD -->
<div id="modalForgot" data-iziModal-title="Forgot Password" data-iziModal-icon="fas fa-user-circle" >
    <form method="post" id="modalFormForgot" enctype="multipart/form-data" autocomplete="off">
    <div class="row">

        <!-- ID -->
        <div class="col-md-1"></div>
        <div class="col-md-8">
            <label for="">ID Number</label>
            <input type="text" class="form-control center-align" id="txt_id" onkeyup="this.value = this.value.toUpperCase()">
        </div>

        <div class="col-md-3">
            <label for="">&nbsp;</label><br/>
            <button type="button" class="btn btn-outline-info" onclick='Login.verify_id()'>VERIFY</button>
            <br/>
        </div>

        <!-- PASSWORD -->
        <div class="col-md-1"></div>
        <div class="col-md-8">
            <label for="">Password</label>
            <input type="password" class="form-control center-align" id="txt_password">
        </div>

        <div class="col-md-3">
            <label for="">&nbsp;</label><br/>
            <br/>
        </div>  

        <!-- RETYPE -->
        <div class="col-md-1"></div>
        <div class="col-md-8">
            <label for="">Re-type Password</label>
            <input type="password" class="form-control center-align" id="txt_repassword">
        </div>

        <div class="col-md-3">
            <label for="">&nbsp;</label><br/>
            <br/>
        </div>

        <div class="col-md-12">
            <br/>
            <center>
                <button type="button" class="btn btn-danger btn-lg" id="btn_reset" onclick='Login.reset_now();'><i class="fas fa-paper-plane"></i> Reset
                </button>
            </center>
        </div>

    </div>
    </form>
</div>


