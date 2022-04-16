<?php
require __DIR__ . '/vendor/autoload.php';
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

function getTicket($qrcode, $body, $lista){
    try{
        // Enter the share name for your USB printer here
        $connector = new WindowsPrintConnector("smb://192.168.140.15/TM-T20IIIL");
        $printer = new Printer($connector);

        $linea = "------------------------------------------------";
        $aFecha = date('d-M-y H:i:s');
        // $qrcode = "Julio Pineda,P123456,25m3";
        // $frase = "CONSTRU-SERVICES";

        // Demo that alignment is the same as text
        $printer -> feed();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> qrCode($qrcode, Printer::QR_ECLEVEL_M, 10);
        $printer -> feed();
        $printer -> text($body);
        $printer -> feed();
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text($lista);
        $printer -> feed();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text($aFecha);
        $printer -> feed();
        $printer -> feed();
        $printer -> feed();
        $printer -> text($linea);
        $printer -> feed();
        $printer -> feed();
        $printer -> cut();
        $printer -> close();
        echo "Successfuly Print";
    } catch (Exception $e) {
        echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }
}