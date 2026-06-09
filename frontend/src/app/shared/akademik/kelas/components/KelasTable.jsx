import { Search, Plus, Edit2, Trash2 } from 'lucide-react';

export default function KelasTable({
  filteredData,
  searchQuery,
  onSearchChange,
  onAdd,
  onEdit,
  onDelete,
  isFetching = false,
}) {
  return (
    <div className="data-panel view-list">
      <div className="panel-header glass">
        <div className="header-text">
          <h2>Data Kelas</h2>
          <p>Kelola pembagian kelas dan penetapan wali kelas.</p>
        </div>
        <div className="header-actions">
          <div className="search-box">
            <Search size={18} />
            <input
              type="text"
              placeholder="Cari kelas..."
              value={searchQuery}
              onChange={(e) => onSearchChange(e.target.value)}
            />
          </div>
          <button type="button" onClick={onAdd} className="btn-primary">
            <Plus size={18} /> Tambah Kelas
          </button>
        </div>
      </div>

      <div className="table-container glass mt-6">
        <table className="data-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Kelas</th>
              <th>Wali Kelas</th>
              <th>Jumlah Siswa</th>
              <th className="text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            {isFetching ? (
              <tr>
                <td colSpan="5" className="text-center p-6 text-secondary">
                  <div style={{ display: 'inline-block', width: '2rem', height: '2rem', border: '3px solid #e2e8f0', borderTopColor: 'var(--color-primary)', borderRadius: '50%', animation: 'spin 1s linear infinite' }} />
                  <p className="mt-2">Memuat data kelas...</p>
                  <style>
                    {`
                      @keyframes spin {
                        to { transform: rotate(360deg); }
                      }
                    `}
                  </style>
                </td>
              </tr>
            ) : filteredData.length > 0 ? (
              filteredData.map((kelas, index) => (
                <tr key={kelas.id_kelas}>
                  <td>{index + 1}</td>
                  <td>
                    <strong>{kelas.nama_kelas}</strong>
                  </td>
                  <td>{kelas.wali_kelas?.guru?.nama_guru || '-'}</td>
                  <td>{kelas.jumlah_siswa} Siswa</td>
                  <td className="actions-cell">
                    <button type="button" onClick={() => onEdit(kelas)} className="btn-icon edit" title="Edit Data">
                      <Edit2 size={16} />
                    </button>
                    <button type="button" onClick={() => onDelete(kelas.id_kelas)} className="btn-icon delete" title="Hapus Data">
                      <Trash2 size={16} />
                    </button>
                  </td>
                </tr>
              ))
            ) : (
              <tr>
                <td colSpan="5" className="text-center p-6 text-secondary">
                  <FolderSearch size={48} className="mx-auto mb-2 opacity-50" />
                  Data kelas tidak ditemukan.
                </td>
              </tr>
            )}
          </tbody>
        </table>
      </div>
    </div>
  );
}
