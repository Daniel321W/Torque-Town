<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = $_POST['imie'];
    $model = $_POST['model'];
    $email = $_POST['email'];
    
    // Obsługa zdjęć
    $zdjecia = $_FILES['zdjecia'];
    $fileNames = [];
    
    for ($i = 0; $i < count($zdjecia['name']); $i++) {
        $targetDir = "uploads/";
        $fileName = basename($zdjecia['name'][$i]);
        $targetFile = $targetDir . $fileName;
        
        // Sprawdzamy, czy plik jest obrazem
        if (move_uploaded_file($zdjecia['tmp_name'][$i], $targetFile)) {
            $fileNames[] = $fileName;
        }
    }

    // Treść wiadomości e-mail
    $subject = "Zgłoszenie samochodu: $model";
    $message = "Imię i nazwisko: $imie\n";
    $message .= "Model samochodu: $model\n";
    $message .= "E-mail: $email\n\n";
    $message .= "Załączone zdjęcia:\n" . implode("\n", $fileNames);
    
    $to = "dkozak355@gmail.com"; // Adres, na który mają trafiać zgłoszenia
    $headers = "From: $email" . "\r\n" . "Reply-To: $email" . "\r\n" . "Content-Type: text/plain; charset=UTF-8";
    
    // Wysyłanie e-maila
    if (mail($to, $subject, $message, $headers)) {
        echo "Zgłoszenie zostało wysłane!";
    } else {
        echo "Wystąpił błąd podczas wysyłania zgłoszenia.";
    }
}
?>