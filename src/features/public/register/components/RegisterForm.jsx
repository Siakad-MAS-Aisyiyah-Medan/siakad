import { Link } from 'react-router-dom';
import AppLogo from '../../../../shared/components/AppLogo';

export default function RegisterForm({ formData, loading, error, onChange, onSubmit }) {
  return (
    <div className="login-form-side">
      <div className="form-card animate-fade-in">
        <header>
          <AppLogo size="lg" className="login-form-logo" />
          <h2>Registrasi Akun</h2>
          <p>Lengkapi data di bawah ini</p>
        </header>

        {error && <div className="error-alert">{error}</div>}

        <form onSubmit={onSubmit}>
          <div className="input-group">
            <label htmlFor="nama">Nama Lengkap</label>
            <input
              type="text"
              id="nama"
              placeholder="Masukkan nama lengkap"
              value={formData.nama}
              onChange={onChange}
              required
            />
          </div>
          <div className="input-group">
            <label htmlFor="email">Email Aktif</label>
            <input
              type="email"
              id="email"
              placeholder="example@email.com"
              value={formData.email}
              onChange={onChange}
              required
            />
          </div>
          <div className="input-group">
            <label htmlFor="nisn">NISN</label>
            <input
              type="text"
              id="nisn"
              placeholder="Masukkan NISN"
              value={formData.nisn}
              onChange={onChange}
              required
            />
          </div>
          <div className="input-group">
            <label htmlFor="password">Kata Sandi</label>
            <input
              type="password"
              id="password"
              placeholder="••••••••"
              value={formData.password}
              onChange={onChange}
              required
            />
          </div>
          <div className="input-group">
            <label htmlFor="password_confirmation">Konfirmasi Kata Sandi</label>
            <input
              type="password"
              id="password_confirmation"
              placeholder="••••••••"
              value={formData.password_confirmation}
              onChange={onChange}
              required
            />
          </div>
          <button type="submit" className="btn btn-primary login-btn" disabled={loading}>
            {loading ? 'Memproses...' : 'Daftar Sekarang'}
          </button>
        </form>

        <footer>
          <p>
            Sudah punya akun? <Link to="/">Login di sini</Link>
          </p>
        </footer>
      </div>
    </div>
  );
}
