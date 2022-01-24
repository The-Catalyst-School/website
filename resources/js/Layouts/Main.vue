<template>
  <main>
    <c-header />
    <div class="main-wrapper">
      <article>
        <slot />
      </article>
    </div>
    <c-footer />
  </main>
</template>

<script>
import CHeader from '../Partials/CHeader'
import CFooter from '../Partials/CFooter'

export default {
  components: {
    CHeader,
    CFooter
  }
}
</script>

<style lang="scss">
@import '../../sass/_mixins';
.main-wrapper {
  min-height: 100vh;
  @include r('padding-top', 110px);
  @include r('padding-bottom', 220px);
  @include r('padding-left', 30px);
  @include r('padding-right', 30px);
}
</style>
