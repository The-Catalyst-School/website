<template>
  <div class="internal-side">
    <ul class="internal-nav">
      <li v-if="workshop.embeds.length">
        <a class="btn" href="#" v-scroll-to="'#main-embed'">Video</a>
      </li>
      <li>
        <a class="btn" href="#" v-scroll-to="'#content'">Content</a>
      </li>
      <li v-if="workshop.attachments.length">
        <a class="btn" href="#" v-scroll-to="'#resources'">Resources</a>
      </li>
      <li v-if="workshop.quiz">
        <a class="btn" href="#" v-scroll-to="'#quiz'">Quiz</a>
      </li>
      <div class="spacer"></div>
      <li v-if="workshop.comments">
        <a class="btn" href="#" v-scroll-to="'#comments'">Comments</a>
      </li>
      <li v-if="related.length">
        <a class="btn" href="#" v-scroll-to="'#related'">Related Workshops</a>
      </li>
    </ul>
  </div>
</template>


<script>
export default {
  props: ['workshop', 'related']
}
</script>

<style lang="scss" scoped>
@import '../../../sass/_mixins';
@import '../../../sass/_variables';
.internal-side {
  @include r('padding-top', 70);
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
