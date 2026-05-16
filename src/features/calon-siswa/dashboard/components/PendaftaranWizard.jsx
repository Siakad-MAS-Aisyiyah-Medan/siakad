import {
  ClipboardList,
  User,
  Heart,
  GraduationCap,
  Users as ParentIcon,
  ShieldCheck,
  AlertCircle,
  Upload,
  XCircle,
} from 'lucide-react';

const UPLOAD_DOCS = [
  { id: 'file_ijazah', label: '1. Foto Copy Ijazah/SKHUN' },
  { id: 'file_stk', label: '2. STK Asli dan Foto Copy' },
  { id: 'file_pas_photo', label: '3. Pas Photo 3x4 (Jilbab) — PDF' },
  { id: 'file_nisn', label: '4. Fotokopi NISN' },
  { id: 'file_kk', label: '5. FC Kartu Keluarga' },
  { id: 'file_ktp_ortua', label: '6. FC KTP Orang Tua' },
];

export default function PendaftaranWizard({
  step,
  loading,
  ppdbStatus,
  catatanAdmin,
  isReadOnly,
  canEdit,
  statusLabel,
  formData,
  files,
  handleChange,
  handleFileChange,
  handleSubmit,
  nextStep,
  prevStep,
}) {
  const fieldProps = { onChange: handleChange, disabled: !canEdit };

  const renderStep = () => {
    switch (step) {
      case 1:
        return (
          <div className="form-section animate-fade-in">
            <h3 className="section-header">
              <User /> A. KETERANGAN PRIBADI
            </h3>
            <div className="form-grid">
              <div className="input-group full">
                <label htmlFor="nama_lengkap">1. Nama Lengkap</label>
                <input type="text" id="nama_lengkap" value={formData.nama_lengkap} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="tempat_lahir">2. Tempat Lahir</label>
                <input type="text" id="tempat_lahir" value={formData.tempat_lahir} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="tgl_lahir">3. Tanggal Lahir</label>
                <input type="date" id="tgl_lahir" value={formData.tgl_lahir} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="agama">4. Agama</label>
                <select id="agama" value={formData.agama} required {...fieldProps}>
                  <option value="">Pilih Agama</option>
                  <option value="Islam">Islam</option>
                  <option value="Kristen">Kristen</option>
                  <option value="Katolik">Katolik</option>
                  <option value="Hindu">Hindu</option>
                  <option value="Budha">Budha</option>
                  <option value="Khonghucu">Khonghucu</option>
                </select>
              </div>
              <div className="input-group">
                <label htmlFor="kewarganegaraan">5. Kewarganegaraan</label>
                <input type="text" id="kewarganegaraan" value={formData.kewarganegaraan} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="anak_ke">6. Anak Ke</label>
                <input type="number" id="anak_ke" value={formData.anak_ke} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="jml_saudara_kandung">7. Jumlah Saudara Kandung</label>
                <input type="number" id="jml_saudara_kandung" value={formData.jml_saudara_kandung} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="jml_saudara_tiri">8. Jumlah Saudara Tiri</label>
                <input type="number" id="jml_saudara_tiri" value={formData.jml_saudara_tiri} required {...fieldProps} />
              </div>
              <div className="input-group full">
                <label htmlFor="alamat">9. Alamat Lengkap</label>
                <textarea id="alamat" value={formData.alamat} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="no_telp">10. Nomor Telepon</label>
                <input type="text" id="no_telp" value={formData.no_telp} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="status_yatim">11. Yatim/Piatu/Yatim Piatu</label>
                <select id="status_yatim" value={formData.status_yatim} {...fieldProps}>
                  <option value="Tidak">Tidak</option>
                  <option value="Yatim">Yatim</option>
                  <option value="Piatu">Piatu</option>
                  <option value="Yatim Piatu">Yatim Piatu</option>
                </select>
              </div>
            </div>
          </div>
        );
      case 2:
        return (
          <div className="form-section animate-fade-in">
            <h3 className="section-header">
              <Heart /> B. KESEHATAN
            </h3>
            <div className="form-grid">
              <div className="input-group">
                <label htmlFor="berat_badan">1. Berat Badan (kg)</label>
                <input type="number" id="berat_badan" value={formData.berat_badan} {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="tinggi_badan">2. Tinggi Badan (cm)</label>
                <input type="number" id="tinggi_badan" value={formData.tinggi_badan} {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="gol_darah">3. Golongan Darah</label>
                <input type="text" id="gol_darah" value={formData.gol_darah} {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="penyakit_diderita">4. Penyakit yang pernah diderita</label>
                <input type="text" id="penyakit_diderita" value={formData.penyakit_diderita} {...fieldProps} />
              </div>
              <div className="input-group full">
                <label htmlFor="cacat_badan">5. Cacat Badan (jika ada)</label>
                <input type="text" id="cacat_badan" value={formData.cacat_badan} {...fieldProps} />
              </div>
            </div>
          </div>
        );
      case 3:
        return (
          <div className="form-section animate-fade-in">
            <h3 className="section-header">
              <GraduationCap /> C. PENDIDIKAN ASAL
            </h3>
            <div className="form-grid">
              <div className="input-group">
                <label htmlFor="sekolah_asal">1. Nama Sekolah Asal</label>
                <input type="text" id="sekolah_asal" value={formData.sekolah_asal} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="no_sttb">2. Nomor STTB / Ijazah</label>
                <input type="text" id="no_sttb" value={formData.no_sttb} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="pindahan_dari">3. Pindahan Dari (jika ada)</label>
                <input type="text" id="pindahan_dari" value={formData.pindahan_dari} {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="no_surat_pindah">4. Nomor Surat Pindah</label>
                <input type="text" id="no_surat_pindah" value={formData.no_surat_pindah} {...fieldProps} />
              </div>
            </div>
          </div>
        );
      case 4:
        return (
          <div className="form-section animate-fade-in">
            <h3 className="section-header">
              <ParentIcon /> D. KETERANGAN ORANG TUA / WALI
            </h3>
            <div className="form-grid-parent">
              <div className="grid-sub-parent">
                <h4>Ayah</h4>
                <input type="text" id="nama_ayah" placeholder="Nama Ayah" value={formData.nama_ayah} required {...fieldProps} />
                <input type="text" id="pendidikan_ayah" placeholder="Pendidikan" value={formData.pendidikan_ayah} required {...fieldProps} />
                <input type="text" id="pekerjaan_ayah" placeholder="Pekerjaan" value={formData.pekerjaan_ayah} required {...fieldProps} />
              </div>
              <div className="grid-sub-parent">
                <h4>Ibu</h4>
                <input type="text" id="nama_ibu" placeholder="Nama Ibu" value={formData.nama_ibu} required {...fieldProps} />
                <input type="text" id="pendidikan_ibu" placeholder="Pendidikan" value={formData.pendidikan_ibu} required {...fieldProps} />
                <input type="text" id="pekerjaan_ibu" placeholder="Pekerjaan" value={formData.pekerjaan_ibu} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="agama_ortu">Agama Orang Tua</label>
                <input type="text" id="agama_ortu" value={formData.agama_ortu} required {...fieldProps} />
              </div>
              <div className="input-group full">
                <label htmlFor="alamat_ortu">Alamat Orang Tua</label>
                <textarea id="alamat_ortu" value={formData.alamat_ortu} required {...fieldProps} />
              </div>
              <div className="parent-wali-sep full">WALI (Jika ada)</div>
              <div className="input-group">
                <label htmlFor="nama_wali">Nama Wali</label>
                <input type="text" id="nama_wali" value={formData.nama_wali} {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="pendidikan_wali">Pendidikan Wali</label>
                <input type="text" id="pendidikan_wali" value={formData.pendidikan_wali} {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="pekerjaan_wali">Pekerjaan Wali</label>
                <input type="text" id="pekerjaan_wali" value={formData.pekerjaan_wali} {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="agama_wali">Agama Wali</label>
                <input type="text" id="agama_wali" value={formData.agama_wali} {...fieldProps} />
              </div>
              <div className="input-group full">
                <label htmlFor="alamat_wali">Alamat Wali</label>
                <textarea id="alamat_wali" value={formData.alamat_wali} {...fieldProps} />
              </div>
            </div>
          </div>
        );
      case 5:
        return (
          <div className="form-section animate-fade-in">
            <h3 className="section-header">
              <ClipboardList /> E. KEPRIBADIAN
            </h3>
            <div className="form-grid">
              <div className="input-group">
                <label htmlFor="hobi">1. Hobi</label>
                <input type="text" id="hobi" value={formData.hobi} required {...fieldProps} />
              </div>
              <div className="input-group">
                <label htmlFor="cita_cita">2. Cita-cita</label>
                <input type="text" id="cita_cita" value={formData.cita_cita} required {...fieldProps} />
              </div>
            </div>
          </div>
        );
      case 6:
        return (
          <div className="form-section animate-fade-in">
            <h3 className="section-header">
              <Upload /> F. UPLOAD DOKUMEN (PDF Only, max 5MB)
            </h3>
            <div className="upload-grid">
              {UPLOAD_DOCS.map((item) => (
                <div key={item.id} className="upload-field glass">
                  <label htmlFor={item.id}>{item.label}</label>
                  <input
                    type="file"
                    id={item.id}
                    accept=".pdf,application/pdf"
                    onChange={handleFileChange}
                    disabled={!canEdit}
                    required={!formData[item.id] && !files[item.id]}
                  />
                  <div className="file-info">
                    {files[item.id] ? (
                      <span className="text-secondary">{files[item.id].name}</span>
                    ) : formData[item.id] ? (
                      <span className="text-secondary">Sudah diunggah</span>
                    ) : (
                      <span>Pilih File PDF</span>
                    )}
                  </div>
                </div>
              ))}
            </div>
            <div className="alert-info glass">
              <AlertCircle size={20} />
              Semua dokumen wajib PDF, maksimal 5MB per file.
            </div>
          </div>
        );
      default:
        return null;
    }
  };

  if (isReadOnly) {
    return (
      <div className="pendaftaran-container">
        <div className="status-banner glass animate-fade-in">
          <ShieldCheck size={64} className="text-secondary" />
          <div className="banner-text">
            <h2>Status Pendaftaran PPDB</h2>
            <p>
              Status: <span className="badge-pending">{statusLabel}</span>
            </p>
            <p className="subtext">
              {ppdbStatus === 'accepted'
                ? 'Selamat! Pendaftaran Anda diterima. Tunggu proses promosi menjadi siswa resmi.'
                : 'Formulir tidak dapat diubah pada status ini.'}
            </p>
            {catatanAdmin && (
              <p className="subtext" style={{ marginTop: '0.5rem' }}>
                <strong>Catatan panitia:</strong> {catatanAdmin}
              </p>
            )}
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="pendaftaran-container">
      {ppdbStatus === 'rejected' && (
        <div className="alert-info glass mb-4" style={{ display: 'flex', gap: '0.75rem', alignItems: 'flex-start' }}>
          <XCircle size={20} />
          <div>
            <strong>Pendaftaran ditolak.</strong> Perbaiki data sesuai catatan panitia lalu kirim ulang.
            {catatanAdmin && (
              <p style={{ marginTop: '0.25rem', fontSize: '0.875rem' }}>Catatan: {catatanAdmin}</p>
            )}
          </div>
        </div>
      )}

      <div className="form-card-wide glass">
        <div className="form-header">
          <h2>Formulir Pendaftaran</h2>
          <p className="text-secondary" style={{ fontSize: '0.875rem' }}>
            Status: {statusLabel}
          </p>
          <div className="step-indicator">
            {[1, 2, 3, 4, 5, 6].map((s) => (
              <span key={s} className={step >= s ? 'active' : ''}>
                {s}
              </span>
            ))}
          </div>
        </div>

        <form onSubmit={step === 6 ? handleSubmit : nextStep}>
          {renderStep()}
          <div className="form-footer">
            {step > 1 && (
              <button type="button" onClick={prevStep} className="btn-outline">
                Kembali
              </button>
            )}
            <button type="submit" className="btn-primary" disabled={loading}>
              {step === 6
                ? loading
                  ? 'Mengirim...'
                  : 'Kirim Pendaftaran'
                : loading
                  ? 'Menyimpan...'
                  : 'Lanjut & Simpan Draft'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
