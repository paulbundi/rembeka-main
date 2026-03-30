import i18next from 'i18next';
import en from './en';

i18next.init({
  lng: 'en',
  resources: {
    en: {
      translation: en.translation,
    },
  },
});

const t = i18next.t;
const exists = i18next.exists;

export {
  i18next,
  t,
  exists,
}
