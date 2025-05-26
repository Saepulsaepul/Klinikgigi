<div>
    <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
        <div class="card-header bg-gradient-primary py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white fw-semibold">
                <i class="fas fa-tooth me-2"></i> Dental Odontogram
            </h5>
            <div class="d-flex align-items-center">
                <span class="badge bg-white text-primary me-2">Pemeriksaan #{{ $pemeriksaanId }}</span>
                @if($showDetailPanel)
                <button wire:click="closeDetailPanel" class="btn btn-sm btn-light rounded-circle">
                    <i class="fas fa-times"></i>
                </button>
                @endif
            </div>
        </div>
        
        <div class="card-body p-4">
            <!-- Legend -->
            <div class="legend-container mb-4 p-3 bg-light rounded-3 shadow-sm">
                <h6 class="text-center mb-3 fw-bold text-uppercase small text-muted">Odontogram Gigi</h6>
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    @foreach([
                        ['condition' => 'sehat', 'label' => 'Sehat', 'symbol' => '✓'],
                        ['condition' => 'karies', 'label' => 'Karies', 'symbol' => '●'],
                        ['condition' => 'tambalan', 'label' => 'Tambalan', 'symbol' => '◑'],
                        ['condition' => 'hilang', 'label' => 'Hilang', 'symbol' => '✕'],
                        ['condition' => 'akar', 'label' => 'Sisa Akar', 'symbol' => '⌄'],
                        ['condition' => 'implants', 'label' => 'Implants', 'symbol' => 'ⓘ']
                    ] as $item)
                    <div class="legend-item {{ $item['condition'] }}">
                        <div class="legend-icon">
                            {{ $item['symbol'] }}
                        </div>
                        <span class="legend-label">{{ $item['label'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Rahang Atas -->
            <div class="jaw-section upper-jaw mb-4">
                <div class="jaw-label bg-light py-2 px-3 rounded-pill shadow-sm d-inline-block">
                    <i class="fas fa-chevron-up text-primary me-2"></i>
                    <span class="fw-medium">RAHANG ATAS</span>
                    <small class="text-muted ms-2">(Maxilla)</small>
                </div>
                
                <div class="teeth-grid mt-3">
                    @foreach(['18','17','16','15','14','13','12','11','21','22','23','24','25','26','27','28'] as $tooth)
                    <div class="tooth-wrapper" wire:key="upper-{{ $tooth }}">
                        <div class="tooth-container {{ $selectedTooth === $tooth ? 'tooth-selected' : '' }}"
                             wire:click="selectTooth('{{ $tooth }}')">
                            <div class="tooth-number">{{ $tooth }}</div>
                            <div class="tooth-visual tooth-{{ $toothConditions[$tooth]['kondisi'] ?? 'sehat' }}">
                                <div class="tooth-surface">
                                    <div class="tooth-symbol">
                                        {{ $getToothSymbol($toothConditions[$tooth]['kondisi'] ?? 'sehat') }}
                                    </div>
                                </div>
                                <div class="tooth-root"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Pemisah Rahang -->
            <div class="jaw-divider my-4">
                <div class="divider-line"></div>
                <div class="divider-label">
                    <i class="fas fa-teeth-open text-muted me-2"></i>
                    <span class="text-muted small">GARIS TENGAH MULUT</span>
                </div>
                <div class="divider-line"></div>
            </div>

            <!-- Rahang Bawah -->
            <div class="jaw-section lower-jaw mt-4">
                <div class="jaw-label bg-light py-2 px-3 rounded-pill shadow-sm d-inline-block">
                    <i class="fas fa-chevron-down text-primary me-2"></i>
                    <span class="fw-medium">RAHANG BAWAH</span>
                    <small class="text-muted ms-2">(Mandibula)</small>
                </div>
                
                <div class="teeth-grid mt-3">
                    @foreach(['48','47','46','45','44','43','42','41','31','32','33','34','35','36','37','38'] as $tooth)
                    <div class="tooth-wrapper" wire:key="lower-{{ $tooth }}">
                        <div class="tooth-container {{ $selectedTooth === $tooth ? 'tooth-selected' : '' }}"
                             wire:click="selectTooth('{{ $tooth }}')">
                            <div class="tooth-number">{{ $tooth }}</div>
                            <div class="tooth-visual tooth-{{ $toothConditions[$tooth]['kondisi'] ?? 'sehat' }}">
                                <div class="tooth-root"></div>
                                <div class="tooth-surface">
                                    <div class="tooth-symbol">
                                        {{ $getToothSymbol($toothConditions[$tooth]['kondisi'] ?? 'sehat') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Detail Panel -->
            @if($showDetailPanel && $selectedTooth)
            <div class="detail-panel mt-4 p-4 bg-white rounded-3 shadow-lg border border-primary">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-edit me-2"></i> Rekam Medis Gigi #{{ $selectedTooth }}
                    </h6>
                    <span class="badge condition-badge {{ $editingTooth['kondisi'] }}">
                        {{ ucfirst($editingTooth['kondisi']) }}
                    </span>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small text-uppercase fw-bold text-muted">Kondisi Gigi</label>
                        <select class="form-select form-select-sm border-2 py-2" wire:model="editingTooth.kondisi">
                            <option value="sehat">Sehat</option>
                            <option value="karies">Karies</option>
                            <option value="tambalan">Tambalan</option>
                            <option value="hilang">Hilang</option>
                            <option value="akar">Sisa Akar</option>
                            <option value="implants">Implants</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-uppercase fw-bold text-muted">Tindakan</label>
                        <input type="text" class="form-control form-control-sm border-2 py-2" 
                               wire:model="editingTooth.tindakan" placeholder="Deskripsi tindakan...">
                    </div>
                    <div class="col-12">
                        <label class="form-label small text-uppercase fw-bold text-muted">Catatan</label>
                        <textarea class="form-control border-2" rows="2" 
                                  wire:model="editingTooth.catatan" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                    <button wire:click="closeDetailPanel" class="btn btn-outline-secondary btn-sm px-3">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button wire:click="saveTooth" class="btn btn-primary btn-sm px-3">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>

    <style>
        /* Main Styles */
        .card {
            border: none;
            overflow: hidden;
        }
        
        .card-header {
            border-bottom: none;
        }
        
        /* Legend Styles */
        .legend-container {
            background: rgba(245, 245, 245, 0.8);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .legend-item {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin: 3px;
            transition: all 0.2s;
        }
        
        .legend-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        
        .legend-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 8px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .legend-label {
            font-size: 12px;
            font-weight: 600;
            color: #444;
        }
        
        /* Condition Colors */
        .legend-item.sehat .legend-icon { background: #e8f5e9; color: #2e7d32; }
        .legend-item.karies .legend-icon { background: #ffebee; color: #c62828; }
        .legend-item.tambalan .legend-icon { background: #fff8e1; color: #f57f17; }
        .legend-item.hilang .legend-icon { background: #f5f5f5; color: #616161; }
        .legend-item.akar .legend-icon { background: #efebe9; color: #5d4037; }
        .legend-item.implants .legend-icon { background: #e3f2fd; color: #1565c0; }
        
        /* Jaw Styles */
        .jaw-section {
            position: relative;
        }
        
        .jaw-label {
            font-size: 13px;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        /* Teeth Grid */
        .teeth-grid {
            display: grid;
            grid-template-columns: repeat(16, minmax(0, 1fr));
            gap: 8px;
            justify-content: center;
            max-width: 100%;
            overflow-x: auto;
            padding: 5px 0;
        }
        
        .tooth-wrapper {
            position: relative;
            z-index: 1;
        }
        
        .tooth-container {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .tooth-container:hover {
            transform: translateY(-3px);
        }
        
        .tooth-number {
            font-size: 10px;
            font-weight: 700;
            text-align: center;
            color: #555;
            margin-bottom: 3px;
        }
        
        /* Tooth Visual */
        .tooth-visual {
            width: 28px;
            height: 42px;
            position: relative;
            margin: 0 auto;
            transition: all 0.3s ease;
        }
        
        .tooth-surface {
            width: 100%;
            height: 70%;
            border-radius: 4px 4px 0 0;
            position: absolute;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(0,0,0,0.1);
            border-bottom: none;
        }
        
        .tooth-root {
            width: 60%;
            height: 30%;
            background: #f0e6d2;
            border-radius: 0 0 8px 8px;
            position: absolute;
            bottom: 0;
            left: 20%;
            border: 1px solid rgba(0,0,0,0.1);
            border-top: none;
        }
        
        .tooth-symbol {
            font-size: 14px;
            font-weight: bold;
            position: relative;
            z-index: 2;
        }
        
        /* Upper Jaw Specific */
        .upper-jaw .tooth-visual {
            transform: rotate(180deg);
        }
        
        /* Lower Jaw Specific */
        .lower-jaw .tooth-root {
            height: 25%;
        }
        
        .lower-jaw .tooth-surface {
            height: 75%;
            top: auto;
            bottom: 0;
            border-radius: 0 0 4px 4px;
            border-top: none;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        
        /* Tooth Conditions */
        .tooth-sehat .tooth-surface {
            background: #e8f5e9;
            border-color: #a5d6a7;
        }
        .tooth-sehat .tooth-symbol {
            color: #2e7d32;
        }
        
        .tooth-karies .tooth-surface {
            background: #ffebee;
            border-color: #ef9a9a;
        }
        .tooth-karies .tooth-symbol {
            color: #c62828;
        }
        
        .tooth-tambalan .tooth-surface {
            background: #fff8e1;
            border-color: #ffe082;
        }
        .tooth-tambalan .tooth-symbol {
            color: #f57f17;
        }
        
        .tooth-hilang .tooth-surface {
            background: repeating-linear-gradient(
                45deg,
                #f5f5f5,
                #f5f5f5 2px,
                #e0e0e0 2px,
                #e0e0e0 4px
            );
            border-color: #e0e0e0;
        }
        .tooth-hilang .tooth-symbol {
            color: #616161;
        }
        
        .tooth-akar .tooth-surface {
            background: #efebe9;
            border-color: #bcaaa4;
        }
        .tooth-akar .tooth-symbol {
            color: #5d4037;
        }
        
        .tooth-implants .tooth-surface {
            background: #e3f2fd;
            border-color: #90caf9;
        }
        .tooth-implants .tooth-symbol {
            color: #1565c0;
        }
        
        /* Selected Tooth */
        .tooth-selected .tooth-visual {
            transform: scale(1.1);
            filter: drop-shadow(0 0 6px rgba(33, 150, 243, 0.5));
        }
        
        .tooth-selected .tooth-number {
            color: #0d6efd;
            font-weight: 800;
        }
        
        /* Jaw Divider */
        .jaw-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #ddd, transparent);
        }
        
        .divider-label {
            padding: 0 12px;
            font-size: 11px;
            white-space: nowrap;
        }
        
        /* Detail Panel */
        .detail-panel {
            border-top: 3px solid #0d6efd;
            animation: fadeIn 0.3s ease;
        }
        
        .condition-badge {
            font-size: 11px;
            padding: 5px 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .condition-badge.sehat { background: #e8f5e9; color: #2e7d32; }
        .condition-badge.karies { background: #ffebee; color: #c62828; }
        .condition-badge.tambalan { background: #fff8e1; color: #f57f17; }
        .condition-badge.hilang { background: #f5f5f5; color: #616161; }
        .condition-badge.akar { background: #efebe9; color: #5d4037; }
        .condition-badge.implants { background: #e3f2fd; color: #1565c0; }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .teeth-grid {
                grid-template-columns: repeat(8, minmax(0, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .teeth-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 6px;
            }
            
            .tooth-visual {
                width: 24px;
                height: 36px;
            }
            
            .tooth-number {
                font-size: 9px;
            }
        }
        
        @media (max-width: 576px) {
            .legend-item {
                padding: 4px 8px;
                margin: 2px;
            }
            
            .legend-icon {
                width: 18px;
                height: 18px;
                font-size: 10px;
                margin-right: 6px;
            }
            
            .legend-label {
                font-size: 10px;
            }
        }
    </style>
</div>