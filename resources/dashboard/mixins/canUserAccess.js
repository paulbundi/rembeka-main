import isPermitted from '../utils/isPermitted';

export default {
  methods: {
    canUserAccess(permission) {
      return isPermitted(this.$store.state.authUser.permissions, permission);
    },
    canUserAccessOneOf(permissions) {
      return permissions.some(p => isPermitted(this.$store.state.authUser.permissions, p));
    },
  },
};
