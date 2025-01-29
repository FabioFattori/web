<?php

$username = "root";
$pass =  "";
$location= "localhost";
$db = "lotto";

$conn = new mysqli($location,$username,$pass,$db);

if($conn->connect_error){
    return json_encode("Errore di connessione");
}

if(isset($_POST["action"])&& ($_POST["action"] == "extract"|| $_POST["action"] == "new"||($_POST["action"]=="check" && isset($_POST["sequence"])))){
    if(isset($_POST["extract"])){
        $sql = "SELECT * from estrazione";
        $estrazioni = json_decode($conn->query($sql));
        if(count($estrazioni)>=5){
            return json_encode([
                "message"=>"ERRORE ho già 5 estrazioni",
            ]);
        }
        $nEstratto = random_int(1,90);
        $sql = "SELECT * from estrazione where numero = ".$nEstratto;
        $doppioni = count(json_decode($conn->query($sql)));
        if($doppioni != 0){
            return json_encode([
                "message" => "ERRORE ho estratto un numero già presente"
            ]);
            
        }
        
        $sql = "INSERT INTO estrazione (numero) VALUES (?)";

        $smt = $conn->prepare($sql);
        $smt->bind_param("i",$nEstratto);
        if ($stmt->execute()) {
            echo json_encode([
                "message" => "Dati inseriti con successo."
            ]);
        } else {
            echo json_encode([
                "message" => "Errore nell'inserimento: " . $stmt->error
            ]);
        }
        $stmt->close();
    }else if (isset($_POST["new"])){
        $sql = "DELETE * from estrazione";
        $conn->query($sql);
        echo json_encode([
            "message" => "Inizio Partita Avvenuto con successo"
        ]);
    }else{
        $values = explode("-",$_POST["sequence"]);
        $foundNumbers = [];
        foreach ($values as $key => $value) {
            if(in_array($value,$foundNumbers)){
                return json_encode([
                    "message" =>  "Numero doppio nella sequenza! Hai perso!"
                ]);
            }
            $sql = "SELECT * from estrazione where numero = ".$value;
            $res = count(json_decode($conn->query($sql)));
            if($res != 0){
                array_push($foundNumbers,$value);
            }
        }

        if(count($foundNumbers) != 5){
            echo json_encode([
                "message" => "sequenza incompleta! Hai perso!"
            ]);
        }else{
            echo json_encode([
                "message" => "Hai Vinto!"
            ]);
        }
    }
}
$conn->close();