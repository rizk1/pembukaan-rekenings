<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembukaan Rekening Disetujui</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .details {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
        }
        .details h2 {
            margin-top: 0;
            color: #495057;
        }
        .details ul {
            padding-left: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #6c757d;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Pembukaan Rekening Disetujui</h1>
    
    <p>Yth. {{ $pembukaanRekening->nama }},</p>
    
    <p>Dengan senang hati kami informasikan bahwa permohonan pembukaan rekening Anda telah disetujui. Selamat bergabung dengan layanan perbankan kami!</p>
    
    <div class="details">
        <h2>Detail Rekening:</h2>
        <ul>
            <li>Nama: {{ $pembukaanRekening->nama }}</li>
            <li>Tanggal Lahir: {{ \Carbon\Carbon::parse($pembukaanRekening->tanggal_lahir)->format('d F Y') }}</li>
            <li>Nominal Setor: Rp. {{ number_format($pembukaanRekening->nominal_setor, 2, ',', '.') }}</li>
        </ul>
    </div>
    
    <p>Langkah selanjutnya:</p>
    <ol>
        <li>Kunjungi cabang terdekat untuk mengaktifkan rekening Anda</li>
        <li>Bawa dokumen identitas asli untuk verifikasi</li>
        <li>Setorkan dana awal sesuai ketentuan yang berlaku</li>
    </ol>
    
    <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi layanan pelanggan kami di <a href="tel:1500351">1500 351</a> atau melalui email <a href="mailto:customercare@bankdki.co.id">customercare@bankdki.co.id</a>.</p>
    
    <p>Terima kasih telah memilih bank kami sebagai mitra keuangan Anda.</p>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} Bank DKI. Semua hak dilindungi undang-undang.</p>
    </div>
</body>
</html>
