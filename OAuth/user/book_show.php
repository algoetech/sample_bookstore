<?php include('../../lib/db.php'); ?>

<?php

session_start();

// useCodeFrom('lib/db.php');

secure();
header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $bookId = $_POST['id'];

    // Fetch book path from database
    $query = "SELECT file FROM books WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
       

        $row = $result->fetch_assoc();
        $response = ['book_path' => $row['file']];
        echo json_encode($response,JSON_FORCE_OBJECT);
    } else {
        echo json_encode(['error' => 'Book not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request', 'extra' => 'Expect header content-type json request type, text/html is given.']);
}

?>