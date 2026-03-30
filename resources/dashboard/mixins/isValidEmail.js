export default {
    methods: {
      isValidEmail(email) {
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (String(email)
        .toLowerCase()
        .match(pattern)) {
          this.invalidEmail = null;
          return true;
        } else {
          this.invalidEmail = 'Please Provide a valid email';
          return false;
        }
      },
    },
};
  