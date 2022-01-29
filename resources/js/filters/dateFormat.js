import Vue from 'vue'
import dayjs from 'dayjs';

Vue.filter('dateFormat', function (value, format) {
  if (!value) return ''
  return dayjs(value).format(format)
})
