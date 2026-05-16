import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Swal from 'sweetalert2';
import { register } from '../../../../services/auth.service';

const INITIAL = {
  nama: '',
  email: '',
  nisn: '',
  password: '',
  password_confirmation: '',
};

export function useRegister() {
  const [formData, setFormData] = useState(INITIAL);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const navigate = useNavigate();

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.id]: e.target.value });
  };

  const handleRegister = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {
      await register(formData);
      Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil!',
        text: 'Silakan login menggunakan NISN Anda.',
        confirmButtonColor: '#198754',
      });
      navigate('/');
    } catch (err) {
      setError(err.response?.data?.message || 'Gagal melakukan registrasi');
    } finally {
      setLoading(false);
    }
  };

  return { formData, loading, error, handleChange, handleRegister };
}
