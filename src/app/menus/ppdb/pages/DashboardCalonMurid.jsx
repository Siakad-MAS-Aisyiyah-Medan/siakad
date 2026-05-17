import { Link } from 'react-router-dom';
import MainLayout from '@app/shared/layouts/MainLayout';
import PendaftaranStepper from '../components/PendaftaranStepper';
import StatusBadge from '../components/StatusBadge';
import { usePendaftaran } from '../hooks/usePendaftaran';
import { getJsonItem } from '@app/shared/utils/storage';
import { getDisplayName } from '@app/shared/utils/profile';

export default function DashboardCalonMurid() {
  const { status, statusLabel, noRegistrasi, catatanAdmin, loading } = usePendaftaran();
  const user = getJsonItem('user');
  const profile = getJsonItem('profile');
  const name = getDisplayName(profile, 'calon_siswa', user?.username);

  const step =
    status === 'draft' || status === 'revisi' ? 0 : status === 'diajukan' ? 3 : 2;

  return (
    <MainLayout role="calon_siswa" name={name}>
      <div className="pendaftaran-container">
        <div className="panel-header glass">
          <h2>Dashboard Calon Murid</h2>
          <p>Kelola pendaftaran PPDB Anda dari sini.</p>
        </div>

        {loading ? (
          <p>Memuat...</p>
        ) : (
          <>
            <div className="glass p-4 mb-4 flex-between">
              <div>
                <span>Status: </span>
                <StatusBadge status={status} />
                {noRegistrasi && <p className="mt-2">No. Registrasi: <strong>{noRegistrasi}</strong></p>}
              </div>
            </div>

            <PendaftaranStepper current={step} />

            {catatanAdmin && status === 'revisi' && (
              <motionCatatan catatan={catatanAdmin} />
            )}

            <div className="ppdb-dash-actions">
              <Link to="/calon-murid/formulir" className="btn-primary">
                Isi Formulir Biodata
              </Link>
              <Link to="/calon-murid/berkas" className="btn-secondary">
                Unggah Berkas
              </Link>
              <Link to="/calon-murid/status" className="btn-secondary">
                Lihat Status
              </Link>
              {['diterima', 'daftar_ulang', 'menjadi_murid'].includes(status) && (
                <Link to="/calon-murid/bukti" className="btn-primary">
                  Bukti Pendaftaran
                </Link>
              )}
            </div>

            <p className="text-muted mt-4">Status saat ini: {statusLabel}</p>
          </>
        )}
      </div>
    </MainLayout>
  );
}

function motionCatatan({ catatan }) {
  return (
    <div className="alert-warning glass mt-4">
      <strong>Catatan Admin:</strong> {catatan}
    </div>
  );
}
