import MainLayout from '@app/shared/layouts/MainLayout';
import { getStoredUser, getStoredProfile } from '@app/shared/services/auth.service';
import { getDisplayName } from '@app/shared/utils/profile';
import { useGuruNilai } from './hooks/useGuruNilai';
import NilaiFilterForm from './components/NilaiFilterForm';
import NilaiSiswaTable from './components/NilaiSiswaTable';

export default function GuruNilaiPage() {
  const user = getStoredUser();
  const profile = getStoredProfile();
  const name = getDisplayName(profile, user?.role, user?.username);
  const role = user?.role === 'wali_kelas' ? 'wali_kelas' : 'guru';

  const {
    step,
    meta,
    kelasList,
    mapelList,
    siswaRows,
    loading,
    saving,
    handleMetaChange,
    handleNilaiChange,
    loadSiswa,
    saveNilai,
    reset,
  } = useGuruNilai();

  return (
    <MainLayout role={role} name={name}>
      <div className="data-panel view-list">
        <div className="panel-header glass">
          <div className="header-text">
            <h2>Kelola Nilai Siswa</h2>
            <p>Input nilai tugas, UTS, UAS, praktik, dan sikap per kelas dan mata pelajaran.</p>
          </div>
        </div>
      </div>

      {step === 'filter' && (
        <NilaiFilterForm
          meta={meta}
          kelasList={kelasList}
          mapelList={mapelList}
          loading={loading}
          onChange={handleMetaChange}
          onSubmit={loadSiswa}
        />
      )}

      {step === 'input' && (
        <NilaiSiswaTable
          siswaRows={siswaRows}
          saving={saving}
          onChange={handleNilaiChange}
          onSave={saveNilai}
          onBack={reset}
        />
      )}
    </MainLayout>
  );
}
