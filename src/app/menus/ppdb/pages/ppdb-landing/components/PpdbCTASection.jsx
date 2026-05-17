import { Link } from 'react-router-dom';
import { ArrowRight } from 'lucide-react';

export default function PpdbCTASection() {
  return (
    <section className="pp-section pp-cta-section">
      <div className="pp-container pp-reveal">
        <div className="pp-cta-card">
          <div>
            <h2>Siap Menjadi Bagian dari MAS Aisyiyah Medan?</h2>
            <p>
              Mulai perjalanan pendidikan putra-putri Anda bersama kami. Daftar akun calon murid
              dan lengkapi formulir PPDB online.
            </p>
          </div>
          <div className="pp-cta-card__actions">
            <Link to="/register-calon-murid" className="pp-btn pp-btn--white pp-btn--lg">
              Daftar Sekarang
              <ArrowRight size={18} aria-hidden="true" />
            </Link>
            <Link to="/login" className="pp-btn pp-btn--outline-light pp-btn--lg">
              Login Calon Murid
            </Link>
          </div>
        </div>
      </div>
    </section>
  );
}
