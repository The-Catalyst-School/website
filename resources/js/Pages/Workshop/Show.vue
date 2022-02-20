<template>
  <div class="single-workshop">
    <Head>
      <title>{{workshop.title}} - The Catalyst School</title>
      <meta name="description" :content="workshop.subtitle">
    </Head>
    <div class="side">
      <side :workshop="workshop"
        :related="related"
        v-sticky sticky-side="both" />
    </div>
    <div class="main">
      <h4>{{workshop.subtitle}}</h4>
      <h1>{{workshop.title}}</h1>
      <div id="main-embed" class="main-embed" v-if="workshop.embeds.length > 0">
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
      <div id="resources" class="resources" v-if="workshop.attachments.length > 0">
        <attachments :attachments="workshop.attachments" />
      </div>
      <div id="quiz" v-if="workshop.quiz"></div>
      <div id="comments" class="comments">
        <comments
          :comments="workshop.comments"
          :entity="{'type': 'Workshop', 'id': workshop.id}"
          />
      </div>
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
    <div class="side actions">
      <div v-sticky sticky-side="both">
        <div class="internal-side">
          <div class="internal-nav">
            <a
              class="btn"
              v-if="$page.props.auth.user"
              @click.prevent="subscribe($route(actionRoute, workshop.id))">
              {{actionText}}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link, Head } from '@inertiajs/inertia-vue'
import Side from './Side'
import WorkshopPreview from '../../Components/WorkshopPreview'
import Attachments from '../../Components/Attachments'
import Comments from '../../Components/Comments'
export default {
  props: ['workshop', 'related'],
  components: {
    Side,
    WorkshopPreview,
    Attachments,
    Comments,
    Link,
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
    subscribe(route) {
      this.$inertia.visit(route, {
        method: this.actionMethod,
        preserveScroll: true,
        onError(e) {
          let err = Object.values(errors).join('')
          this.$toast.open({
            message: err,
            type: 'error'
          })
        },
        onSuccess: (msg) => {
          this.$toast.open(msg.props.success);
        }
      })
    }
  },
  computed: {
    actionText() {
      return (this.workshop.subscribed) ? 'Unsubscribe' : 'Subscribe'
    },
    actionMethod() {
      return (this.workshop.subscribed) ? 'delete' : 'post'
    },
    actionRoute() {
      let route = 'web.workshop'
      if (this.workshop.subscribed) {
        route = route + '.unsubscribe'
      } else {
        route = route + '.subscribe'
      }
      return route
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
    @include mobile-tablet {
      padding: 20px 10px;
    }
    .side {
      @include col(2 of 14);
      @include r('margin-top', -70px);
      @include mobile-tablet {
        display: none;
      }
      &.actions {
        .internal-side {
          width: 100%;
          @include r('padding-top', 70px);
          .internal-nav {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-end;
            height: 80vh;
          }
        }
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
        @include mobile-tablet {
          flex-wrap: wrap;
        }
        .date {
          @include col(2 of 10);
          @include mobile-tablet {
            @include col(1 of 2);
          }
        }
        .teacher {
          @include col(6 of 10);
          @include mobile-tablet {
            @include col(1 of 1);
            order: 3;
          }
        }
        .estimated {
          @include col(2 of 10);
          text-align: right;
          @include mobile-tablet {
            @include col(1 of 2);
            order: 2;
          }
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
