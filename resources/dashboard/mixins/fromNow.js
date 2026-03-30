import dayjs from "dayjs"
import relativeTime from "dayjs/plugin/relativeTime"

export default {
  methods: {
    fromNow(value, option= null) {
      if(!value) return;
      if(option) return dayjs(value).format(option);

      dayjs.extend(relativeTime)
      return dayjs(value).fromNow();
     
    },
  },
};
