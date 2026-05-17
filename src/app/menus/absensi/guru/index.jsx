import MainLayout from '@app/shared/layouts/MainLayout';
import { getStoredUser, getStoredProfile } from '@app/shared/services/auth.service';
import { getDisplayName } from '@app/shared/utils/profile';
import { useGuruAbsensi } from './hooks/useGuruAbsensi';
import AbsensiFilterForm from './components/AbsensiFilterForm';
import AbsensiSiswaTable from './components/AbsensiSiswaTable';

export default function GuruAbsensiPage() {
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
    loadSiswa,
    handleStatusChange,
    saveAbsensi,
    reset,
  } = useGuruAbsensi();

  return (
    <MainLayout role={role} name={name}>
      <div className="data-panel view-list">
        <div className="panel-header glass">
          <div className="header-text">
            <h2>Kelola Absensi Siswa</h2>
            <p>Input kehadiran siswa per kelas, mata pelajaran, tanggal, dan jam pelajaran.</p>
          </div>
        </div>
      </div>

      {step === 'filter' && (
        <AbsensiFilterForm
          meta={meta}
          kelasList={kelasList}
          mapelList={mapelList}
          loading={loading}
          onChange={handleMetaChange}
          onSubmit={loadSiswa}
        />
      )}

      {step === 'input' && (
        <AbsensiSiswaTable
          siswaRows={siswaRows}
          saving={saving}
          onStatusChange={handleStatusChange}
          onSave={saveAbsensi}
          onBack={reset}
        />
      )}
    </MainLayout>
  );
}
