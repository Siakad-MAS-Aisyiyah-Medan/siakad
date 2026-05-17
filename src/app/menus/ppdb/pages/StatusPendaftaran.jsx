import { Link } from 'react-router-dom';
import MainLayout from '@app/shared/layouts/MainLayout';
import StatusBadge from '../components/StatusBadge';
import { usePendaftaran } from '../hooks/usePendaftaran';
import { getJsonItem } from '@app/shared/utils/storage';

export default function StatusPendaftaran() {
  const p = usePendaftaran();
  const user = getJsonItem('user');

  return (
    <MainLayout role="calon_siswa" name={user?.username}>
      <div className="pendaftaran-container">
        <div className="panel-header glass">
          <h2>Status Pendaftaran</h2>
          <Link to="/calon-murid/dashboard">← Kembali</Link>
        </div>
        <div className="glass p-6">
          <p>
            <strong>Status:</strong> <StatusBadge status={p.status} />
          </p>
          {p.noRegistrasi && (
            <p className="mt-2">
              <strong>No. Registrasi:</strong> {p.noRegistrasi}
            </p>
          )}
          {p.catatanAdmin && (
            <p className="mt-2">
              <strong>Catatan Admin:</strong> {p.catatanAdmin}
            </p>
          )}
          {p.status === 'revisi' && (
            <Link to="/calon-murid/formulir" className="btn-primary mt-4">
              Perbaiki Formulir
            </Link>
          )}
        </div>
      </div>
    </MainLayout>
  );
}
