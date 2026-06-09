import { Link } from 'react-router-dom';
import StatusBadge from './StatusBadge';

export default function PendaftarTable({ items, loading, isFetching = false }) {
  if (loading && !isFetching) {
    return <p className="text-center p-6">Memproses...</p>;
  }

  if (!isFetching && !items?.length) {
    return <p className="text-center p-6">Belum ada data pendaftar.</p>;
  }

  return (
    <table className="data-table">
      <thead>
        <tr>
          <th>No</th>
          <th>No. Registrasi</th>
          <th>Nama</th>
          <th>NISN</th>
          <th>Status</th>
          <th className="text-right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        {isFetching ? (
          <tr>
            <td colSpan="6" className="text-center p-6 text-secondary">
              <div style={{ display: 'inline-block', width: '2rem', height: '2rem', border: '3px solid #e2e8f0', borderTopColor: 'var(--color-primary)', borderRadius: '50%', animation: 'spin 1s linear infinite' }} />
              <p className="mt-2">Memuat data pendaftar...</p>
              <style>
                {`
                  @keyframes spin {
                    to { transform: rotate(360deg); }
                  }
                `}
              </style>
            </td>
          </tr>
        ) : (
          items.map((row, i) => (
            <tr key={row.id || row.id_pendaftaran}>
              <td>{i + 1}</td>
              <td>{row.no_registrasi || '-'}</td>
              <td>{row.nama_lengkap}</td>
              <td>{row.nisn || row.user?.username}</td>
              <td>
                <StatusBadge status={row.status || row.ppdb_status} />
              </td>
              <td className="text-right">
                <Link to={`/admin/ppdb/${row.id || row.id_pendaftaran}`} className="btn-secondary sm">
                  Detail
                </Link>
              </td>
            </tr>
          ))
        )}
      </tbody>
    </table>
  );
}
