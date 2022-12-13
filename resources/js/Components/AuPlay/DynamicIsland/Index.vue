<template>
    <div>
      <div ref="dynamic" class="dynamic-island" @click="start">
        <div />
        <Player
          v-if="playList.length"
          ref="player"
          :animate-state="animationState"
          :play-list="playList"
          :volume="volume"
          :html5="html5"
          @play="play"
          @pause="pause"
          @next="next"
          @previous="previous"
        />
      </div>
    </div>
  </template>
  <script setup>
  import { nextTick, onMounted, ref } from 'vue'
  import anime from 'animejs'
  import Player from '@/components/AuPlay/Player/index.vue'
  const dynamic = ref()
//   const animationState = ref('smaller')
  const animationState = ref('longer')
  const timer = ref(null)
  const count = ref(0)
  const props = defineProps({
    playList: {
      type: Array,
      default: () => []
    },
    volume: {
      type: Number,
      default: 0.5
    },
    html5: {
      type: Boolean,
      default: true
    },
    theme: {
      type: String,
      default: ''
    }
  })

  const emit = defineEmits(['play', 'pause', 'next', 'previous', 'animationBig', 'animationLong'])
  onMounted(async () => {
    await nextTick()
  })
  function start () {
    clearInterval(timer.value)
    isClick()
    animeBig()

    // if (animationState.value === 'bigger') {
    //     animeBig()
    // } else if (animationState.value === 'bigger') {
    //     animeLong()
    // }
  }


  function animeBig () {
    /** @description event dynamic island translate bigger */

    emit('animationBig')
    anime({
      targets: '.dynamic-island',
      keyframes: [
        { width: '100vw', height: '20vh', duration: 160 },
        { scaleX: 1.04, duration: 160 },
        { scaleX: 1, duration: 160 }
      ],
      easing: 'easeInOutSine',
      complete: function () {
        animationState.value = 'bigger'
      }
    })
  }

  function isClick () {
    count.value = 10
    timer.value = setInterval(() => {
      count.value
      if (count.value <= 0) {
        animeBig()
        clearInterval(timer.value)
      }
    }, 1000)
  }

  const player = ref()
  /** *** @description expose  internal methods ******/

  function getSoundState () {
    console.log('what');
    return player.value.getState()
  }
  function setVolume (val) {
    player.value.setVolume(val)
  }
  function setMute (val) {
    player.value.setMute(val)
  }
  function setRate (val) {
    player.value.setRate(val)
  }
  function seekBySeconds (val) {
    player.value.seekBySeconds(val)
  }
  function toggle () {
    player.value.toggle()
  }
  function playNext () {
    player.value.next()
  }
  function playPrevious () {
    player.value.previous()
  }
  /** *** @description event emit ******/

  function play () {
    /** @description event sound play */
    console.log('does it play');
    emit('play')
  }
  function pause () {
    /** @description event sound pause */
    emit('pause')
  }
  function next () {
    /** @description event next */
    emit('next')
  }
  function previous () {
    /** @description event  previous */
    emit('previous')
  }
  defineExpose({
    getSoundState,
    setVolume,
    setMute,
    setRate,
    seekBySeconds,
    toggle,
    playNext,
    playPrevious
  })

  onMounted(() => {
    animeBig()
  })

  </script>
  <style lang="scss" scoped>
  * {
    margin: 0;
    padding: 0;
  }
  .dynamic-island {
    background-color: transparent;
  }
  .bigger::after {
    display: none;
  }
  </style>
