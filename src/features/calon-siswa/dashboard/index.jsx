import MainLayout from '../../../app/layouts/MainLayout';
import PendaftaranWizard from './components/PendaftaranWizard';
import { usePendaftaran } from './hooks/usePendaftaran';
import { getJsonItem } from '../../../shared/utils/storage';
import { getDisplayName } from '../../../shared/utils/profile';

export default function CalonSiswaDashboard() {
  const pendaftaran = usePendaftaran();
  const user = getJsonItem('user');
  const storedProfile = getJsonItem('profile');
  const name =
    pendaftaran.formData.nama_lengkap ||
    getDisplayName(storedProfile, 'calon_siswa', user?.username);

  return (
    <MainLayout role="calon_siswa" name={name}>
      <PendaftaranWizard {...pendaftaran} />
    </MainLayout>
  );
}
