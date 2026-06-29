<?php
class Transaksi extends Connection {
    private $idtransaksi = 0;
    private $tanggal = '';
    private $idUser = 0;
    private $idProduk = 0;
    public $hasil = false;
    public $message = '';

    public function __get($attribute){
        if(property_exists($this, $attribute)){
            return $this->$attribute;
        }
    }

    public function __set($attribute, $value){
        if(property_exists($this, $attribute)){
            return $this->$attribute = $value;
        }
    }

    public function AddTransaksi(){
        $sql = "INSERT INTO transaksi (tanggal, idUser, idProduk) VALUES ('$this->tanggal', '$this->idUser', '$this->idProduk')";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data transaksi berhasil ditambahkan";
        } else {
            $this->message = "Data transaksi gagal ditambahkan: " . mysqli_error($this->connection);
        }
    }

    public function UpdateTransaksi(){
        $sql = "UPDATE transaksi SET tanggal = '$this->tanggal', idUser = '$this->idUser', idProduk = '$this->idProduk' WHERE idtransaksi = '$this->idtransaksi'";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data transaksi berhasil diubah";
        } else {
            $this->message = "Data transaksi gagal diubah: " . mysqli_error($this->connection);
        }
    }

    public function DeleteTransaksi(){
        $sql = "DELETE FROM transaksi WHERE idtransaksi = '$this->idtransaksi'";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data transaksi berhasil dihapus";
        } else {
            $this->message = "Data transaksi gagal dihapus: " . mysqli_error($this->connection);
        }
    }

    public function SelectTransaksiByID(){
        $sql = "SELECT * FROM transaksi WHERE idtransaksi = '$this->idtransaksi'";
        $query = mysqli_query($this->connection, $sql);
        
        if($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $this->tanggal = $row['tanggal'];
            $this->idUser = $row['idUser'];
            $this->idProduk = $row['idProduk'];
            return $row;
        }
        return null;
    }

    // Tambahkan di dalam class Transaksi di class/class.Transaksi.php
    public function SelectAllTransaksi(){
        $sql = "SELECT t.*, p.namaProduk as nama_produk 
                FROM transaksi t 
                JOIN produk p ON t.idProduk = p.idProduk 
                ORDER BY t.tanggal DESC";
        $query = mysqli_query($this->connection, $sql);
        
        $data = [];
        while($row = mysqli_fetch_assoc($query)){
            $data[] = $row;
        }
        return $data;
    }
}
?>