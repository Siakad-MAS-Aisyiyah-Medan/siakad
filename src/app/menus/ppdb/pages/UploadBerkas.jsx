import { Link } from 'react-router-dom';
import MainLayout from '@app/shared/layouts/MainLayout';
import UploadDokumen from '../components/UploadDokumen';
import { usePendaftaran } from '../hooks/usePendaftaran';
import { getJsonItem } from '@app/shared/utils/storage';

export default function UploadBerkas() {
  const p = usePendaftaran();
  const user = getJsonItem('user');

  return (
    <MainLayout role="calon_siswa" name={user?.username}>
      <div className="pendaftaran-container">
        <motionHeader />
        <UploadDokumen berkas={p.berkas} onUpload={p.handleUpload} disabled={p.isReadOnly} />
        {p.canEdit && (
          <div className="form-actions mt-4">
            <button type="button" className="btn-primary" onClick={p.submit} disabled={p.saving}>
              {p.saving ? 'Mengirim...' : 'Submit Pendaftaran'}
            </button>
            <Link to="/calon-murid/status" className="btn-secondary">
              Lihat Status
            </Link>
          </div>
        )}
      </div>
    </MainLayout>
  );
}

function motionHeader() {
  return (
    <div className="panel-header glass">
      <h2>Unggah Berkas</h2>
      <Link to="/calon-murid/dashboard">← Kembali</Link>
    </div>
  );
}
