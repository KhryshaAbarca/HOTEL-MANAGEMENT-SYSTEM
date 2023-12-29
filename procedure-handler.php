<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['execute_'])) {
    $conn = establishConnection();

    if (isset($_POST['book_id'])) {
        $bookId = mysqli_real_escape_string($conn, $_POST['book_id']);

        // Call the BorrowBook stored procedure
        $result = executeBorrowBookProcedure($conn, $userId, $bookId);

        echo $result;
    } else {
        echo "Error: Book ID is missing!";
    }

    mysqli_close($conn);
}

function establishConnection()
{
    $conn = mysqli_connect("localhost", "root", "", "lms");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}


function executeBorrowBookProcedure($conn, $userId, $bookId)
{
    $result = '';

    // Ensure that $userId and $bookId are not NULL
    if ($userId !== null && $bookId !== null) {
        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($conn, "CALL BorrowBook(?, ?, @p_result)");
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $userId, $bookId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Get the result of the stored procedure
            $selectResult = mysqli_query($conn, "SELECT @p_result as result");
            
            if ($selectResult) {
                $row = mysqli_fetch_assoc($selectResult);

                if ($row) {
                    $result = $row['result'];
                } else {
                    $result = "Error: Failed to fetch result.";
                }
            } else {
                $result = "Error: " . mysqli_error($conn);
            }
        } else {
            $result = "Error: Failed to prepare statement.";
        }
    } else {
        $result = "Error: User ID or Book ID is missing!";
    }

    return $result;
}
?>