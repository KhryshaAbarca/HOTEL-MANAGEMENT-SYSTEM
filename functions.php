<?php
$connection = mysqli_connect("localhost", "root", "", "Hotel");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

function bookingdetails() {
    global $connection;
    $bookingdetails = 0;
    $query = "SELECT COUNT(*) AS guests FROM payment";
    $query_run = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($query_run)) {
        $bookingdetails = $row['bookingdetails'];                                                                  
    }
    return $bookingdetails;
}


function bookings() {
    global $connection;
    $bookings = 0;
    $query = "SELECT COUNT(*) AS bookings_count FROM bookings";
    $query_run = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($query_run)) {
        $bookings = $row['bookings'];
    }
    return $bookings;
}

function InsertRoomBooking() {
    global $connection;

    $procedureName = "InsertRoomBooking";
    $sql = "CALL $procedureName()";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        $error = mysqli_error($connection);
        return json_encode(["error" => $error]);
    }

    $roombook = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return json_encode(["roombook" => $roombook]);
}


function CheckRoomAvailability() {
    global $connection;

    $procedureName = "CheckRoomAvailability";
    $sql = "CALL $procedureName()";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        $error = mysqli_error($connection);
        return json_encode(["error" => $error]);
    }

    $room= mysqli_fetch_all($result, MYSQLI_ASSOC);
    return json_encode(["room" => $room]);
}



function UpdateReservationStatus() {
    global $connection;

    $procedureName = "UpdateReservationStatus";
    $sql = "CALL $procedureName()";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        $error = mysqli_error($connection);
        return json_encode(["error" => $error]);
    }

    $roombook = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return json_encode(["categories" => $roombook]);
}


function InsertUser($usname, $pass) {
    global $connection;

    $procedureName = "InsertUSer";
    $sql = "CALL $procedureName('$usname, $pass')";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        return ["error" => "Error: " . mysqli_error($connection)];
    }

    return ["success" => "User inserted successfully!"];
}



