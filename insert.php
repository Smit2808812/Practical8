<?php
require_once "db.php";

$students = [
    ["Smit Prajapati", "smit@example.com", "Computer Science"],
    ["Aarav Shah", "aarav@example.com", "Information Technology"],
    ["Krisha Patel", "krisha@example.com", "Computer Science"]
];

$sql = "INSERT INTO students (name, email, course)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE
        name = VALUES(name),
        course = VALUES(course)";

$stmt = $pdo->prepare($sql);

foreach ($students as $student) {
    $stmt->execute($student);
}

echo "Student records saved successfully.";
?>
