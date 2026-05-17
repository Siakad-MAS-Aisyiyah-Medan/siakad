import { useNavigate } from 'react-router-dom';
import { getToken } from '@app/shared/services/auth.service';
import { useLandingNav } from './hooks/useLandingNav';
import { useReveal } from './hooks/useReveal';
import LandingNavbar from './components/LandingNavbar';
import HeroSection from './components/HeroSection';
import AboutSection from './components/AboutSection';
import VisionMissionSection from './components/VisionMissionSection';
import StatsSection from './components/StatsSection';
import NewsPreview from './components/NewsPreview';
import ExtracurricularSection from './components/ExtracurricularSection';
import CTASection from './components/CTASection';
import LandingFooter from './components/LandingFooter';
import './landing.css';

const LandingPage = () => {
  const navigate = useNavigate();
  const token = getToken();
  const {
    activeSection,
    menuOpen,
    scrolled,
    setMenuOpen,
    scrollToSection,
  } = useLandingNav();

  useReveal();

  const handlePendaftaranClick = () => {
    if (token) navigate('/dashboard');
    else navigate('/pendaftaran');
  };

  return (
    <div className="landing-page">
      <LandingNavbar
        activeSection={activeSection}
        menuOpen={menuOpen}
        scrolled={scrolled}
        onToggleMenu={() => setMenuOpen((open) => !open)}
        onScrollToSection={scrollToSection}
        onPendaftaranClick={handlePendaftaranClick}
      />

      <main>
        <HeroSection
          onPendaftaranClick={handlePendaftaranClick}
          onLearnMore={() => scrollToSection('profil')}
        />
        <AboutSection />
        <VisionMissionSection />
        <StatsSection />
        <NewsPreview />
        <ExtracurricularSection />
        <CTASection onPendaftaranClick={handlePendaftaranClick} />
      </main>

      <LandingFooter onScrollToSection={scrollToSection} />
    </div>
  );
};

export default LandingPage;
