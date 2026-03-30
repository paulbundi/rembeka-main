export default {
  methods: {
    updateProperty(subProperty, value) {
      this.setProperty({
        property: 'selected',
        subProperty,
        value,
      });
    },
  },
};
