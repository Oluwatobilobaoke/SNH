<?php

include_once('lib/header.php');
require_once('functions/alert.php');
require_once('functions/redirect.php');
?>


<a class="btn btn-md btn-secondary" href="patientDashBoard.php" style="margin: 30px"> Back</a>
<div id="headings">
    <h3>Appointment Form</h3>
    <p>Kindly Fill all fields, they are required</p>
</div>
<div class="bod">
    <!-- <div class="containerform"> -->
    <?php

    print_alert();


    ?>

    <form action="processbookingappointment.php" method="post">

        <p>
            <label>Name</label><br>
            <textarea placeholder="Please enter name" name="name" cols="22" rows="2"><?php
                                                                                        if (isset($_SESSION['name']) && $_SESSION['name'] != '') {
                                                                                            echo $_SESSION['name'];
                                                                                        }
                                                                                        ?></textarea>

        </p>

        <p>
            <label>Nature of Your Appointment</label><br>

            <select name="nature">
                <option value="">Select one</option>
                <option <?php

                        if (isset($_SESSION['nature']) && $_SESSION['nature'] == 'New Appointment') {
                            echo "selected";
                        }

                        ?>>New Appointment</option>
                <option <?php

                        if (isset($_SESSION['nature']) && $_SESSION['nature'] == 'FollowUp Appointment') {
                            echo "selected";
                        }

                        ?>>FollowUp Appointment</option>
            </select>
        </p>
        <p>
            <label>Time of Appointment</label><br>
            <input value="<?php

                            if (isset($_SESSION['time']) && $_SESSION['time'] != '') {
                                echo $_SESSION['time'];
                            }

                            ?>" name="time" \ type="time">
        </p>
        <p>
            <label>Date of Appointment</label><br>
            <input value="<?php

                            if (isset($_SESSION['date']) && $_SESSION['date'] != '') {
                                echo $_SESSION['date'];
                            }

                            ?>" name="date" type="date">
        </p>

        <p>
            <label>Deparment</label><br>
            <select name="department">
                <option value="">Select one</option>
                <option <?php

                        if (isset($_SESSION['department']) && $_SESSION['department'] == 'HR') {
                            echo "selected";
                        }

                        ?>>HR</option>
                <option <?php

                        if (isset($_SESSION['department']) && $_SESSION['department'] == 'Laboratory') {
                            echo "selected";
                        }

                        ?>>Laboratory</option>
                <option <?php

                        if (isset($_SESSION['department']) && $_SESSION['department'] == 'IT') {
                            echo "selected";
                        }

                        ?>>IT</option>
                <option <?php

                        if (isset($_SESSION['department']) && $_SESSION['department'] == 'Finance') {
                            echo "selected";
                        }

                        ?>>Finance</option>
            </select>
        </p>
        <p>
            <label>Initial Complaint</label><br>
            <textarea placeholder="Please enter complaint" name="complaint" cols="26" rows="7"><?php
                                                                                                if (isset($_SESSION['complaint']) && $_SESSION['complaint'] != '') {
                                                                                                    echo $_SESSION['complaint'];
                                                                                                }
                                                                                                ?></textarea>

        </p>
        <button class="btn btn-md btn-dark" type="submit">Book Appointment</button>
    </form>
    <!-- </div> -->
</div>




<?php

include_once('lib/footer.php');

?>