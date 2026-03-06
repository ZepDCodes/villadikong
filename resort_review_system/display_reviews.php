<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "resort_db");

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, rating, feedback, created_at 
        FROM reviews 
        WHERE status = 'Approved' 
        ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="review-item">';
        echo '<div class="review-name">' . htmlspecialchars($row['name']) . '</div>';
        
        echo '<div class="review-rating">';
        for ($i = 1; $i <= 5; $i++) {
            echo ($i <= $row['rating']) ? '★' : '☆';
        }
        echo '</div>';
        
        echo '<div class="review-feedback">' . htmlspecialchars($row['feedback']) . '</div>';
        echo '<div class="review-date"><small>' . $row['created_at'] . '</small></div>';
        echo '</div>';
    }
} else {
    echo "<p>No approved reviews yet. Be the first to leave one!</p>";
}

$conn->close();
?>
