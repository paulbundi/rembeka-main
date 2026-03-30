export default {
  methods: {
    pageChange(value) {
      this.setProperty({
        property: 'pagination',
        subProperty: 'page',
        value,
      });

      this.fetchItems(false);
    },
  },
};
