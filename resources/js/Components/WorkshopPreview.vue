<template>
  <div class="workshop-preview" :class="{'featured': (workshop.featured === 'yes')}">
    <div class="main-body">
      <div class="topics-wrapper">
        <div class="tag" :key="`topic-${topic.id}`" v-for="topic in workshop.topics">
          {{topic.title}}
        </div>
      </div>
      <div class="preview-body">
        <Link :href="$route('web.workshop.show', workshop.slug)">
          <div class="half">
            <div class="heading">
              <div class="date">{{ workshop.updated_at | dateFormat('DD.MM.YYYY') }}</div>
              <div class="estimated" v-if="workshop.estimated_time">
                Estimated time: {{workshop.estimated_time}}
              </div>
            </div>
            <div class="title">
              <h2>{{workshop.title}}</h2>
            </div>
            <div class="subtitle" v-if="workshop.subtitle">
              <h2>{{workshop.subtitle}}</h2>
            </div>
            <div class="footer">
              <span v-if="workshop.teacher">
                With {{workshop.teacher}}
              </span>
            </div>
          </div>
          <div class="half">
            <div class="about-label">About the workshop</div>
            <div class="about-intro" v-html="workshop.intro"></div>
          </div>
        </Link>
      </div>
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'
import Popup from './Popup';

export default {
  props: ['workshop'],
  components: {
    Link
  },
  data() {
    return {}
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.workshop-preview {
  @include col(4 of 14);
  @include r('margin-bottom', 20px);
  display: flex;
  flex-direction: column;
  @include mobile-tablet {
    @include col(1 of 1);
  }
  &.featured {
    @include col(6 of 14);
    @include mobile-tablet {
      @include col(1 of 1);
    }
  }
  .main-body {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    .topics-wrapper {
      display: flex;
      flex-wrap: wrap;
      .tag {
        @include transition('background, color');
        @include r('margin-bottom', 6px);
      }
    }
    .preview-body {
      border: 1px solid $black;
      flex-grow: 1;
      @include transition('background');
      a, a:visited {
        display: flex;
        flex-direction: column;
        height: 100%;
        @include transition('color');
      }
      .half {
        @include default-spacing;
        display: flex;
        flex-direction: column;
        &:first-child {
          flex-basis: 40%;
        }
        &:last-child {
          flex-basis: 60%;
          padding-top: 0;
          border-top: 1px solid $black;
          @include transition('border');
          .about-label {
            flex-grow: 1;
          }
        }
      }
      .heading {
        display: flex;
        justify-content: space-between;
      }
      .title {
        text-decoration: underline;
      }
      .subtitle {
        flex-grow: 1;
        @include r('padding-bottom', 80px);
      }
      .footer {
        flex-grow: 1;
        display: flex;
        align-items: flex-end;
      }
      .about-label {
        flex-grow: 1;
        @include r('padding-top', 10px);
        @include r('padding-bottom', 70px);
      }
      .about-intro {
        @include m-font-size(20, 26);
        @include mobile-tablet {
          @include font-size(18, 23);
        }
      }
    }
    &:hover {
      .preview-body {
        background: $black;
      }
      .topics-wrapper {
        .tag {
          background: $black;
          color: $yellow;
        }
      }
      .half {
        &:last-child {
          border-top: 1px solid $yellow;
        }
      }
      a, a:visited {
        color: $yellow;
      }
    }
  }
}
</style>
