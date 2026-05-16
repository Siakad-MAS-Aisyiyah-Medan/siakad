const PREFIX = 'siakad_';

const KEYS = ['token', 'user', 'profile', 'permissions', 'menus', 'redirect_path'];

function migrateFromLocalStorage() {
  KEYS.forEach((key) => {
    const legacy = localStorage.getItem(key);
    const current = sessionStorage.getItem(PREFIX + key);
    if (legacy && !current) {
      sessionStorage.setItem(PREFIX + key, legacy);
    }
    if (legacy) {
      localStorage.removeItem(key);
    }
  });
}

migrateFromLocalStorage();

export function setAuthItem(key, value) {
  if (value === null || value === undefined) {
    sessionStorage.removeItem(PREFIX + key);
    return;
  }
  sessionStorage.setItem(PREFIX + key, value);
}

export function getAuthItem(key) {
  return sessionStorage.getItem(PREFIX + key);
}

export function removeAuthItem(key) {
  sessionStorage.removeItem(PREFIX + key);
}

export function clearAuthStorage() {
  KEYS.forEach((key) => removeAuthItem(key));
}
