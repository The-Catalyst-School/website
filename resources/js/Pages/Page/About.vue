<template>
  <div class="std-page">
    <div class="side affix">
      <about-side :page="page" v-sticky sticky-side="both" />
    </div>
    <div class="main">
      <h1>{{page.title}}</h1>
      <div id="content" class="html-content" v-html="page.content"></div>
      <div id="team">
        <h4>Meet our team</h4>
        <div class="team-list">
          <div class="single-team-member" v-for="person in page.sentences">
            <div class="image">
              <img class="real-avatar" :src="`/images/avatars/${person.avatar}`" />
            </div>
            <div class="info">
              <strong>{{person.text}}</strong><br />
              <div class="description" v-html="person.description"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="side affix">
    </div>
  </div>
</template>

<script>

import AboutSide from './AboutSide'
export default {
  props: ['page'],
  components: {
    AboutSide
  }
};
</script>

<style lang="scss" scoped>
  @import '../../../sass/_mixins';
  @import '../../../sass/_variables';
  .std-page {
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
      display: flex;
      flex-direction: column;
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
      .content {
        @include col(1 of 1, 0);
      }
      #team {
        @include col(1 of 1, 0);
        @include r('margin-top', 60px);
        @include mobile-tablet {
          @include col(1 of 1);
        }
        h4 {
          @include r('margin-bottom', 20px);
        }
        .team-list {
          border-top: 1px solid $black;
          border-bottom: 1px solid $black;
          @include r('padding-top', 20px);
          padding-left: #{(100%/10)};
          padding-right: #{(100%/10)};
          display: flex;
          justify-content: space-between;
          flex-wrap: wrap;
          @include mobile-tablet {
            padding-left: 0;
            padding-right: 0;
          }
          .single-team-member {
            @include col(1 of 3);
            display: flex;
            align-items: center;
            @include r('margin-bottom', 20px);
            @include mobile-tablet {
              @include col(1 of 1, 0);
            }
            .image {
              @include r('width', 90px);
              @include r('margin-right', 10px);
            }
          }
        }
      }
    }
    .about {

    }
  }
</style>
