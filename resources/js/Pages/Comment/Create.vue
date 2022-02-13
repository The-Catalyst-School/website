<template>
  <div class="create-comment-wrapper">
    <div>
      <form class="create-comment" @submit.prevent="login">
        <h2>Your opinion is important to us, help the community to grow</h2>
        <div class="success" v-if="success">
          {{success}}
        </div>
        <textarea
          v-model="form.content" :error="form.errors.content"
          label="Content"
          placeholder="Leave a comment..."
          autofocus
          autocapitalize="off" />
        <div class="errors" v-if="errors || cErrors">
          {{errors.content}}
          {{cErrors.content}}
        </div>
        <div class="send-wrapper">
          <button class="btn" @click="this.form.reset()">Clear all</button>
          <button
            :disabled="this.form.content.length === 0"
            :loading="form.processing"
            class="btn" type="submit">Publish</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['errors', 'success', 'entity'],
  components: {
    Link
  },
  data() {
    return {
      cErrors: false,
      form: this.$inertia.form({
        content: '',
        entity: this.entity
      }),
    }
  },
  methods: {
    login() {
      this.form.post(
        this.$route('web.comment.store'),
        {
          onError: (errors) => this.cErrors = errors,
          preserveScroll: true
        }
      )

    }
  },
}
</script>
<style lang="scss" scoped>
@import '../../../sass/_mixins';
.create-comment-wrapper {
  @include r('padding', 5px 10px);
  h2 {
    @include r('padding-bottom', 25px);
    @include r('margin-bottom', 10px);
    border-bottom: 1px solid $black;
  }
  textarea {
    font-family: 'Neue Montreal';
    border: none;
    -webkit-appearance: none;
    width: 100%;
    @include m-font-size(20, 26);
    outline: 0;
    border-bottom: 1px solid $black;
    @include r('padding-bottom', 10px);
    @include r('margin-bottom', 10px);
  }
  button {
    background: $white;
    &:not(:last-child) {
      @include r('margin-right', 8px);
    }
    &:hover {
      background: $black;
      color: $white;
    }
  }
  .send-wrapper {
    justify-content: flex-end;
    display: flex;
  }
  .success {
    @include r('margin-bottom', 15px);
  }
}
</style>
