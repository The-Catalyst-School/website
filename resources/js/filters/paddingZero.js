import Vue from 'vue'

Vue.filter('paddingZero', function (value, minLength) {
  return value.toString().padStart(minLength, '0')
})
