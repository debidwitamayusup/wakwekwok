<?php

include('header.php');
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>
<?php
//including the database connection file
include_once("connection.php");

	$idKeranjang = $_SESSION['idUser'] . session_id();
	$sessionId = session_id();
	$idProduk = isset($_GET['idProduk']) ? $_GET['idProduk'] : '';
	$jumlah = isset($_GET['jumlah']) ? $_GET['jumlah'] : '';
	$idUser = $_SESSION['idUser'];
		
		$total = 0;
			 $p = isset($_GET['p']) ? $_GET['p'] : '';
    switch($p) 
    {
     default:
     	echo "<div class='container'>";
		  echo "<table id=\"keranjang\" cellpadding=\"10\" cellspacing=\"1\">
		<tr>
			<th>Nama</th>
			<th>Jumlah</th>
			<th>Harga</th>
			<th>Sub Total</th>
			<th>Aksi</th>
		</tr>";
		         $result = mysqli_query($mysqli, "SELECT * FROM keranjang,detailkeranjang,produk WHERE idUser ='".$idUser."' and idProduks='idProduk'");
                 while($dt = mysqli_fetch_array($result, MYSQLI_ASSOC)) {   
                 	$jumlah = $dt['jumlah'];
            
                        $subTotal = $jumlah * $dt['harga'];
						$total = $total + $subTotal;
						$namaProduk = $dt['namaProduk'];
		echo "<tr>
				<td>$namaProduk</td>
				<td>$dt[jumlah]</td>
				<td>$dt[harga]</td>
				<td>$subTotal</td>
				<td><a href=\"delete.php?idProduk=$dt[idProduks]\" onClick=\"return confirm('Anda yakin ingin menghapus?')\">Hapus</a></td>
			</tr>";
		}
              echo "</table>";
                echo "<h1>$total</h1>";
                echo "</div>";
                break;
     case "tambah" :
		//insert data to database	
		$result = mysqli_query($mysqli, "INSERT INTO keranjang(idKeranjang, idUser, idSession) VALUES('$idKeranjang', '$idUser', '$sessionId')");
			$result = mysqli_query($mysqli, "INSERT INTO detailkeranjang(idKeranjang, idProduks, jumlah) VALUES ('$idKeranjang','$idProduk', $jumlah)");
		echo "<div class='container'>";
		echo "<table>
		<th>
			<td>Nama</td>
			<td>Jumlah</td>
			<td>Harga</td>
			<td>Sub Total</td>
			<td>Aksi</td>
		</th>";
		/*case "lihat":
		         $result = mysqli_query($mysqli, "SELECT * FROM keranjang,detailkeranjang,produk WHERE idUser ='".$idUser"');
                 while($dt = mysqli_fetch_array($result, MYSQLI_ASSOC)) {   
                 	$jumlah = $dt['jumlah'];
            
                        $subTotal = $jumlah * $dt['harga'];
						$total = $total + $subTotal;
						$namaProduk = $dt['namaProduk'];
		echo "<tr>
				<td>$namaProduk</td>
				<td>$dt[jumlah]</td>
				<td>$dt[harga]</td>
				<td>$subTotal</td>
				<td><a href=\"delete.php?idProduk=$dt[idProduk]\" onClick=\"return confirm('Anda yakin ingin menghapus?')\">Hapus</a></td>
			</tr>";
                }
                echo "</table>";
                echo "<h1>$total</h1>";
                echo "</div>";*/
                break;
            }
?>
</body>