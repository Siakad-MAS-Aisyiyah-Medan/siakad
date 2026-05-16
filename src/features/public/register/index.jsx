import RegisterForm from './components/RegisterForm';
import AppLogo from '../../../shared/components/AppLogo';
import { useRegister } from './hooks/useRegister';

export default function RegisterPage() {
  const { formData, loading, error, handleChange, handleRegister } = useRegister();

  return (
    <div className="login-container">
      <div className="login-visual">
        <div className="visual-content">
          <AppLogo size="lg" className="login-visual-logo" />
          <h1>Buat Akun Calon Siswa</h1>
          <p>Langkah awal untuk bergabung bersama Madrasah Aliyah Aisyiyah Medan. Gunakan NISN aktif Anda.</p>
        </div>
        <div className="blob-1" />
        <div className="blob-2" />
      </div>
      <RegisterForm formData={formData} loading={loading} error={error} onChange={handleChange} onSubmit={handleRegister} />
    </div>
  );
}
