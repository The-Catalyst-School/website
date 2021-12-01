<template>
  <main>
    <c-header />
    <article>
      <slot />
    </article>
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
