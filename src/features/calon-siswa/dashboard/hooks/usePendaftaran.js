import { useState, useEffect, useCallback } from 'react';
import Swal from 'sweetalert2';
import {
  fetchPendaftaran,
  savePendaftaranDraft,
  submitPendaftaran,
} from '../services/pendaftaran.service';

export const PPDB_STATUS_LABELS = {
  draft: 'Draft — lanjutkan pengisian',
  submitted: 'Diajukan — menunggu verifikasi',
  under_review: 'Sedang direview panitia',
  accepted: 'Diterima — menunggu promosi ke siswa',
  rejected: 'Ditolak — perbaiki data lalu kirim ulang',
  enrolled: 'Terdaftar sebagai siswa',
};

const READONLY_STATUSES = ['submitted', 'under_review', 'accepted', 'enrolled'];

const INITIAL_FORM = {
  nama_lengkap: '',
  tempat_lahir: '',
  tgl_lahir: '',
  agama: '',
  kewarganegaraan: 'Indonesia',
  anak_ke: 1,
  jml_saudara_kandung: 0,
  jml_saudara_tiri: 0,
  alamat: '',
  no_telp: '',
  status_yatim: 'Tidak',
  berat_badan: '',
  tinggi_badan: '',
  gol_darah: '',
  penyakit_diderita: '',
  cacat_badan: '',
  sekolah_asal: '',
  no_sttb: '',
  pindahan_dari: '',
  no_surat_pindah: '',
  nama_ayah: '',
  nama_ibu: '',
  pendidikan_ayah: '',
  pendidikan_ibu: '',
  pekerjaan_ayah: '',
  pekerjaan_ibu: '',
  agama_ortu: '',
  alamat_ortu: '',
  nama_wali: '',
  pendidikan_wali: '',
  pekerjaan_wali: '',
  agama_wali: '',
  alamat_wali: '',
  hobi: '',
  cita_cita: '',
};

const INITIAL_FILES = {
  file_ijazah: null,
  file_stk: null,
  file_pas_photo: null,
  file_nisn: null,
  file_kk: null,
  file_ktp_ortua: null,
};

const MAX_FILE_BYTES = 5 * 1024 * 1024;

export function usePendaftaran() {
  const [step, setStep] = useState(1);
  const [loading, setLoading] = useState(false);
  const [ppdbStatus, setPpdbStatus] = useState('draft');
  const [catatanAdmin, setCatatanAdmin] = useState('');
  const [formData, setFormData] = useState(INITIAL_FORM);
  const [files, setFiles] = useState(INITIAL_FILES);

  const isReadOnly = READONLY_STATUSES.includes(ppdbStatus);
  const canEdit = !isReadOnly;

  const loadData = useCallback(async () => {
    try {
      const data = await fetchPendaftaran();
      if (data) {
        const { files: _files, catatan_admin: _catatan, ...fields } = data;
        setFormData((prev) => ({ ...prev, ...fields }));
        setPpdbStatus(data.ppdb_status || 'draft');
        setCatatanAdmin('');
      }
    } catch {
      console.error('Failed to fetch pendaftaran data');
    }
  }, []);

  useEffect(() => {
    loadData();
  }, [loadData]);

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.id]: e.target.value });
  };

  const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (!file) return;

    if (file.type !== 'application/pdf') {
      Swal.fire({
        icon: 'error',
        title: 'Format Salah',
        text: 'Hanya file PDF yang diperbolehkan!',
      });
      e.target.value = null;
      return;
    }

    if (file.size > MAX_FILE_BYTES) {
      Swal.fire({
        icon: 'error',
        title: 'File Terlalu Besar',
        text: 'Ukuran maksimal per file adalah 5MB.',
      });
      e.target.value = null;
      return;
    }

    setFiles({ ...files, [e.target.id]: file });
  };

  const persistDraft = async (silent = false) => {
    try {
      const updated = await savePendaftaranDraft(formData, files);
      if (updated?.ppdb_status) {
        setPpdbStatus(updated.ppdb_status);
      }
      if (!silent) {
        Swal.fire({
          icon: 'success',
          title: 'Draft Disimpan',
          timer: 1200,
          showConfirmButton: false,
        });
      }
      return true;
    } catch (err) {
      if (!silent) {
        Swal.fire({
          icon: 'error',
          title: 'Gagal Menyimpan',
          text: err.response?.data?.message || 'Terjadi kesalahan saat menyimpan draft.',
        });
      }
      return false;
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      const saved = await persistDraft(true);
      if (!saved) return;

      const result = await submitPendaftaran();
      setPpdbStatus(result?.ppdb_status || 'submitted');
      Swal.fire({
        icon: 'success',
        title: 'Pendaftaran Berhasil Dikirim!',
        text: 'Data Anda sedang menunggu verifikasi panitia PPDB.',
        confirmButtonColor: '#198754',
      });
    } catch (err) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal Mengirim',
        text: err.response?.data?.message || 'Lengkapi semua data dan dokumen PDF sebelum submit.',
      });
    } finally {
      setLoading(false);
    }
  };

  const nextStep = async (e) => {
    e.preventDefault();
    if (canEdit) {
      setLoading(true);
      await persistDraft(true);
      setLoading(false);
    }
    setStep((s) => s + 1);
  };

  const prevStep = () => setStep((s) => s - 1);

  return {
    step,
    loading,
    ppdbStatus,
    catatanAdmin,
    isReadOnly,
    canEdit,
    statusLabel: PPDB_STATUS_LABELS[ppdbStatus] || ppdbStatus,
    formData,
    files,
    handleChange,
    handleFileChange,
    handleSubmit,
    nextStep,
    prevStep,
    persistDraft,
  };
}
