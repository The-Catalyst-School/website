<template>
  <div class="error-page">
    <div class="side affix">
    </div>
    <div class="main">
      <h1>{{title}}</h1>
      <div id="content" class="html-content">
        <p>{{description}}</p>
      </div>
    </div>
    <div class="side affix">
    </div>
  </div>
</template>

<script>
export default {
  props: {
    status: Number,
  },
  computed: {
    title() {
      return {
        503: '503: Service Unavailable',
        500: '500: Server Error',
        404: '404: Page Not Found',
        403: '403: Forbidden',
      }[this.status]
    },
    description() {
      return {
        503: 'Sorry, we are doing some maintenance. Please check back soon.',
        500: 'Whoops, something went wrong on our servers.',
        404: 'Sorry, the page you are looking for could not be found.',
        403: 'Sorry, you are forbidden from accessing this page.',
      }[this.status]
    },
  },
}
</script>

<style lang="scss" scoped>
  @import '../../../sass/_mixins';
  @import '../../../sass/_variables';
  .error-page {
    @include r('padding', 20px 30px);
    display: flex;
    @include mobile-tablet {
      padding: 20px 10px;
    }
    .side {
      @include col(2 of 14);
      @include mobile-tablet {
        display: none;
      }
    }
    .main {
      @include col(10 of 14, 0);
      @include mobile-tablet {
        @include col(1 of 1, 0);
      }
      & > h4 {
        @include col(1 of 1);
      }
      & > h1 {
        @include col(1 of 1);
        @include r('margin-bottom', 8px);
      }
    }
  }
</style>
