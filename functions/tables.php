<?php

function getAppointments($dept)
{
    $rows = '';
    $rowNum = 0;
    $all_Available_Appointments = scandir('db/appointments/');
    $num = count($all_Available_Appointments);
    for ($i = 2; $i < $num; $i++) {

        $appointment = json_decode(file_get_contents('db/appointments/' . $all_Available_Appointments[$i]));
        if ($appointment->department == $dept) {
            $rowNum++;
            $rows .= "
             <tr>
                <th scope='row'>$rowNum</th>
                <td>$appointment->patientName</td>
                <td>$appointment->nature</td>
                <td>$appointment->date</td>
                <td>$appointment->time</td>
                <td>$appointment->department</td>
                  <td>$appointment->complaint</td>
            </tr>
            ";
        }
    }
    if ($rows == '') {
        return false;
    }
    return $rows;
}

function getAllUsers()
{
    $staffRows = '';
    $staffRowNum = 0;
    $patientRows = "";
    $numofPatientRows = 0;
    $allusers = scandir('db/users/');
    $num = count($allusers);
    for ($i = 2; $i < $num; $i++) {
        $user_Derived_from_Db = json_decode(file_get_contents('db/users/' . $allusers[$i]));
        if ($user_Derived_from_Db->designation == "Medical Team (MT)") {
            $staffRowNum++;
            $staffRows .= "
             <tr>
                <th scope='row'>$staffRowNum</th>
                <td>$user_Derived_from_Db->first_name  $user_Derived_from_Db->last_name</td>
                 <td>$user_Derived_from_Db->gender</td>
                <td>$user_Derived_from_Db->designation</td>
                <td>$user_Derived_from_Db->department</td>
                <td>$user_Derived_from_Db->dateRegistered</td>
            </tr>
            ";
        } else if ($user_Derived_from_Db->designation == "Patient") {
            $numofPatientRows++;
            $patientRows .= "
             <tr>
                <th scope='row'>$numofPatientRows</th>
                <td>$user_Derived_from_Db->first_name  $user_Derived_from_Db->last_name</td>
                  <td>$user_Derived_from_Db->gender</td>
                <td>$user_Derived_from_Db->designation</td>
                <td>$user_Derived_from_Db->department</td>
                <td>$user_Derived_from_Db->dateRegistered</td>
            </tr>
            ";
        }
    }
    return ['staff' => $staffRows, 'patient' => $patientRows];
}
