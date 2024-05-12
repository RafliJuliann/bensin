    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

        $jenis = $_POST['jenis'];
        $jumlah = $_POST['jumlah'];

        $pembelian = new Beli($jenis, $jumlah);
        $transaksi = $pembelian->buktiTransaksi();

        echo "<h2>----------------------------------------</h2>";
        echo "<h3>Bukti Transaksi</h3>";
        echo "Anda membeli bahan bakar jenis tipe  " . $transaksi['jenis'] . "<br>";
        echo "Harga per Liter: Rp " . number_format($transaksi['harga_per_liter'], 2, ',', '.') . "<br>";
        echo "dengan Jumlah: " . $transaksi['jumlah'] . " liter<br>";
        echo "Total yang harus anda bayar: Rp " . number_format($transaksi['total_bayar'], 2, ',', '.') . "<br>";
        echo "<h2>----------------------------------------</h2>";
    }
    ?>
</body>
</html>

<style>
    body { 
        background-image: url(bensin.jpeg);
        background-repeat: no-repeat;
        background-size: cover;
        background-color: #f5f5f5;
        font-family: Arial, sans-serif;
        text-align: center;
        align-items: center;
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
        width: 80%;
        max-width: 600px;
    }

    h2, h3 {
        color: #333;
        text-align: center;
    }

    form {
        margin-top: 20px;
        align-items: center;
    }

    label {
        display: block;
        font-weight: bold;
        margin-top: 10px;
    }

    input[type="number"] {
        width: 250PX;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    select {
        width: 250PX;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input[type="submit"] {
        background-color: #4caf50;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 3px;
        cursor: pointer;
        margin-top: 10px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<?php
class Shell {
    protected $harga;
    protected $jenis;
    protected $ppn = 0.1;  

    public function __construct($jenis) {
        $this->jenis = $jenis;
        $this->setHarga();
    }

    protected function setHarga() {
        switch ($this->jenis) {
            case 'Super':
                $this->harga = 15420;
                break;
            case 'V-Power':
                $this->harga = 16130;
                break;
            case 'V-Power Diesel':
                $this->harga = 18310;
                break;
            case 'V-Power Nitro':
                $this->harga = 16510;
                break;
            default:
                $this->harga = 0; 
        }
    }

    public function getHarga() {
        return $this->harga;
    }

    public function hitungPPN($jumlah) {
        return $jumlah * $this->harga * $this->ppn;
    }
}

class Beli extends Shell {
    private $jumlah;

    public function __construct($jenis, $jumlah) {
        parent::__construct($jenis);
        $this->jumlah = $jumlah;
    }

    public function hitungTotal() {
        $subtotal = $this->jumlah * $this->getHarga();
        $ppn = $this->hitungPPN($this->jumlah);
        return $subtotal + $ppn;
    }

    public function buktiTransaksi() {
        return [
            'jenis' => $this->jenis,
            'harga_per_liter' => $this->getHarga(),
            'jumlah' => $this->jumlah,
            'total_bayar' => $this->hitungTotal()
        ];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Bahan Bakar</title>
</head>
<body>
      
    <form action="index.php" method="post">
    <label for="jumlah">Masukkan Jumlah Liter : </label>
        <input type="number" name="jumlah" id="jumlah" required placeholder="Masukan disini">
        <br>
        <label for="jenis">Pilih Tipe Bahan Bakar : </label>
        <select name="jenis" id="jenis">
            <option value="Super">Shell Super</option>
            <option value="V-Power">Shell V-Power</option>
            <option value="V-Power Diesel">Shell V-Power Diesel</option>
            <option value="V-Power Nitro">Shell V-Power Nitro</option> 
        </select>
        <br>
            <input type="submit" name="submit" value="Hitung">
    </form>

