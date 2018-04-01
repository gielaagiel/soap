<html>
<head>
<title>Rest Web Services</title>
</head>
<body>
<a href="index.php">Lihat Buku</a>
<form method="POST" action="clientmhsw.php">
<table>
<tr>
<td>NIM</td>
<td><input type="text" name="nim" id="nim"></td>
</tr>
<tr>
<td>Nama</td>
<td><input type="text" name="nama" id="nama"></td>
</tr>
<tr>
<td>Progdi</td>
<td><input type="text" name="progdi" id="progdi"></td>
</tr>
<tr>
<tr>
<td><input type="submit" name="submit" id="submit" value="Tambah"></td>
<td></td>
</tr>
</table>
</form>
<?php
// Pull in the NuSOAP code
require_once('lib/nusoap.php');
// Create the client instance

$wsdl="http://localhost/webservice-master/webservice-master/servermhsw.php?wsdl";

$client =new nusoap_client($wsdl,true);
// Check for an error
$err = $client->getError();
if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    // At this point, you know the call that follows will fail
}
// Call the SOAP method
//$hasil = $client->call('ambilnama', array('nama' => 'nama'));
$hasil = $client->call('ambilnim', array('nim' => '12.5.00046'));
// Check for a fault
if ($client->fault) {
    echo '<h2>Fault</h2><pre>';
    print_r($hasil);
    echo '</pre>';
} else {
    // Check for errors
    $err = $client->getError();
    if ($err) {
        // Display the error
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    } else {
        // Display the result
        echo '<h2>Result</h2><pre>';
        print_r($hasil);
    echo '</pre>';
    }
}
// Display the request and response
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
// Display the debug messages
echo '<h2>Debug</h2>';
echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';

if (isset ($_POST['nim'])) {
    $url = 'http://localhost/webservice-master/webservice-master/restmhsw2.php';
    $data = "<mahasiswa>
    <nim>" . $_POST['nim'] . "</nim>
    <nama>" . $_POST['nama'] ."</nama>
    <progdi>" . $_POST['progdi'] . "</progdi>
    </mahasiswa>";
    //echo "datanya ".$data;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    echo "response ".$response;
    
    curl_close($ch);
    }
    ?>

