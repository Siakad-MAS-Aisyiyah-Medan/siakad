import AdminPageShell from '../../../shared/components/AdminPageShell';
import { usePpdb } from './hooks/usePpdb';
import { Check, X, Eye } from 'lucide-react';

export default function PpdbPage() {
  const {
    items,
    loading,
    stats,
    statusFilter,
    setStatusFilter,
    searchQuery,
    setSearchQuery,
    changeStatus,
    STATUS_LABELS,
  } = usePpdb();

  return (
    <AdminPageShell>
      <div className="data-panel view-list">
        <div className="panel-header glass">
          <div className="header-text">
            <h2>Verifikasi PPDB</h2>
            <p>Kelola dan verifikasi pendaftaran calon siswa baru.</p>
          </div>
          <div className="header-actions" style={{ display: 'flex', gap: '0.5rem' }}>
            <input
              type="search"
              placeholder="Cari nama / NISN..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="search-input"
            />
            <select
              value={statusFilter}
              onChange={(e) => setStatusFilter(e.target.value)}
              className="search-input"
            >
              <option value="">Semua Status</option>
              {Object.entries(STATUS_LABELS).map(([k, v]) => (
                <option key={k} value={k}>
                  {v}
                </option>
              ))}
            </select>
          </div>
        </div>

        <div className="stats-grid" style={{ marginBottom: '1rem' }}>
          <div className="stat-card glass">
            <h3>Menunggu / Diajukan</h3>
            <p className="stat-value">{stats.submitted}</p>
          </div>
          <div className="stat-card glass">
            <h3>Diterima</h3>
            <p className="stat-value">{stats.accepted}</p>
          </div>
          <div className="stat-card glass">
            <h3>Ditolak</h3>
            <p className="stat-value">{stats.rejected}</p>
          </div>
        </div>

        <div className="table-container glass mt-6">
          <table className="data-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NISN</th>
                <th>Status</th>
                <th>Catatan</th>
                <th className="text-right">Aksi</th>
              </tr>
            </thead>
            <tbody>
              {loading ? (
                <tr>
                  <td colSpan="6" className="text-center p-6">
                    Memuat...
                  </td>
                </tr>
              ) : items.length === 0 ? (
                <tr>
                  <td colSpan="6" className="text-center p-6 text-secondary">
                    Belum ada pengajuan PPDB
                  </td>
                </tr>
              ) : (
                items.map((row, i) => (
                  <tr key={row.id_pendaftaran}>
                    <td>{i + 1}</td>
                    <td>{row.nama_lengkap}</td>
                    <td>{row.user?.username || '-'}</td>
                    <td>
                      <span className="badge badge-pending">
                        {STATUS_LABELS[row.ppdb_status] || row.ppdb_status}
                      </span>
                    </td>
                    <td className="text-secondary" style={{ fontSize: '0.85rem' }}>
                      {row.catatan_admin || '-'}
                    </td>
                    <td className="actions-cell">
                      {row.ppdb_status === 'submitted' && (
                        <button
                          type="button"
                          className="btn-icon"
                          title="Review"
                          onClick={() => changeStatus(row.id_pendaftaran, 'under_review')}
                        >
                          <Eye size={16} />
                        </button>
                      )}
                      {['submitted', 'under_review'].includes(row.ppdb_status) && (
                        <>
                          <button
                            type="button"
                            className="btn-icon"
                            title="Terima"
                            onClick={() => changeStatus(row.id_pendaftaran, 'accepted')}
                          >
                            <Check size={16} />
                          </button>
                          <button
                            type="button"
                            className="btn-icon delete"
                            title="Tolak"
                            onClick={() => changeStatus(row.id_pendaftaran, 'rejected')}
                          >
                            <X size={16} />
                          </button>
                        </>
                      )}
                    </td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
        </div>
        <p className="text-secondary" style={{ marginTop: '1rem', fontSize: '0.875rem' }}>
          Setelah status <strong>Diterima</strong>, promosikan calon siswa di menu Data Murid.
        </p>
      </div>
    </AdminPageShell>
  );
}


