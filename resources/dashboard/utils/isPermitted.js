export default (permissions, permissionStr) => {
  return permissionStr.split('.').reduce((prev, curr) => {
    return prev ? prev[curr] : undefined;
  }, permissions) !== undefined;
};
