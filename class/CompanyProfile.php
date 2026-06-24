<?php
class CompanyProfile {
    public $namaPerusahaan = "Pavana";
    public $deskripsi = "Platform e-commerce B2C yang menyediakan solusi teknologi dan produk berkualitas tinggi secara langsung kepada pelanggan.";
    public $visi = "Menjadi platform e-commerce B2C terdepan yang mengutamakan kualitas, inovasi, dan kepuasan pelanggan.";
    public $misi = [
        "Menyediakan katalog produk yang lengkap dan berkualitas.",
        "Memberikan pengalaman belanja (UI/UX) yang responsif dan mudah digunakan.",
        "Menjamin transaksi yang aman dan pelayanan yang cepat."
    ];
    public $kontak = [
        "email" => "cs@tjeritakan.com",
        "telepon" => "+62 812 3456 7890",
        "alamat" => "Jl. Teknologi No. 5, Jakarta Timur",
        "whatsapp" => "6281234567890"
    ];

    public function getNamaPerusahaan() {
        return $this->namaPerusahaan;
    }
}
?>