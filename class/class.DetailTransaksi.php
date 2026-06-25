<?php
class DetailTransaksi extends Connection {
    private $idTransaksi = 0;
    private $jumlahPesanan = 0;
    private $totalHarga = 0.0;
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

    public function AddDetailTransaksi(){
        $sql = "INSERT INTO detail_transaksi (idTransaksi, jumlahPesanan, totalHarga) VALUES ('$this->idTransaksi', '$this->jumlahPesanan', '$this->totalHarga')";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Detail transaksi berhasil ditambahkan";
        } else {
            $this->message = "Detail transaksi gagal ditambahkan: " . mysqli_error($this->connection);
        }
    }

    public function UpdateDetailTransaksi(){
        $sql = "UPDATE detail_transaksi SET jumlahPesanan = '$this->jumlahPesanan', totalHarga = '$this->totalHarga' WHERE idTransaksi = '$this->idTransaksi'";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Detail transaksi berhasil diubah";
        } else {
            $this->message = "Detail transaksi gagal diubah: " . mysqli_error($this->connection);
        }
    }

    public function DeleteDetailTransaksi(){
        $sql = "DELETE FROM detail_transaksi WHERE idTransaksi = '$this->idTransaksi'";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Detail transaksi berhasil dihapus";
        } else {
            $this->message = "Detail transaksi gagal dihapus: " . mysqli_error($this->connection);
        }
    }

    public function SelectDetailTransaksiByID(){
        $sql = "SELECT * FROM detail_transaksi WHERE idTransaksi = '$this->idTransaksi'";
        $query = mysqli_query($this->connection, $sql);
        
        if($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $this->jumlahPesanan = $row['jumlahPesanan'];
            $this->totalHarga = $row['totalHarga'];
            return $row;
        }
        return null;
    }
}
?>