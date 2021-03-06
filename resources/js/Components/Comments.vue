<template>
  <div class="comments">
    <div class="heading">
      <h4>Comments</h4>
      <div class="leave-comment"
        v-if="user && entity"
        @click="createComment($route('web.comment.create', [entity.type, entity.id]))">
          Leave a comment
        </div>
    </div>
    <div class="list" v-if="comments.length > 0">
      <div class="single-comment"
        v-for="comment in comments">
        <div class="internal-wrapper">
          <div class="info">
            <div class="avatar" v-if="comment.user">
              <img class="real-avatar"
               v-if="comment.user.avatar_url"
               :src="comment.user.avatar_url" />
              <img class="real-avatar"
               v-if="!comment.user.avatar_url"
               src="/images/avatars/1-1.svg" />
            </div>
            <div class="text-info-wrapper">
              <div class="user" v-if="comment.user">{{comment.user.name}}</div>
              <div class="published">{{comment.updated_at | dateFormat('DD.MM.YYYY HH:mm')}}</div>
            </div>
          </div>
          <div class="content">
            {{comment.content}}
          </div>
          <div class="actions" v-if="comment.user && userId === comment.user.id">
            <a class="edit"
              @click="createComment($route('web.comment.edit', [comment.id]))"
              >
                Edit
            </a>
            <a class="delete"
              @click="deleteComment($route('web.comment.delete', [comment.id]))"
              >Delete</a>
          </div>
        </div>
      </div>
    </div>
    <div class="no-comments" v-if="comments.length === 0">
      <h2>No comments</h2>
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['comments', 'entity'],
  components: {
    Link,
  },
  methods: {
    createComment(route) {
      this.$inertia.visitInModal(route, false, 8)
    },
    deleteComment(route) {
      this.$inertia.delete(route, {
        preserveScroll: true,
        onError(e) {
          this.$toast.open({
            message: e.comment,
            type: 'error'
          })
        },
        onSuccess: (msg) => {
          this.$toast.open({
            message: msg.props.success,
          });
        }
      })
    }
  },
  computed: {
    user() {
      return this.$page.props.auth.user
    },
    userId() {
      if (this.user) {
        return this.user.id
      }
      return false
    }
  }
}
</script>

<style lang="scss">
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.comments {
  width: 100%;
  float: left;
  &:not(:last-child) {
    @include r('margin-bottom', 120);
    @include mobile-tablet {
      margin-bottom: 70px;
    }
  }
  .heading {
    @include col(1 of 1);
    display: flex;
    justify-content: space-between;
    @include r('margin-bottom', 10px);
    @include mobile-tablet {
      margin-bottom: 15px;
    }
    h4 {
      flex-grow: 1;
    }
    .leave-comment {
      cursor: pointer;
    }
  }
  .no-comments {
    text-align: center;
    h2 {
      text-transform: initial;
    }
  }
  .list {
    @include col(1 of 1);
  }
  .single-comment {
    width: 100%;
    border-bottom: 1px solid $black;
    @include r('padding-top', 20px);
    @include r('padding-bottom', 20px);
    @include mobile-tablet {
      padding-top: 15px;
      padding-bottom: 15px;
    }
    &:first-child {
      border-top: 1px solid $black;
    }
    .internal-wrapper {
      @include col(10 of 14);
      @include col-before(2 of 14);
      display: flex;
      flex-direction: column;
      @include mobile-tablet {
        @include col(1 of 1, 0);
        margin-left: 0;
      }
    }
    .info {
      @include r('margin-bottom', 10px);
      display: flex;
      align-items: center;
      .avatar {
        @include r('width', 44px);
        @include r('height', 44px);
        @include r('margin-right', 6px);
        @include mobile-tablet {
          width: 34px;
          height: 24px;
        }
      }
    }
    .content {
      @include m-font-size(20, 26);
      @include mobile-tablet {
        @include font-size(14, 17);
      }
    }
    .actions {
      display: flex;
      @include r('margin-top', 6px);
      a, button {
        @include r('margin-right', 6px);
        cursor: pointer;
        &:hover {
          text-decoration: underline;
        }
      }
      button {
        -webkit-appearance: none;
        background: transparent;
        outline: 0;
        font-family: 'Neue Montreal';
        border: none;
        @include m-font-size(14, 17);
      }
    }
  }
}
</style>
