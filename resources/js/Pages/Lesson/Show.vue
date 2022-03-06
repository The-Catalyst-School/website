<template>
  <div class="single-lesson">
    <Head>
      <title>{{lesson.title}} - {{lesson.course.title}} - The Catalyst School</title>
      <meta name="description" :content="lesson.seo_description">
    </Head>
    <div class="side affix">
      <side :lesson="lesson"
        :related="related"
        v-sticky sticky-side="both" />
    </div>
    <div class="main">
      <h4>{{lesson.course.title}}</h4>
      <h1>{{lesson.title}}</h1>
      <div id="main-embed" class="main-embed" v-if="lesson.embeds.length > 0">
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
          <div class="prev">
            <div
              class="btn"
              v-if="$page.props.auth.user && lesson.course.current_lesson < lesson.id"
              @click="subscribe"
              >
              Mark as completed
            </div>
            <div class="btn active"
              v-if="$page.props.auth.user && lesson.course.current_lesson >= lesson.id"
              >
              Lesson Completed!
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="mobile-side">
      <div class="on-left">
        <div class="next" v-if="next">
          <Link class="btn active" :href="$route('web.lesson.show', [lesson.course.slug, next.slug])">
            Next
          </Link>
        </div>
        <div class="prev" v-if="prev">
          <Link class="btn active" :href="$route('web.lesson.show', [lesson.course.slug, prev.slug])">
            Previous
          </Link>
        </div>
      </div>
      <div class="on-right">
        <div
          class="btn active"
          v-if="$page.props.auth.user && lesson.course.current_lesson < lesson.id"
          @click="subscribe"
          >
          Mark as completed
        </div>
        <div class="btn active"
          v-if="$page.props.auth.user && lesson.course.current_lesson >= lesson.id"
          >
          Completed!
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link, Head } from '@inertiajs/inertia-vue'
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
    Comments,
    Head
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
    subscribe() {
      this.$inertia.post(
        this.$route('web.course.subscribe', this.lesson.course.id),
        {
          'current_lesson': this.lesson.id
        },
        {
          preserveScroll: true
        }
      )
    }
  }
};
</script>

<style lang="scss" scoped>
  @import '../../../sass/_mixins';
  @import '../../../sass/_variables';
  .single-lesson {
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
      &.next-prev {
        .internal-side {
          @include r('padding-top', 70px);
          display: flex;
          flex-direction: column;
          align-items: flex-end;
          & > div {
            @include r('margin-bottom', 6px);
          }
          a, a:visited {
            display: block;

          }
        }
      }
    }
    .mobile-side {
      display: none;
      position: fixed;
      bottom: 0;
      left: 0;
      padding: 20px;
      justify-content: space-between;
      width: 100%;
      .on-left, .on-right {
        display: flex;
        &.on-right {
          justify-content: flex-end;
        }
        .next, .prev {
          display: flex;
          &:not(:last-child) {
            margin-bottom: 6px;
          }
        }
      }
      @include mobile-tablet {
        display: flex;
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
      .main-embed {
        @include col(1 of 1);
        float: left;
        @include r('margin-bottom', 15px);
      }
      .workshop-info {
        width: 100%;
        float: left;
        display: flex;
        @include r('margin-bottom', 70px);
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
          @include r('margin-bottom', 120px);
        }
      }
    }
  }
</style>
