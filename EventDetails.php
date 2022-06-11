<?php
function randomString($n) {

  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;

}

function randomStartDate($now) {
  $date = $now->format('Y-m-d 00:00:00');
  $startTime = strtotime($date);
  $endTime = strtotime("tomorrow", $startTime) - 1;
  $epoch = rand($startTime, $endTime);
  $timestamp = date("Y-m-dTH:00:00", $epoch);
  return $timestamp;
}

function randomEndDate($start) {
  $minutes_to_add = rand(1,5);

  $time = new DateTime($start);
  $time->add(new DateInterval('PT' . $minutes_to_add . 'H'));

  $timestamp = $time->format('Y-m-dTH:i:s');
  return $timestamp;
}

$array = [];
$id = randomString(48);

function createEntry($date, $id) {

$startDate = randomStartDate($date);
$endDate = randomEndDate($startDate);
$locationNumber = rand(1,5);

$entry =   '{
    "ExternalId": "' . randomString(18) . '",
    "AccountName": "TriplePlay Testing",
    "AlternateAccountName": null,
    "AlternateBookingPostAs": null,
    "AlternateEventClassificationName": null,
    "AlternateFunctionRoomName": null,
    "BookingPostAs": "Meetings",
    "BookingTypeName": "Group",
    "EndDateTime": "' . $endDate . '",
    "EventClassificationName": "Event 1",
    "ExternalAccountId": "' . randomString(18) . '",
    "ExternalFunctionRoomId": "' . randomString(18) . '",
    "FunctionRoomName": "Location '. $locationNumber . '",
    "LocationName": "Main TriplePlay",
    "StartDateTime": "' . $startDate . '",
    "AgreedAttendance": null,
    "AlternateName": null,
    "Description": null,
    "EstimatedAttendance": null,
    "ForecastedAttendance": null,
    "GuaranteedAttendance": null,
    "IsPosted": true,
    "Name": "Event ' . rand(1,5) . '",
    "SetAttendance": null,
    "ExternalBookingId": "' . randomString(18) . '",
    "ExternalLocationId": "' . randomString(18) . '",
    "Id": "' . $id . '"
  }';


  return $entry;
}

if (!is_numeric($argv[1])) {
  echo("First Argument must be int\n");
  return;
}

$now = new DateTime();

for ($i = 0; $i < (int)$argv[1]; $i++) {
  $newEntry = createEntry($now, $id);
  array_push($array, $newEntry);
}

var_dump($array);

file_put_contents("EventDetails_" . $id . ".json", json_encode($array));

 ?>
