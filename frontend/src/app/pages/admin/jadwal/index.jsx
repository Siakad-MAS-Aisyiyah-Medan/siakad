import AdminPageShell from '@app/shared/components/AdminPageShell';
import JadwalClassList from '@app/shared/jadwal/admin/components/JadwalClassList';
import JadwalMatrixUI from '@app/shared/jadwal/admin/components/JadwalMatrixUI';
import { useJadwal } from '@app/shared/jadwal/admin/hooks/useJadwal';

export default function JadwalPage() {
  const {
    view,
    searchQuery,
    setSearchQuery,
    filteredKelas,
    mapelData,
    guruData,
    waktuData,
    matrixData,
    currentKelas,
    tahunAjaran,
    semester,
    loading,
    openMatrix,
    cancelMatrix,
    handleMatrixChange,
    saveMatrix,
    isFetching,
  } = useJadwal();

  return (
    <AdminPageShell>
      {view === 'list' && (
        <JadwalClassList
          kelasData={filteredKelas}
          searchQuery={searchQuery}
          onSearchChange={setSearchQuery}
          onSelectKelas={openMatrix}
          isFetching={isFetching}
        />
      )}
      
      {view === 'matrix' && (
        <JadwalMatrixUI
          kelas={currentKelas}
          tahunAjaran={tahunAjaran}
          semester={semester}
          waktuData={waktuData}
          matrixData={matrixData}
          mapelData={mapelData}
          guruData={guruData}
          loading={loading}
          onCancel={cancelMatrix}
          onChangeCell={handleMatrixChange}
          onSave={saveMatrix}
        />
      )}
    </AdminPageShell>
  );
}
