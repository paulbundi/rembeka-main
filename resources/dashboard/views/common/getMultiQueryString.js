export default (query) => {
  const filtersArr = query.filters ? query.filters : [];
  const relationsArr = query.relations ? query.relations : [];
  const fieldsArr = query.fields ? query.fields : [];
  const countsArr = query.count ? query.count : [];
  const hasArray = query.has ? query.has : [];
  const sortArray = query.sort ? query.sort : [];

  let filterStr = '';

  const relationStr = relationsArr.length > 0 ? `include=${relationsArr.join('|')}` : '';

  if (relationsArr.length > 0 && filtersArr.length > 0) {
    filterStr = '&';
  }
  filterStr += filtersArr.length > 0 ? `filters[]=${filtersArr.join('&filters[]=')}` : '';

  const filterRelationStr = relationStr + filterStr;

  let paginationStr = '';
  if (query.page && query.page !== null) {
    if (filterRelationStr.length > 0) {
      paginationStr = '&';
    }
    paginationStr = `${paginationStr}page=${query.page}&perPage=${query.perPage || 50}`;
  }

  let fieldStr = '';
  if (fieldsArr.length > 0) {
    if (filterRelationStr.length > 0 || query.page) {
      fieldStr = '&';
    }
    fieldStr += fieldsArr.length > 0 ? `fields=${fieldsArr.join(',')}` : '';
  }

  let countStr = '';
  if (countsArr.length > 0) {
    if (filterRelationStr.length > 0 || query.page || fieldsArr.length > 0) {
      countStr = '&';
    }
    countStr += countsArr.length > 0 ? `count=${countsArr.join(',')}` : '';
  }

  let hasStr = '';
  if (hasArray.length > 0) {
    if (filterRelationStr.length > 0 || query.page || fieldsArr.length > 0 || countStr.length > 0) {
      hasStr = '&';
    }
    hasStr += hasArray.length > 0 ? `has[]=${hasArray.join('&has[]=')}` : '';
  }

  let sortStr = '';
  if (sortArray.length > 0) {
    if (
      filterRelationStr.length > 0 || query.page ||
      fieldsArr.length > 0 || countStr.length > 0 ||
      hasStr.length > 0
    ) {
      sortStr = '&';
    }
    sortStr += sortArray.length > 0 ? `sort=${sortArray.join(',')}` : '';
  }

  return filterRelationStr + paginationStr + fieldStr + countStr + hasStr + sortStr;
};
