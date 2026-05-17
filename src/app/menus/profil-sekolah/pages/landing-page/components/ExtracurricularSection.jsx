import SectionHeader from './SectionHeader';
import { EKSKUL_DATA } from '../data/landingData';

export default function ExtracurricularSection() {
  return (
    <section id="ekskul" className="lp-section">
      <div className="lp-container">
        <SectionHeader
          eyebrow="Ekstrakurikuler"
          title="Wadah Pengembangan Bakat"
          subtitle="Beragam kegiatan untuk menumbuhkan minat, bakat, dan karakter siswa."
        />

        <div className="lp-ekskul-grid lp-reveal">
          {EKSKUL_DATA.map((item) => {
            const Icon = item.icon;
            return (
              <article key={item.name} className="lp-card lp-ekskul-card">
                <div className="lp-ekskul-card__icon">
                  <Icon size={28} aria-hidden="true" />
                </div>
                <h3>{item.name}</h3>
                <p>{item.desc}</p>
              </article>
            );
          })}
        </div>
      </div>
    </section>
  );
}
