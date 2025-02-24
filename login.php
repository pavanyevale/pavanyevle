<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student";

// MySQL से कनेक्ट करें
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// फॉर्म डेटा प्राप्त करें
$user = trim($_POST['username']);
$pass = trim($_POST['password']);

// **Validation: खाली Username और Password Allow न करें**
if (empty($user) || empty($pass)) {
    die("❌ Username और Password खाली नहीं हो सकते!");
}

// **पासवर्ड को Hash करें**
$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

// **Prepared Statement का उपयोग करें (SQL Injection से बचने के लिए)**
$sql = $conn->prepare("INSERT INTO login (username, password) VALUES (?, ?)");
$sql->bind_param("ss", $user, $hashed_password);

if ($sql->execute()) {
    echo "✅ Registration successful! अब <a href='login.html'>Login करें</a>";
} else {
    echo "❌ Error: " . $sql->error;
}

$sql->close();
$conn->close();
?>
