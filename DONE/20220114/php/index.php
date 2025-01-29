<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_esami";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling POST request (Insert Data)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nome'], $_POST['cognome'], $_POST['codicefiscale'], $_POST['datanascita'], $_POST['sesso'])) {
        $nome = trim($_POST['nome']);
        $cognome = trim($_POST['cognome']);
        $codice_fiscale = trim($_POST['codicefiscale']);
        $data_nascita = trim($_POST['datanascita']);
        $sesso = trim($_POST['sesso']);

        // Validation
        if (!preg_match("/^[a-zA-Z]+$/", $nome) || !preg_match("/^[a-zA-Z]+$/", $cognome)) {
            echo "Nome e Cognome devono contenere solo lettere.";
        } elseif (!preg_match("/^[A-Z0-9]{16}$/", $codice_fiscale)) {
            echo "Codice fiscale non valido.";
        } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data_nascita)) {
            echo "Formato data di nascita non valido. Usare YYYY-MM-DD.";
        } elseif (!in_array($sesso, ['M', 'F', 'A'])) {
            echo "Sesso non valido.";
        } else {
            $stmt = $conn->prepare("INSERT INTO cittadino (nome, cognome, codicefiscale, datanascita, sesso) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nome, $cognome, $codice_fiscale, $data_nascita, $sesso);
            if ($stmt->execute()) {
                echo "Dati inseriti con successo.";
            } else {
                echo "Errore nell'inserimento: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        echo "Tutti i campi sono obbligatori.";
    }
}

// Handling GET request (Fetch Data)
$id_filter = "";
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $id_filter = "WHERE idcittadino = " . intval($id);
}

$sql = "SELECT * FROM cittadino $id_filter";
$result = $conn->query($sql);

// Display Data in HTML Table
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Nome</th><th>Cognome</th><th>Codice Fiscale</th><th>Data di Nascita</th><th>Sesso</th></tr>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['idcittadino']}</td><td>{$row['nome']}</td><td>{$row['cognome']}</td><td>{$row['codicefiscale']}</td><td>{$row['datanascita']}</td><td>{$row['sesso']}</td></tr>";
    }
} else {
    echo "<tr><td colspan='6'>Nessun dato trovato.</td></tr>";
}
echo "</table>";

$conn->close();
?>
