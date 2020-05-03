<?php include_once('lib/header.php');
require_once('functions/alert.php');
require_once('functions/redirect.php');
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
                <form method="POST" action="processpayment.php">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="">Name</label>
                            <input type="text" name="name" value="name" class="form-control border-input" value="" placeholder="Enter your name" style="margin-bottom: 30px;">
                            <label for="">Email address</label>
                            <input type="text" name="email" value="email" class="form-control border-input" value="" placeholder="Enter email address" style="margin-bottom: 30px;">
                            <label for="">Email address</label>
                            <input type="number" name="amount" value="amount" class="form-control border-input" value="" placeholder="Enter the amount to be paid" style="margin-bottom: 30px;">
                        </div>
                    </div>

                    <button class="btn btn-primary" id="submit" type="button">Pay Now</button>
                    <div class="clearfix"></div>
            </div>
            </form>

    </div>
    </row>
</div>
</div>



<?php include_once('lib/footer.php')
?>