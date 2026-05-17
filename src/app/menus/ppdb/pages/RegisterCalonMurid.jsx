import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { ArrowLeft, AlertCircle } from 'lucide-react';
import Swal from 'sweetalert2';
import AppLogo from '@app/shared/components/AppLogo';
import { registerCalonMurid } from '../services/ppdbApi';
import './register-calon.css';

const FIELDS = [
  {
    id: 'nama_lengkap',
    label: 'Nama Lengkap',
    type: 'text',
    placeholder: 'Masukkan nama lengkap',
    autoComplete: 'name',
    hint: null,
  },
  {
    id: 'nisn',
    label: 'NISN',
    type: 'text',
    placeholder: 'Masukkan NISN',
    autoComplete: 'username',
    hint: 'Digunakan sebagai username saat login',
  },
  {
    id: 'email',
    label: 'Email',
    type: 'email',
    placeholder: 'nama@email.com',
    autoComplete: 'email',
    hint: null,
  },
  {
    id: 'no_hp',
    label: 'No. HP',
    type: 'tel',
    placeholder: '08xxxxxxxxxx',
    autoComplete: 'tel',
    hint: null,
  },
  {
    id: 'password',
    label: 'Password',
    type: 'password',
    placeholder: 'Minimal 8 karakter',
    autoComplete: 'new-password',
    hint: 'Minimal 8 karakter',
  },
  {
    id: 'password_confirmation',
    label: 'Konfirmasi Password',
    type: 'password',
    placeholder: 'Ulangi password',
    autoComplete: 'new-password',
    hint: null,
  },
];

const INITIAL_FORM = {
  nama_lengkap: '',
  email: '',
  nisn: '',
  no_hp: '',
  password: '',
  password_confirmation: '',
};

export default function RegisterCalonMurid() {
  const navigate = useNavigate();
  const [form, setForm] = useState(INITIAL_FORM);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const onChange = (e) => {
    setForm((prev) => ({ ...prev, [e.target.id]: e.target.value }));
    if (error) setError('');
  };

  const validateClient = () => {
    if (form.password.length < 8) {
      return 'Password minimal 8 karakter.';
    }
    if (form.password !== form.password_confirmation) {
      return 'Konfirmasi password tidak cocok.';
    }
    return '';
  };

  const onSubmit = async (e) => {
    e.preventDefault();
    const clientError = validateClient();
    if (clientError) {
      setError(clientError);
      return;
    }

    setLoading(true);
    setError('');
    try {
      await registerCalonMurid(form);
      await Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil',
        text: 'Silakan login menggunakan NISN Anda.',
        confirmButtonColor: '#0f7a5c',
      });
      navigate('/login');
    } catch (err) {
      setError(err.response?.data?.message || 'Gagal registrasi. Periksa kembali data Anda.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="register-page">
      <aside className="register-page__brand" aria-label="Informasi PPDB">
        <div className="register-page__brand-bg" aria-hidden="true" />
        <div className="register-page__brand-inner">
          <div className="register-page__logo">
            <AppLogo size="lg" />
          </div>
          <h1>Registrasi Calon Murid</h1>
          <p>Buat akun untuk mengikuti PPDB MAS Aisyiyah Medan.</p>
          <p className="register-page__brand-note">Sudah membaca informasi pendaftaran?</p>
          <Link to="/pendaftaran" className="register-page__back-link">
            <ArrowLeft size={18} aria-hidden="true" />
            Kembali ke Informasi PPDB
          </Link>
        </div>
      </aside>

      <section className="register-page__form-area">
        <div className="register-page__card">
          <header className="register-page__card-header">
            <h2>Form Registrasi</h2>
            <p>Lengkapi data berikut untuk membuat akun calon murid.</p>
          </header>

          {error ? (
            <div className="register-page__alert" role="alert">
              <AlertCircle size={18} aria-hidden="true" />
              <span>{error}</span>
            </div>
          ) : null}

          <form onSubmit={onSubmit} noValidate>
            {FIELDS.map((field) => (
              <div key={field.id} className="register-page__field">
                <label htmlFor={field.id}>{field.label}</label>
                <input
                  type={field.type}
                  id={field.id}
                  name={field.id}
                  value={form[field.id]}
                  onChange={onChange}
                  placeholder={field.placeholder}
                  autoComplete={field.autoComplete}
                  required
                  disabled={loading}
                />
                {field.hint ? (
                  <span className="register-page__field-hint">{field.hint}</span>
                ) : null}
              </div>
            ))}

            <button type="submit" className="register-page__submit" disabled={loading}>
              {loading ? (
                <>
                  <span className="register-page__spinner" aria-hidden="true" />
                  Memproses...
                </>
              ) : (
                'Daftar Akun'
              )}
            </button>
          </form>

          <footer className="register-page__footer">
            <p>
              Sudah punya akun? <Link to="/login">Login</Link>
            </p>
          </footer>
        </div>
      </section>
    </div>
  );
}
