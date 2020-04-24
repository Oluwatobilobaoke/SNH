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
