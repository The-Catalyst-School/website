<template>
  <div class="single-workshop">
    <div class="side">
      <ul class="internal-nav">
        <li>Video</li>
        <li>Introduction</li>
        <li>Resources</li>
        <li>Quiz</li>
        <li>Comments</li>
        <li>Related workshops</li>
      </ul>
    </div>
    <div class="main">
      <h4>{{workshop.title}}</h4>
      <h1>{{workshop.subtitle}}</h1>
      <div class="main-embed" v-if="workshop.embeds">
        <video-embed :params="getVideoParams(workshop.embeds[0].url)"
          css="video is-16by9" :src="workshop.embeds[0].url"></video-embed>
      </div>
      <div class="workshop-info">
        <div class="date">{{ workshop.scheduled_at | dateFormat('DD.MM.YYYY') }}</div>
        <div class="teacher" v-if="workshop.teacher">
          With {{workshop.teacher}}
        </div>
        <div class="estimated" v-if="workshop.estimated_time">
          Estimated time: {{workshop.estimated_time}}
        </div>
      </div>
      <div class="html-content" v-html="workshop.content"></div>
    </div>
    <div class="side">
    </div>
  </div>
</template>

<script>
export default {
  props: ['workshop'],
  methods: {
    parseUrlQuery(value) {
      var urlParams = new URL(value).searchParams
      return Array.from(urlParams.keys()).reduce((acc, key) => {
        acc[key] = urlParams.getAll(key)
        return acc
      }, {})
    },
    getVideoParams(video) {
      let params = {
        'picture-in-picture': 1,
        accelerometer: 1,
        gyroscope: 1
      }
      var urlParams = this.parseUrlQuery(video)
      if (urlParams["start"]) {
        params.start = urlParams["start"]
      }
      if (urlParams["end"]) {
        params.end = urlParams["end"]
      }
      return params
    },
  }
};
</script>

<style lang="scss" scoped>
  @import '../../../sass/_mixins';
  @import '../../../sass/_variables';
  .single-workshop {
    @include r('padding', 20px 30px);
    display: flex;
    .side {
      @include col(2 of 14);
    }
    .main {
      @include col(10 of 14, 0);
      & > h4 {
        @include col(1 of 1);
      }
      & > h1 {
        @include col(1 of 1);
        @include r('margin-bottom', 8);
      }
      .main-embed {
        @include col(1 of 1);
        @include r('margin-bottom', 15);
      }
      .workshop-info {
        display: flex;
        @include r('margin-bottom', 70);
        .date {
          @include col(2 of 10);
        }
        .teacher {
          @include col(6 of 10);
        }
        .estimated {
          @include col(2 of 10);
          text-align: right;
        }
      }
    }
  }
</style>
<style lang="scss">
  @use 'sass:math';
  @import '../../../sass/_mixins';
  @import '../../../sass/_variables';
  .video {
    position: relative;
    display: block;
    width: 100%;
    padding: 0;
    &.is-21by9 {
      padding-top: 42.85714%
    }
    &.is-16by9 {
      padding-top: 56.25%
    }
    &.is-4by3 {
      padding-top: 75%
    }
    &.is-1by1 {
      padding-top: 100%
    }
    iframe, embed, object, video {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: 0
    }
  }
  .html-content {
    h1 {
      &:first-child {
        display: none;
        & + .video {
          display: none;
        }
      }
    }
    h2, h3, h4 {
      @include m-font-size(12, 15);
      @include col(2 of 10);
      clear: left;
      float: left;
      transform: translateY(#{relative-size(4px)});
    }
    h2 {
      font-weight: 600;
      text-transform: initial;
    }
    blockquote {
      p {
        border-left: 4px solid $black;
      }
    }
    .embed-responsive {
      &.is-16by9 {
        padding-top: 37.25%
      }
      iframe {
        width: calc(100% - #{$default-gutter});
        margin-left: math.div($default-gutter, 2);
      }
      .caption {
        position: absolute;
        left: 100%;
        top: 0;
        @include m-font-size(12, 15);
        @include col(1.5 of 6);
        @include col-before(0.5 of 6);
      }
    }
    p, ul, ol, .hint, blockquote, .embed-responsive {
      @include m-font-size(20, 24);
      @include r('margin-bottom', 20);
      @include col(6 of 10);
      float: left;
      & + p, & + ul, & + ol, & + .hint, & + blockquote, & + .embed-responsive {
        @include col-before(2 of 10);
      }
    }
  }
</style>
