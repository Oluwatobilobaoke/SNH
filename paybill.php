<?php include_once('lib/header.php');
require_once('functions/alert.php');
?>

<a class="btn btn-md btn-secondary" href="patientDashBoard.php" style="margin: 30px"> Back</a>
<div id="headings">
    <h3>Pay Bills</h3>
    <p>You are required to make payments so you can see the doctor.</p>
</div>
<div class="bod">


    <div class="container" id="ravepay">
        <row>
            <div class="col-md-6 col-md-offset-4">
                <form>
                    <!-- <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script> -->
                    <div class="row">
                        <div class="col-md-8">
                            <label for="">First Name</label>
                            <input type="text" name="firstname" id="firstName" class="form-control border-input" placeholder="Enter your First name" style="margin-bottom: 30px;">
                            <label for="">Last Name</label>
                            <input type="text" name="lastname" id="lastName" class="form-control border-input" placeholder="Enter your Last name" style="margin-bottom: 30px;">
                            <label for="">Email address</label>
                            <input type="text" name="email" id="userEmail" value="<?php
                                                                                    if (isset($_SESSION['email']) && $_SESSION['email'] != '') {
                                                                                        echo $_SESSION['email'];
                                                                                    }
                                                                                    ?>" class="form-control border-input" placeholder="Enter email address" style="margin-bottom: 30px;">
                        </div>
                    </div>

                    <button class="btn btn-primary" style="cursor:pointer;" type="button" onClick="payWithRave()">Pay Now</button>
                    <div class="clearfix"></div>
            </div>
            </form>

    </div>
    </row>


    <!-- <script type="text/javascript" src="http://flw-pms-dev.eu-west-1.elasticbeanstalk.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script>
        const API_publicKey = "FLWPUBK_TEST-c4154efda0121d7f1e3a361e968fbcb0-X";
        // let clientEmail = document.querySelector('#userEmail').value;
        // let clientFirst_name = document.querySelector('#firstName').value;
        // let clientLast_name = document.querySelector('#lastName').value;
        // console.log(clientEmail + clientFirst_name + clientLast_name);
        // console.log(API_publicKey);


        function payWithRave() {
            var flw_ref = "",
                chargeResponse = "",
                trxref = "FDKHGK" + Math.random(),
                API_publicKey = "FLWPUBK_TEST-c4154efda0121d7f1e3a361e968fbcb0-X";
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: document.querySelector('#userEmail').value,
                customer_firstname: document.querySelector('#firstName').value,
                customer_lastname: document.querySelector('#lastName').value,
                amount: 1000,
                customer_phone: "09045773356",
                currency: "NGN",
                txref: "rave-12345678966hj",
                hosted_payment: 1,
                redirect_url: "http://localhost/myh/paybillverifiation.php",
                onclose: function(response) {
                    console.log(response);
                },
                callback: function(response) {
                    console.log(response);
                    txref = response.data.txref, chargeResponse = response.data.chargeResponseCode;
                    console.log(txref);
                    if (chargeResponse == "00" || chargeResponse == "0") {
                        window.location = "http://localhost/myh/billpaymentsuccessful.php?txref=" + txref; //Add your success page here
                    } else {
                        window.location = "http://localhost/myh/billpaymentfailed.php?txref=" + txref; //Add your failure page here
                    }

                }
            });
        }
    </script>";

</div>



<?php include_once('lib/footer.php')
?>