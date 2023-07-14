<template>
    <div class="player-container pt-9" :style="{padding: animateState !== 'bigger' ? '0px 5px' : ''}">

      <!--progress area-->
      <div v-show="props.animateState === 'bigger'" class="flex-col px-4 operation-container">
        <div ref="progressBox" class="progress" @click="seek">
          <div class="progress-back">
              <div ref="progress" class="progress-front" />
            </div>
          </div>
          <div class="flex justify-between">
              <div ref="track" class="mt-1 text-sm track text-virtual-blue">0:00</div>

              <div ref="duration" class="mt-1 text-sm duration text-virtual-blue">{{ songInfo.duration }}</div>
          </div>
        </div>
      <!--control area-->
      <div v-if="props.animateState === 'bigger'" class="control-container">
        <div class="grid w-1/2 grid-cols-3 mx-auto mt-5">
            <div></div>
            <!-- <BackwardIcon class="w-8 h-8 text-virtual-blue place-self-center" @click="previous" /> -->
            <div class="flex w-3/4 p-3 mx-auto rounded-full bg-virtual-blue">
                <PlayIcon class="w-full h-full text-white" v-if="playState"  @click="toggle" />
                <PauseIcon class="w-full h-full text-white" v-else @click="toggle" />
            </div>
            <div></div>
            <!-- <ForwardIcon class="w-8 h-8 text-virtual-blue place-self-center" @click="next" /> -->
        </div>
      </div>
    </div>
  </template>

  <script setup>

  import Player from '@/components/AuPlay/Player/player.js'
  import anime from 'animejs'
  import { nextTick, onMounted, reactive, ref, watch } from 'vue'

  import {
    ForwardIcon,
    PlayIcon,
    PauseIcon,
    BackwardIcon
} from '@heroicons/vue/24/solid'

  import pinia from '@/store/store.js'

  import { storeToRefs } from 'pinia'

  import { usePlayerStore } from '@/store/playerState.js'

  const store = usePlayerStore(pinia)
  const { soundState } = storeToRefs(store)
  const props = defineProps({
    animateState: {
      type: String,
      default: 'bigger'
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


  const playState = ref(true)
  const playerInst = ref()
  const track = ref()
  const progress = ref()
  const duration = ref()
  const progressBox = ref()


  const songInfo = reactive({
    duration: '0:00',
  })
  onMounted(async () => {
    // heroicons
    ForwardIcon,
    PlayIcon,
    PauseIcon,
    BackwardIcon
    await nextTick()
    initPlayer()
  })

  // watch the dynamic player animation state
  watch(
    () => props.animateState,
    async (newval) => {
      // await initWave()
      if (newval === 'bigger') {
        bigger()
      }
    })
  function play () {
    playerInst.value.play()
  }

  function initPlayer () {
    // target dom
    playerInst.value = new Player(props.playList, track.value, progress.value, duration.value, props.html5)
    playerInst.value.volume(props.volume)

  }
  function stop () {
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
        console.log(res);
        songInfo.duration = res.duration
        emit('next')
    })
    playState.value = false
  }
  function previous () {
    playerInst.value.skip('prev').then(res => {
        console.log(res);
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
    }
    .operation-container {
      display: flex;
      font-size: 8px;
      color: #b2b2b2;
      font-weight: 600;
      justify-content: space-around;
      margin-top: 8px;
      position: relative;
    //   bottom: 0;
    //   left: 50%;
    //   transform: translateX(-50%);
      .progress {
        width: 100%;
        display: flex;
        align-items: center;
        margin: 0;
        .progress-back {
          width: 100%;
          height: 15px;
          border-radius: 3px;
          background: white;
          .progress-front {
            width: 0%;
            height: 100%;
            border-radius: 3px;
            background: #0019DA;
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
      position: relative;
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
        // width: 32px;
        // height: 32px;
        // padding: 1.3rem;
        // background-color: #0019DA;
      }
      .pause {
        background: url("../../../../../public/images/ios-pause.svg");
        background-size: contain;
      }
    }
  }
  </style>
