<template>
  <div class="internal-side">
    <ul class="internal-nav">
      <li>
        <a class="btn" href="#" v-scroll-to="'#content'">About us</a>
      </li>
      <li v-if="page.sentences">
        <a class="btn" href="#" v-scroll-to="'#team'">Team</a>
      </li>
    </ul>
  </div>
</template>


<script>
export default {
  props: ['page']
}
</script>

<style lang="scss" scoped>
@import '../../../sass/_mixins';
@import '../../../sass/_variables';
.internal-side {
  @include r('padding-top', 45px);
  ul.internal-nav {
    list-style: none;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    height: 80vh;
    li {
      @include r('margin-top', 6px);
      &:before {
        display: none;
      }
      width: 100%;
      a, a:visited {
        display: block;
        float: left;
      }
    }
    .spacer {
      flex-grow: 1;
    }
  }
}
</style>
