import apiClient from '@app/shared/services/apiClient';
import { unwrapData, unwrapPaginated } from '@app/shared/services/apiHelpers';

/** Public */
export async function fetchPpdbInfo() {
  const res = await apiClient.get('/ppdb/info');
  return unwrapData(res);
}

/** Calon murid */
export async function registerCalonMurid(payload) {
  const res = await apiClient.post('/ppdb/register', payload);
  return unwrapData(res);
}

export async function fetchPpdbMe() {
  const res = await apiClient.get('/ppdb/me');
  return unwrapData(res);
}

export async function saveFormulir(payload) {
  const res = await apiClient.post('/ppdb/formulir', payload);
  return unwrapData(res);
}

export async function uploadBerkas(jenisBerkas, file) {
  const form = new FormData();
  form.append('jenis_berkas', jenisBerkas);
  form.append('file', file);
  const res = await apiClient.post('/ppdb/berkas', form, {
    headers: { 'Content-Type': 'multipart/form-data' },
  });
  return unwrapData(res);
}

export async function submitPendaftaran() {
  const res = await apiClient.post('/ppdb/submit');
  return unwrapData(res);
}

export async function fetchPpdbStatus() {
  const res = await apiClient.get('/ppdb/status');
  return unwrapData(res);
}

export async function fetchBuktiPendaftaran() {
  const res = await apiClient.get('/ppdb/bukti');
  return unwrapData(res);
}

/** Admin */
export async function fetchAdminPendaftar(params = {}) {
  const res = await apiClient.get('/admin/ppdb', { params });
  const { items } = unwrapPaginated(res);
  return items;
}

export async function fetchAdminPendaftarDetail(id) {
  const res = await apiClient.get(`/admin/ppdb/${id}`);
  return unwrapData(res);
}

export async function adminVerifikasi(id) {
  const res = await apiClient.post(`/admin/ppdb/${id}/verifikasi`);
  return unwrapData(res);
}

export async function adminRevisi(id, catatan) {
  const res = await apiClient.post(`/admin/ppdb/${id}/revisi`, { catatan });
  return unwrapData(res);
}

export async function adminTerima(id) {
  const res = await apiClient.post(`/admin/ppdb/${id}/terima`);
  return unwrapData(res);
}

export async function adminTolak(id, catatan) {
  const res = await apiClient.post(`/admin/ppdb/${id}/tolak`, { catatan });
  return unwrapData(res);
}

export async function adminJadikanMurid(id, idKelas = null) {
  const res = await apiClient.post(`/admin/ppdb/${id}/jadikan-murid`, { id_kelas: idKelas });
  return unwrapData(res);
}

export const PPDB_STATUS_LABELS = {
  draft: 'Draft',
  diajukan: 'Diajukan',
  revisi: 'Revisi',
  terverifikasi: 'Terverifikasi',
  diterima: 'Diterima',
  ditolak: 'Ditolak',
  daftar_ulang: 'Daftar Ulang',
  menjadi_murid: 'Menjadi Murid',
};

export const BERKAS_LABELS = {
  kartu_keluarga: 'Kartu Keluarga',
  akta_kelahiran: 'Akta Kelahiran',
  ijazah_atau_skl: 'Ijazah / SKL',
  foto: 'Pas Foto',
  rapor: 'Rapor',
};
