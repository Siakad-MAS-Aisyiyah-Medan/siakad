import { PPDB_STATUS_LABELS } from '../services/ppdbApi';

const STATUS_CLASS = {
  draft: 'status-draft',
  diajukan: 'status-pending',
  revisi: 'status-warning',
  terverifikasi: 'status-info',
  diterima: 'status-success',
  ditolak: 'status-danger',
  daftar_ulang: 'status-info',
  menjadi_murid: 'status-success',
};

export default function StatusBadge({ status }) {
  const label = PPDB_STATUS_LABELS[status] || status;
  const cls = STATUS_CLASS[status] || 'status-default';

  return <span className={`ppdb-status-badge ${cls}`}>{label}</span>;
}
