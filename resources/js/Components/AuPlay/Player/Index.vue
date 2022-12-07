<template>
    <div class="player-container" :style="{padding: animateState !== 'bigger' ? '0px 5px' : ''}">
      <!--song info area-->
      <div ref="infoBox" class="info-container">
        <!-- <div ref="coverBox" class="small-cover-container" :style="{marginRight: props.animateState !== 'bigger' ? 0 : '12px'}"> -->
        <div ref="coverBox" class="small-cover-container" :style="{marginRight: props.animateState !== 'bigger' ? '12px' : '12px'}">
          <img ref="coverRef" :src="songInfo.cover" alt="">
        </div>
        <div ref="titleBox" class="title-container">
          <p class="title-style" :style="titleStyle()">{{ songInfo.title }}</p>
        </div>
        <div v-show="props.animateState !== 'smaller'" ref="waveRef" class="wave-container" />
      </div>
      <!--progress area-->
      <div v-show="props.animateState === 'bigger'" class="operation-container">
        <div ref="track" class="track">0:00</div>
        <div ref="progressBox" class="progress" @click="seek">
          <div class="progress-back">
            <div ref="progress" class="progress-front" />
          </div>
        </div>
        <div ref="duration" class="duration">{{ songInfo.duration }}</div>
      </div>
      <!--control area-->
      <div v-if="props.animateState === 'bigger'" class="control-container">
        <div class="previous btn" @click="previous" />
        <div v-if="playState" class="play btn" @click="toggle" />
        <div v-else class="pause btn" @click="toggle" />
        <div class="next btn" style="margin-right: 0" @click="next" />
      </div>
    </div>
  </template>

  <script setup>
  import SiriWave from 'siriwave'
  import Player from '@/components/AuPlay/Player/player.js'
  import anime from 'animejs'
  import { nextTick, onMounted, reactive, ref, watch } from 'vue'

  import pinia from '@/store/store.js'

  import { storeToRefs } from 'pinia'

  import { usePlayerStore } from '@/store/playerState.js'

  const store = usePlayerStore(pinia)
  const { title, cover, soundState } = storeToRefs(store)
  const props = defineProps({
    animateState: {
      type: String,
      default: 'longer'
    },
    // song list
    playList: {
      type: Array,
      default: () => []
    },
    // The volume of the specific track, from 0.0 to 1.0.
    volume: {
      type: Number,
      default: 0.5
    },
    // Set to true to force HTML5 Audio
    html5: {
      type: Boolean,
      default: true
    }
  })
  const emit = defineEmits(['play', 'pause', 'previous', 'next'])

  const coverRef = ref()
  const playState = ref(true)
  const playerInst = ref()
  const track = ref()
  const progress = ref()
  const duration = ref()
  const progressBox = ref()
  const titleBox = ref()
  const coverBox = ref()
  const infoBox = ref()
  const songInfo = reactive({
    title: props.playList[0].title,
    duration: '0:00',
    cover: props.playList[0].cover
  })
  onMounted(async () => {
    await nextTick()
    initPlayer()
    coverAnimate()
  })
  // auto toggle next song
  watch(title, (newValue, oldValue) => {
    songInfo.title = title.value
    songInfo.cover = cover.value
  })

  // watch the dynamic player animation state
  watch(
    () => props.animateState,
    async (newval) => {
      // await initWave()
      if (newval === 'bigger') {
        bigger()
        if (coverAnimation.value) stopCoverAnimate()
      }
    //   if (newval === 'smaller') {
    //     smaller()
    //     coverAnimate()
    //     if (soundState.value === 'playing') {
    //       coverAnimation.value.play()
    //     }
    //   }
    })
  function play () {
    if (props.animateState === 'longer' && coverAnimation.value !== null) {
      coverAnimation.value.play()
    }
    playerInst.value.play().then(res => {
      songInfo.title = res.title
      songInfo.cover = res.cover
      coverAnimate()
      /* if (props.animateState === 'smaller') {
        console.log(223344)
        coverAnimate()
      } */
    })
  }
  function initPlayer () {
    // target dom
    playerInst.value = new Player(props.playList, track.value, progress.value, duration.value, props.html5)
    playerInst.value.volume(props.volume)

  }
  function stop () {
    if (props.animateState === 'longer') {
      coverAnimation.value.pause()
    }
    playerInst.value.pause()
  }


  function toggle () {
    if (playState.value) {

      play()
      emit('play')
    } else {

      stop()
      emit('pause')
    }
    playState.value = !playState.value
  }
  function next () {
    playerInst.value.skip('next').then(res => {
      songInfo.title = res.title
      songInfo.cover = res.cover
      songInfo.duration = res.duration
      emit('next')

    })
    playState.value = false
  }
  function previous () {
    playerInst.value.skip('prev').then(res => {
      songInfo.title = res.title
      songInfo.cover = res.cover
      songInfo.duration = res.duration
      emit('previous')

    })
    playState.value = false
  }
  function seek (event) {
    playerInst.value.seek(event.offsetX / progressBox.value.clientWidth)
  }
  // when island is bigger
  function bigger () {
    const text = titleBox.value
    text.classList.add('animateText')
    anime({
      targets: coverBox.value,
      width: [
        { value: 60, duration: 200, easing: 'easeInSine' }
      ],
      height: [
        { value: 60, duration: 200, easing: 'easeInSine' }
      ],
      top: [
        { value: 0, duration: 200, easing: 'easeInSine' }
      ],
      easing: 'linear',
      duration: 200
    })
    anime({
      targets: infoBox.value,
      height: [
        { value: 65, duration: 200, easing: 'easeInSine' }
      ],
      easing: 'linear',
      duration: 200
    })
    anime({
      targets: coverRef.value,
      borderRadius: [
        { value: 10, duration: 200, easing: 'easeInSine' }
      ],
      easing: 'linear',
      duration: 200
    })
  }

  function titleStyle () {
    return {
      fontSize: props.animateState !== 'bigger' ? '13px' : '',
      width: props.animateState !== 'bigger' ? '140px' : '145px',
      textAlign: props.animateState !== 'bigger' ? 'center' : 'left'
    }
  }
  const coverAnimation = ref(null)
  function coverAnimate () {
    coverAnimation.value = anime({
      targets: coverBox.value,
      rotate: {
        value: 360,
        duration: 2000,
        easing: 'linear'
      },
      loop: true,
      autoplay: false,
      easing: 'linear',
      duration: 200
    })
  }
  function stopCoverAnimate () {
    anime.set(coverBox.value, { rotate: 0 })
    coverAnimation.value.remove(coverBox.value)
  }

  function getState () {
    return soundState.value
  }
  function setVolume (val) {
    playerInst.value.volume(val)
  }
  function setMute (val) {
    playerInst.value.mute(val)
  }
  function setRate (val) {
    playerInst.value.rate(val)
  }
  function seekBySeconds (val) {
    playerInst.value.seekBySeconds(val)
  }
  defineExpose({
    /** @description get sound state */
    getState,
    /** @description set sound volume */
    setVolume,
    /** @description set sound mute */
    setMute,
    /** @description set rate of playback */
    setRate,
    /** @description skip to the song by seconds */
    seekBySeconds,
    /** @description play or pause the song */
    toggle,
    /** @description toggle next the song */
    next,
    /** @description toggle previous the song */
    previous
  })
  </script>

  <style lang="scss" scoped>
  @keyframes messageFilter {
    0% {
      transform: scale(0);
      transform: translateY(-10px);
      filter: blur(2px);
    }
    100% {
      transform: scale(1);
      transform: translateY(0px);
    }
  }
  .animateText {
    animation: messageFilter 300ms linear;

  }
  .player-container {
    font-size: 16px;
    color: #ffffff;
    padding: 16px;
    .info-container {
      display: flex;
      align-items: center;
      justify-content: space-around;
      position: relative;
      height: 45px;
      .cover-container {
        //width: rem(60);
        //height: rem(60);
        margin-right: 16px;
        img {
          border-radius: 10px;
          width: 100%;
        }
      }
      .small-cover-container {
        width: 25px;
        height: 25px;
        position: absolute;
        left: 5px;
        top: 12px;
        img {
          border-radius: 30px;
          width: 100%;
        }
      }
      .title-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: fixed;
        p {
          margin: 0;
        }
        .song-style {
          width: 140px;
          color: #b2b2b2;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
          font-weight: 500;
        }
        .title-style {
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
        }
      }

      .small-wave-container {
        width: 30px;
        height: 30px;
        border-radius: 30px;
      }
    }
    .operation-container {
      display: flex;
      font-size: 8px;
      color: #b2b2b2;
      font-weight: 600;
      justify-content: space-around;
      margin-top: 8px;
      position: fixed;
      bottom: 50px;
      left: 50%;
      transform: translateX(-50%);
      .progress {
        width: 200px;
        display: flex;
        align-items: center;
        margin: 0 10px;
        .progress-back {
          width: 100%;
          height: 5px;
          border-radius: 3px;
          background: rgba(178, 178, 178, 0.34);
          .progress-front {
            width: 0%;
            height: 100%;
            border-radius: 3px;
            background: #ffffff;
          }
        }
      }
      .duration {
        width: 25px;
      }
    }
    .control-container {
      display: flex;
      justify-content: center;
      margin-top: 8px;
      position: fixed;
      bottom: 15px;
      left: 50%;
      transform: translateX(-50%);
      .btn {
        width: 32px;
        height: 32px;
        margin-right: 32px;
      }
      .previous {
        background: url("../../../../../public/images/ios-rewind.svg");
        // background: url("../../images/ios-rewind.svg");
        background-size: contain;
      }
      .next {
        background: url("../../../../../public/images/ios-fastforward.svg");
        background-size: contain;
      }
      .play {
        background: url("../../../../../public/images/ios-play.svg");
        background-size: contain;
      }
      .pause {
        background: url("../../../../../public/images/ios-pause.svg");
        background-size: contain;
      }
    }
  }
  </style>
