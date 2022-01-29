<template>
  <main>
    <c-header />
    <div class="main-wrapper">
      <article>
        <slot />
      </article>
    </div>
    <c-footer />
    <modal />
  </main>
</template>

<script>
import CHeader from '../Partials/CHeader'
import CFooter from '../Partials/CFooter'
import Modal from '../Partials/Modal'

export default {
  components: {
    CHeader,
    CFooter,
    Modal
  }
}
</script>

<style lang="scss">
@import '../../sass/_mixins';
.main-wrapper {
  min-height: 100vh;
  @include r('padding-top', 110px);
  @include r('padding-bottom', 220px);
}
</style>
