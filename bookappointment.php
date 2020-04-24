<?php

include_once('lib/header.php');
require_once('functions/alert.php');
?>

<section>
    <a href="patientDashBoard.php"> Back</a>

    <h3>Appointment Form</h3>
    <p>Kindly Fill all fields, they are required</p>
    <br>
    <?php

    print_alert();


    ?>

    <form action="processbookingappointment.php" method="post">
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
        <button type="submit">Book Appointment</button>
    </form>
</section>



<?php

include_once('lib/footer.php');

?>