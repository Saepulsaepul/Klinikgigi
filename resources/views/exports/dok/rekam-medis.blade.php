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
            margin-bottom: 10px;
        }

        .patient-info-column {
            flex: 1;
            padding-right: 15px;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px;
            main-height: 18px;
        }

        .info-label {
            font-weight: bold;
            width: 100px;
            color: #333;
            flex-shrink: 0;
        }

        .info-value {
            color: #000;
            flex-grow: 1;
            word-break: break-word;
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
        .badge-karies {
            background-color: #dc3545;
        }
        .badge-tambalan {
            background-color: #17a2b8;
        }
        .badge-hilang {
            background-color: #6c757d;
        }
        .badge-akar {
            background-color: #6f42c1;
        }
        .badge-implants {
            background-color: #fd7e14;
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
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top; padding-right: 10px;">
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
            </td>
            
            <td style="width: 80%; vertical-align: top; padding-left: 20px;">
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
            </td>
        </tr>
    </table>
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
    @if($isArray && !empty($pemeriksaan['kondisi_gigi']))
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
            @foreach($pemeriksaan['kondisi_gigi'] as $kondisi)
            <tr>
                <td>{{ $kondisi['nomor_gigi'] }}</td>
                <td>
                    @php
                        $badgeClass = match($kondisi['kondisi']) {
                            'sehat' => 'badge-sehat',
                            'karies' => 'badge-karies',
                            'tambalan' => 'badge-tambalan',
                            'hilang' => 'badge-hilang',
                            'akar' => 'badge-akar',
                            'implants' => 'badge-implants',
                            default => 'badge-sehat'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ ucfirst($kondisi['kondisi']) }}
                    </span>
                </td>
                <td>{{ $kondisi['tindakan'] ?? '-' }}</td>
                <td>{{ $kondisi['catatan'] ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p style="color:#777; font-style:italic; font-size:9px;">Tidak ada data kondisi gigi.</p>
    @endif

    <div class="section-title">ODONTOGRAM</div>
    <div style="width: 100%; margin-bottom: 5px; font-size: 7px;">
        <!-- Rahang Atas -->
        <div style="margin-bottom: 8px;">
            <div style="font-weight: bold; margin-bottom: 5px; font-size: 12px; text-align: center;">
                RAHANG ATAS (18-28)
            </div>
            <div style="text-align: center;">
                <div style="display: inline-block; white-space: nowrap;">
                    @php
                        $nomorGigiList = ['18','17','16','15','14','13','12','11','21','22','23','24','25','26','27','28'];
                    @endphp

                    @foreach($nomorGigiList as $gigi)
                        @php
                            $kondisi = $isArray ? 
                                (collect($pemeriksaan['kondisi_gigi'] ?? [])->firstWhere('nomor_gigi', $gigi)['kondisi'] ?? null) : 
                                ($pemeriksaan->kondisiGigi->firstWhere('nomor_gigi', $gigi)->kondisi ?? null);

                            $bgColor = match($kondisi) {
                                'sehat' => '#ffffff',
                                'karies' => '#ffcccc',
                                'tambalan' => '#ccffcc',
                                'hilang' => '#dddddd',
                                'akar' => '#e6ccff',
                                'implants' => '#ffd8b3',
                                default => '#ffffff'
                            };

                            $symbol = match($kondisi) {
                                'sehat' => '',
                                'karies' => '●',
                                'tambalan' => '■',
                                'hilang' => '✕',
                                'akar' => '▲',
                                'implants' => '◉',
                                default => ''
                            };
                        @endphp

                        <span style="display: inline-block; width: 24px; height: 30px; border: 1px solid #999; margin-right: -1px;
                            background-color: {{ $bgColor }};
                            position: relative; text-align: center; line-height: 30px; font-size: 10px; vertical-align: top;">
                            {{ $gigi }}
                            @if($symbol)
                                <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); 
                                    color: {{ $kondisi === 'sehat' ? 'transparent' : '#333' }};">
                                    {{ $symbol }}
                                </span>
                            @endif
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Rahang Bawah -->
        <div style="margin-bottom: 8px;">
            <div style="font-weight: bold; margin-bottom: 5px; font-size: 12px; text-align: center;">
                RAHANG BAWAH (38-48)
            </div>
            <div style="text-align: center;">
                <div style="display: inline-block; white-space: nowrap;">
                    @php
                        $nomorGigiList = ['48','47','46','45','44','43','42','41','31','32','33','34','35','36','37','38'];
                    @endphp

                    @foreach($nomorGigiList as $gigi)
                        @php
                            $kondisi = $isArray ? 
                                (collect($pemeriksaan['kondisi_gigi'] ?? [])->firstWhere('nomor_gigi', $gigi)['kondisi'] ?? null) : 
                                ($pemeriksaan->kondisiGigi->firstWhere('nomor_gigi', $gigi)->kondisi ?? null);

                            $bgColor = match($kondisi) {
                                'sehat' => '#ffffff',
                                'karies' => '#ffcccc',
                                'tambalan' => '#ccffcc',
                                'hilang' => '#dddddd',
                                'akar' => '#e6ccff',
                                'implants' => '#ffd8b3',
                                default => '#ffffff'
                            };

                            $symbol = match($kondisi) {
                                'sehat' => '',
                                'karies' => '●',
                                'tambalan' => '■',
                                'hilang' => '✕',
                                'akar' => '▲',
                                'implants' => '◉',
                                default => ''
                            };
                        @endphp

                        <span style="display: inline-block; width: 24px; height: 30px; border: 1px solid #999; margin-right: -1px;
                            background-color: {{ $bgColor }};
                            position: relative; text-align: center; line-height: 30px; font-size: 10px; vertical-align: top;">
                            {{ $gigi }}
                            @if($symbol)
                                <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); 
                                    color: {{ $kondisi === 'sehat' ? 'transparent' : '#333' }};">
                                    {{ $symbol }}
                                </span>
                            @endif
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Legenda -->
        <div style="font-size: 10px; margin-top: 10px; border-top: 1px dashed #ccc; padding-top: 5px; text-align: center;">
            <strong>LEGENDA:</strong> 
            <span style="display: inline-block; margin: 0 5px;">
                <span style="display: inline-block; width: 12px; height: 12px; background-color: #ffffff; border: 1px solid #999; vertical-align: middle;"></span> Sehat
            </span>
            <span style="display: inline-block; margin: 0 5px;">
                <span style="display: inline-block; width: 12px; height: 12px; background-color: #ffcccc; border: 1px solid #999; vertical-align: middle;"></span> Karies
            </span>
            <span style="display: inline-block; margin: 0 5px;">
                <span style="display: inline-block; width: 12px; height: 12px; background-color: #ccffcc; border: 1px solid #999; vertical-align: middle;"></span> Tambalan
            </span>
            <span style="display: inline-block; margin: 0 5px;">
                <span style="display: inline-block; width: 12px; height: 12px; background-color: #dddddd; border: 1px solid #999; vertical-align: middle;"></span> Hilang
            </span>
            <span style="display: inline-block; margin: 0 5px;">
                <span style="display: inline-block; width: 12px; height: 12px; background-color: #e6ccff; border: 1px solid #999; vertical-align: middle;"></span> Sisa Akar
            </span>
            <span style="display: inline-block; margin: 0 5px;">
                <span style="display: inline-block; width: 12px; height: 12px; background-color: #ffd8b3; border: 1px solid #999; vertical-align: middle;"></span> Implants
            </span>
        </div>
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