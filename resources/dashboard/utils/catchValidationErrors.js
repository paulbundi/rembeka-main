export default (vueInstance, response) => {
  if (!response.data.errors) {
    vueInstance.$toast.error( response.data.message);
  }
  const fields = Object.values(response.data.errors);
  fields.forEach((field) => {
    if (field.message) {
      vueInstance.$toast.error( field.message);
    } else {
      field.forEach((errorMessage) => {
        vueInstance.$toast.error(errorMessage);
      });
    }
  });
}
