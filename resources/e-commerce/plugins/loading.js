import Vue from 'vue';

const defaultBackgroundColor = '#FF0000'

// Initialize the annoying-background directive.
export const loading = {
  bind(el, binding, vnode) {
   if(binding.value == true) {
    el.innerHTML='<div class="d-flex justify-content-center" style="width:100%;"><div class="spinner-border text-primary" role="status"> <span class="visually-hidden">Loading...</span></div></div>';
   }
  },
  update(el, binding, vnode) {
    if(binding.value) {
    el.innerHTML='<div class="d-flex justify-content-center" style="width:100%;"><div class="spinner-border text-primary" role="status"> <span class="visually-hidden">Loading...</span></div></div>';

      // el.innerHTML='<div class="spinner-border text-primary text-center" role="status"> <span class="visually-hidden">Loading...</span></div>';
    } else {
      vnode.key += '1'
      vnode.context.$forceUpdate()
    }
  }

};