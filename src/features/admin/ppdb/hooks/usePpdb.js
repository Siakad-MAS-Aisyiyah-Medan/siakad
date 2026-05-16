import { useState, useEffect, useCallback, useMemo } from 'react';
import Swal from 'sweetalert2';
import { fetchPpdbList, updatePpdbStatus } from '../services/ppdb.service';
import { confirmAction, toastSuccess, toastError } from '../../../../shared/hooks/useConfirm';

export const STATUS_LABELS = {
  draft: 'Draft',
  submitted: 'Diajukan',
  under_review: 'Direview',
  accepted: 'Diterima',
  rejected: 'Ditolak',
  enrolled: 'Terdaftar',
};

export function usePpdb() {
  const [items, setItems] = useState([]);
  const [loading, setLoading] = useState(false);
  const [statusFilter, setStatusFilter] = useState('');
  const [searchQuery, setSearchQuery] = useState('');

  const load = useCallback(async () => {
    setLoading(true);
    try {
      const data = await fetchPpdbList({
        status: statusFilter || undefined,
        search: searchQuery || undefined,
      });
      setItems(data);
    } catch (e) {
      console.error(e);
    } finally {
      setLoading(false);
    }
  }, [statusFilter, searchQuery]);

  useEffect(() => {
    load();
  }, [load]);

  const stats = useMemo(() => {
    const counts = { submitted: 0, accepted: 0, rejected: 0, under_review: 0, enrolled: 0 };
    items.forEach((p) => {
      if (counts[p.ppdb_status] !== undefined) counts[p.ppdb_status]++;
    });
    return counts;
  }, [items]);

  const promptCatatan = async (status) => {
    if (status === 'rejected') {
      const result = await Swal.fire({
        title: 'Catatan Penolakan',
        input: 'textarea',
        inputLabel: 'Alasan penolakan (wajib)',
        inputPlaceholder: 'Jelaskan alasan penolakan...',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#dc3545',
        inputValidator: (value) => {
          if (!value?.trim()) return 'Catatan wajib diisi saat menolak pendaftaran';
          return undefined;
        },
      });
      return result.isConfirmed ? result.value.trim() : null;
    }

    if (status === 'accepted') {
      const result = await Swal.fire({
        title: 'Terima Pendaftaran?',
        input: 'textarea',
        inputLabel: 'Catatan (opsional)',
        inputPlaceholder: 'Catatan untuk calon siswa...',
        showCancelButton: true,
        confirmButtonColor: '#198754',
      });
      return result.isConfirmed ? (result.value?.trim() || '') : null;
    }

    return '';
  };

  const changeStatus = async (id, status) => {
    const ok = await confirmAction({
      title: `Ubah status menjadi ${STATUS_LABELS[status]}?`,
      text: `Pendaftaran akan diperbarui ke status ${STATUS_LABELS[status]}.`,
      icon: 'question',
    });
    if (!ok) return;

    const catatan_admin = await promptCatatan(status);
    if (catatan_admin === null) return;

    try {
      await updatePpdbStatus(id, { status, catatan_admin });
      toastSuccess('Berhasil', 'Status PPDB diperbarui');
      load();
    } catch (err) {
      toastError('Gagal', err.response?.data?.message || 'Gagal memperbarui status');
    }
  };

  return {
    items,
    loading,
    stats,
    statusFilter,
    setStatusFilter,
    searchQuery,
    setSearchQuery,
    changeStatus,
    STATUS_LABELS,
    reload: load,
  };
}
