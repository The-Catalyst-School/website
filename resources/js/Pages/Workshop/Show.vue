<template>
  <div class="single-workshop">
    <div class="side">
      <side :workshop="workshop"
        :related="related"
        v-sticky sticky-side="both" />
    </div>
    <div class="main">
      <h4>{{workshop.title}}</h4>
      <h1>{{workshop.subtitle}}</h1>
      <div id="main-embed" class="main-embed" v-if="workshop.embeds">
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
      <div id="content" class="html-content" v-html="workshop.content"></div>
      <div id="resources" v-if="workshop.resources"></div>
      <div id="quiz" v-if="workshop.quiz"></div>
      <div id="comments" v-if="workshop.comments"></div>
      <div id="related" class="related" v-if="related">
        <h4>Related workshops</h4>
        <div class="list">
          <workshop-preview
            :workshop="workshop"
            :key="`cours-preview-${index}`"
            v-for="(workshop, index) in related" />
        </div>
      </div>
    </div>
    <div class="side">
    </div>
  </div>
</template>

<script>
import Side from './Side'
import WorkshopPreview from '../../Components/WorkshopPreview'
export default {
  props: ['workshop', 'related'],
  components: {
    Side,
    WorkshopPreview
  },
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
      @include r('margin-top', -70px);
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
        float: left;
        @include r('margin-bottom', 15);
      }
      .workshop-info {
        width: 100%;
        float: left;
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
      .html-content {
        width: 100%;
        float: left;
        &:not(:last-child) {
          @include r('margin-bottom', 120);
        }
      }
      .related {
        width: 100%;
        float: left;
        &:not(:last-child) {
          @include r('margin-bottom', 120);
        }
        h4 {
          @include col(1 of 1);
          @include r('margin-bottom', 15);
        }
      }
    }
  }
</style>
