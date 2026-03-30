

export default {
  /* eslint-disable no-param-reassign */
  install: (Vue) => {

    Vue.filter('numberFormat', (value) => {
      if (!value || value.length < 3) return '';
      return  value.toString().replace(/\B(?=(\d{3})+(?!\d)?\.)/g, ","); 
    });
  },
}
