<template>
  <div class="single-lesson">
    <div class="side affix">
      <side :lesson="lesson"
        :related="related"
        v-sticky sticky-side="both" />
    </div>
    <div class="main">
      <h4>{{lesson.course.title}}</h4>
      <h1>{{lesson.title}}</h1>
      <div id="main-embed" class="main-embed" v-if="lesson.embeds">
        <video-embed :params="getVideoParams(lesson.embeds[0].url)"
          css="video is-16by9" :src="lesson.embeds[0].url"></video-embed>
      </div>
      <div class="workshop-info">
        <div class="date">{{ lesson.updated_at | dateFormat('DD.MM.YYYY') }}</div>
        <div class="teacher" v-if="lesson.teacher">
          With {{lesson.teacher}}
        </div>
        <div class="estimated" v-if="lesson.estimated_time">
          Estimated time: {{lesson.estimated_time}}
        </div>
      </div>
      <div id="content" class="html-content" v-html="lesson.content"></div>
      <div id="resources" class="resources" v-if="lesson.attachments.length > 0">
        <attachments :attachments="lesson.attachments" />
      </div>
      <div id="quiz" v-if="lesson.quiz"></div>
      <div id="comments" class="comments">
        <comments
          :comments="lesson.comments"
          :entity="{'type': 'Lesson', 'id': lesson.id}"
          />
      </div>
      <div id="related" class="related" v-if="related">
        <h4>Related courses</h4>
        <div class="list">
          <course-preview
            :course="course"
            :key="`cours-preview-${index}`"
            v-for="(course, index) in related" />
        </div>
      </div>
    </div>
    <div class="side next-prev">
      <div class="side-wrapper" v-sticky sticky-side="both">
        <div class="internal-side">
          <div class="next" v-if="next">
            <Link class="btn" :href="$route('web.lesson.show', [lesson.course.slug, next.slug])">
              Next Lesson
            </Link>
          </div>
          <div class="prev" v-if="prev">
            <Link class="btn" :href="$route('web.lesson.show', [lesson.course.slug, prev.slug])">
              Previous Lesson
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import Side from './Side'
import CoursePreview from '../../Components/CoursePreview'
import Attachments from '../../Components/Attachments'
import Comments from '../../Components/Comments'
export default {
  props: ['lesson', 'next', 'prev', 'related', 'comments'],
  components: {
    Link,
    Side,
    CoursePreview,
    Attachments,
    Comments
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
  .single-lesson {
    @include r('padding', 20px 30px);
    display: flex;
    .side {
      @include col(2 of 14);
      &.next-prev {
        .internal-side {
          @include r('padding-top', 70);
          display: flex;
          flex-direction: column;
          align-items: flex-end;
        }
      }
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
      .html-content, .resources {
        width: 100%;
        float: left;
        &:not(:last-child) {
          @include r('margin-bottom', 120);
        }
      }
    }
  }
</style>
