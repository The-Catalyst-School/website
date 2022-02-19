<template>
  <div class="avatar-selection">
    <h2>Change your avatar</h2>
    <div class="avatar-canvas">
      <div class="avatar-base">
        <div class="eyes-list" :style="{'left': `${eyeLeft}%`}">
          <div class="single-eye" v-for="eye in eyes">
            <img :src="`/images/eyes-${eye}.svg`" />
          </div>
        </div>
        <div class="mouth-list" :style="{'left': `${mouthLeft}%`}">
          <div class="single-mouth" v-for="mouth in mouths">
            <img :src="`/images/mouth-${mouth}.svg`" />
          </div>
        </div>
      </div>
    </div>
    <div class="actions">
      <div class="left">
        <div class="btn" @click="randomSelection()">random</div>
        <div class="btn" @click="defaultSelection()">default</div>
      </div>
      <div class="center">
        <div class="eyes">
          <div class="btn with-image" @click="moveEyes(-1)">
            <img src="/images/left.svg" />
          </div>
          <div class="btn active">Eyes</div>
          <div class="btn with-image" @click="moveEyes(1)">
            <img src="/images/right.svg" />
          </div>
        </div>
        <div class="mouth">
          <div class="btn with-image" @click="moveMouth(-1)">
            <img src="/images/left.svg" />
          </div>
          <div class="btn active">Mouth</div>
          <div class="btn with-image" @click="moveMouth(1)">
            <img src="/images/right.svg" />
          </div>
        </div>
      </div>
      <div class="right">
        <div class="btn" @click="saveAvatar">ok</div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: ['user'],
  data() {
    return {
      currentEyes: (this.user.avatar) ? this.user.avatar.eyes : 1,
      currentMouth: (this.user.avatar) ? this.user.avatar.mouth : 1,
      eyes: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
      mouths: [1,2,3,4,5,6,7,8,9,10],
    }
  },
  components: {
  },
  computed: {
    eyeLeft() {
      return -(this.eyes.indexOf(this.currentEyes) * 100)
    },
    mouthLeft() {
      return -(this.mouths.indexOf(this.currentMouth) * 100)
    }
  },
  methods: {
    moveEyes(direction) {
      let currentEyes = this.currentEyes
      currentEyes = currentEyes + direction
      if (currentEyes < 1) {
        currentEyes = this.eyes.length - 1
      }
      if (currentEyes > this.eyes.length - 1) {
        currentEyes = 1
      }
      this.currentEyes = currentEyes
    },
    moveMouth(direction) {
      let currentMouth = this.currentMouth
      currentMouth = currentMouth + direction
      if (currentMouth < 1) {
        currentMouth = this.mouths.length - 1
      }
      if (currentMouth > this.mouths.length - 1) {
        currentMouth = 1
      }
      this.currentMouth = currentMouth
    },
    saveAvatar() {
      this.$inertia.post(this.$route('web.profile.avatar.store'),
      {
        avatar: {
          eyes: this.currentEyes,
          mouth: this.currentMouth,
        }
      },
      {
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
    },
    randomSelection() {
      this.currentEyes = this.eyes[Math.floor(Math.random()*this.eyes.length)]
      this.currentMouth = this.mouths[Math.floor(Math.random()*this.mouths.length)]
    },
    defaultSelection() {
      this.currentEyes = 1
      this.currentMouth = 1
    }
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../../sass/_mixins';
.avatar-selection {
  display: flex;
  flex-direction: column;
  @include r('padding', 5px 10px);
  h2 {
    @include r('margin-bottom', 22px);
  }
  .avatar-canvas {
    @include col(3 of 4);
    @include col-before(0.5 of 4);
    @include r('margin-bottom', 22px);
    .avatar-base {
      height: 0;
      width: 100%;
      padding-top: 100%;
      position: relative;
      overflow: hidden;
      &:after {
        content: ' ';
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 100%;
        background: $black;
        position: absolute;
        z-index: 0;
      }
    }
    .eyes-list {
      position: absolute;
      width: 1400%;
      top: 0;
      left: 0;
      display: flex;
      justify-content: space-around;
      z-index: 1;
      @include transition('left');
      .single-eye {
        width: 7.1428%;
        img {
          width: 100%;
          max-width: none;
        }
      }
    }
    .mouth-list {
      position: absolute;
      width: 1000%;
      top: 0;
      left: 0;
      display: flex;
      justify-content: space-around;
      z-index: 1;
      @include transition('left');
      .single-mouth {
        width: 10%;
        img {
          width: 100%;
          max-width: none;
        }
      }
    }
  }
  .actions {
    display: flex;
    .left, .right {
      @include col(1 of 4, 0);
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      .btn {
        @include r('margin-bottom', 6px);
      }
      &.right {
        justify-content: flex-end;
        align-items: flex-end;
      }
    }
    .center {
      @include col(2 of 4);
      display: flex;
      flex-direction: column;
      .btn {
        @include r('margin', 0 3px);
        &.active {
          pointer-events: none;
        }
      }
      .eyes, .mouth {
        display: flex;
        justify-content: center;
        @include r('margin-bottom', 6px);
      }
    }
  }
}
</style>
