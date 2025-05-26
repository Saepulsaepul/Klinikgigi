<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekam Medis Gigi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 10px;
            line-height: 1.3;
            color: #333;
            margin: 10px;
            background-color: #fff;
        }

        .header-container {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        .clinic-info {
            flex-grow: 1;
        }

        .clinic-name {
            font-size: 18px;
            font-weight: bold;
            color: #2980b9;
            margin-bottom: 3px;
        }

        .clinic-details {
            font-size: 10px;
            color: #555;
            line-height: 1.3;
        }

        .document-title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin: 10px 0;
            color: #2c3e50;
        }

        .patient-info-container {
            display: flex;
            margin-bottom: 10px;
        }

        .patient-info-column {
            flex: 1;
            padding-right: 15px;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            width: 90px;
            color: #333;
            flex-shrink: 0;
        }

        .info-value {
            color: #000;
            flex-grow: 1;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #2980b9;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
            margin: 12px 0 8px 0;
        }

        .examination-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 9px;
        }

        .examination-table th, 
        .examination-table td {
            border: 1px solid #ddd;
            padding: 5px 6px;
            text-align: left;
            vertical-align: top;
        }

        .examination-table th {
            background-color: #f5f9fc;
            font-weight: bold;
            color: #2980b9;
        }

        .badge {
            display: inline-block;
            padding: 2px 5px;
            font-size: 8px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
        }

        .badge-sehat {
            background-color: #28a745;
        }

        .badge-sakit {
            background-color: #dc3545;
        }

        .odontogram-box {
            border: 1px dashed #ccc;
            padding: 10px;
            text-align: center;
            color: #777;
            font-style: italic;
            background-color: #f9f9f9;
            margin-bottom: 12px;
            font-size: 9px;
        }

        .signature-area {
            margin-top: 25px;
            text-align: right;
            font-size: 9px;
        }

        .signature-line {
            width: 180px;
            border-top: 1px solid #000;
            margin-top: 30px;
            margin-bottom: 3px;
            display: inline-block;
        }

        .footer {
            font-size: 8px;
            text-align: right;
            margin-top: 15px;
            border-top: 1px solid #eee;
            padding-top: 3px;
            color: #777;
        }
    </style>
</head>
<body>
    @php
        function formatIndonesianDate($dateString) {
            if (!$dateString) return '-';
            $date = new DateTime($dateString);
            $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            return $days[$date->format('w')] . ', ' . $date->format('d') . ' ' . $months[$date->format('n')-1] . ' ' . $date->format('Y');
        }

        function calculateAge($birthDate) {
            if (!$birthDate) return null;
            $birth = new DateTime($birthDate);
            $today = new DateTime();
            return $today->diff($birth)->y;
        }

        $isArray = is_array($pemeriksaan);
        $logoPath = public_path('assets/compiled/jpg/GIGI.jpg');
        $logoExists = file_exists($logoPath);
    @endphp

    <div class="header-container">
        <div class="clinic-info">
            <div class="clinic-name">KLINIK GIGI FENDI DENTAL</div>
            <div class="clinic-details">
                Jl. Keroncong Permai Blok ABP 2, Jatiuwung, Tangerang, Banten 15134<br>
                Telp: 0812 1000 4605 | Email: FendiDental@gmail.com<br>
                Website: www.fendidental.com
            </div>
        </div>
    </div>

    <div class="document-title">REKAM MEDIS GIGI</div>

    <div class="patient-info-container">
        <div class="patient-info-column">
            <div class="info-row">
                <div class="info-label">No. Rekam Medis</div>
                <div class="info-value">
                    {{ $isArray ? $pemeriksaan['jadwal']['patient']['no_rm'] ?? 'RM-' . ($pemeriksaan['jadwal']['patient']['id'] ?? '') : $pemeriksaan->jadwal->patient->no_rm ?? 'RM-' . $pemeriksaan->jadwal->patient->id }}
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Nama Pasien</div>
                <div class="info-value">{{ $isArray ? $pemeriksaan['jadwal']['patient']['nama'] ?? '-' : $pemeriksaan->jadwal->patient->nama }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Tanggal Lahir</div>
                <div class="info-value">
                    {{ $isArray ? (isset($pemeriksaan['jadwal']['patient']['tanggal_lahir']) ? (new DateTime($pemeriksaan['jadwal']['patient']['tanggal_lahir']))->format('d/m/Y') : '-') : optional($pemeriksaan->jadwal->patient->tanggal_lahir)->format('d/m/Y') ?? '-' }}
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">No. Telepon</div>
                <div class="info-value">{{ $isArray ? $pemeriksaan['jadwal']['patient']['no_hp'] ?? '-' : $pemeriksaan->jadwal->patient->no_hp ?? '-' }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Alamat</div>
                <div class="info-value">
                    {{ $isArray ? $pemeriksaan['jadwal']['patient']['alamat'] ?? '-' : $pemeriksaan->jadwal->patient->alamat ?? '-' }}
                </div>
            </div>
        </div>
        
        <div class="patient-info-column">
            <div class="info-row">
                <div class="info-label">Tanggal Periksa</div>
                <div class="info-value">{{ $tanggal }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">No. KTP</div>
                <div class="info-value">{{ $isArray ? $pemeriksaan['jadwal']['patient']['no_ktp'] ?? '-' : $pemeriksaan->jadwal->patient->no_ktp ?? '-' }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Umur</div>
                <div class="info-value">
                    @php
                        $birthDate = $isArray ? 
                            ($pemeriksaan['jadwal']['patient']['tanggal_lahir'] ?? null) : 
                            optional($pemeriksaan->jadwal->patient->tanggal_lahir);
                        $age = calculateAge($birthDate);
                    @endphp
                    {{ $age ? $age.' tahun' : '-' }}
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $isArray ? $pemeriksaan['jadwal']['patient']['email'] ?? '-' : $pemeriksaan->jadwal->patient->email ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="section-title">DATA PEMERIKSAAN</div>
    <table class="examination-table">
        <tr>
            <th style="width:120px;">Dokter Penanggung Jawab</th>
            <td>drg. Ahmad Efendi, AMK, SPDI</td>
        </tr>
        <tr>
            <th>Keluhan Pasien</th>
            <td>{{ $isArray ? $pemeriksaan['keluhan_pasien'] ?? '-' : $pemeriksaan->keluhan_pasien ?? '-' }}</td>
        </tr>
        <tr>
            <th>Diagnosis</th>
            <td>{{ $isArray ? $pemeriksaan['diagnosis'] ?? '-' : $pemeriksaan->diagnosis ?? '-' }}</td>
        </tr>
        <tr>
            <th>Rencana Perawatan</th>
            <td>{{ $isArray ? $pemeriksaan['rencana_perawatan'] ?? '-' : $pemeriksaan->rencana_perawatan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Catatan Tambahan</th>
            <td>{{ $isArray ? $pemeriksaan['catatan_tambahan'] ?? '-' : $pemeriksaan->catatan_tambahan ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">KONDISI DAN TINDAKAN GIGI</div>
    @if(!$isArray && $pemeriksaan->kondisiGigi->isNotEmpty())
    <table class="examination-table">
        <thead>
            <tr>
                <th style="width:50px;">No. Gigi</th>
                <th style="width:70px;">Kondisi</th>
                <th>Tindakan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemeriksaan->kondisiGigi as $kondisi)
            <tr>
                <td>{{ $kondisi->nomor_gigi }}</td>
                <td>
                    <span class="badge {{ $kondisi->kondisi === 'sehat' ? 'badge-sehat' : 'badge-sakit' }}">
                        {{ ucfirst($kondisi->kondisi) }}
                    </span>
                </td>
                <td>{{ $kondisi->tindakan ?? '-' }}</td>
                <td>{{ $kondisi->catatan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p style="color:#777; font-style:italic; font-size:9px;">Tidak ada data kondisi gigi.</p>
    @endif

    <div class="section-title">ODONTOGRAM</div>
    
    <div class="odontogram-box">
        Diagram odontogram pasien belum tersedia.
    </div>

    <div class="signature-area">
        <p>Tangerang, {{ date('d F Y') }}</p>
        <div class="signature-line"></div>
        <p><strong>{{ $isArray ? ($pemeriksaan['jadwal']['dokter']['name'] ?? 'drg. Ahmad Efendi, AMK, SPDI') : ($pemeriksaan->jadwal->dokter->name ?? 'drg. Ahmad Efendi, AMK, SPDI') }}</strong></p>
        <p>SIP: {{ $isArray ? ($pemeriksaan['jadwal']['dokter']['sip_number'] ?? '12345/SIP/DGI/2023') : ($pemeriksaan->jadwal->dokter->sip_number ?? '12345/SIP/DGI/2023') }}</p>
    </div>

    <div class="footer">
        Dicetak secara elektronik pada: {{ formatIndonesianDate(now()->format('Y-m-d H:i:s')) }}<br>
        Klinik Gigi Fendi Dental - Sistem Informasi Rekam Medis Elektronik
    </div>
</body>
</html>