<script setup>
// import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { computed, onBeforeMount, onMounted, reactive, ref, watch } from '@vue/runtime-core';

// comp for author and teaser
import TeaserComponent from "@/Components/TeaserComponent.vue";
import AuthorComponent from '@/Components/AuthorComponent.vue';


// audio
import { DynamicIslandPlayer } from '@/Components/AuPlay/index.js'

// video
import V3dPlayer from 'v3d-player'
import 'v3d-player/dist/style.css'

import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';

// media queries
import { breakpointsTailwind, useBreakpoints } from '@vueuse/core'

// arrow-uturn-left
// heroicons
import {
    FlagIcon,
    ArrowUturnLeftIcon,
    XMarkIcon,
    InformationCircleIcon,
    SpeakerWaveIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
    PhotoIcon,
    FilmIcon,
    CubeTransparentIcon,
    PlayCircleIcon
} from '@heroicons/vue/24/outline'

// data from the server

// variables
let lang = ref('AL')
let visibleRef = ref(false)
let video = ref(false)
let gallery = ref(false)

let vid = ref(null)
let pic = ref(null)
let switchMedia = ref(null)
let player = ref(null)

let imgsFORgallery = ref([])

const playList = ref([])

const compChange = ref(0)
const compChangeAuthorTeaser = ref('')
// compChange, compChangeAuthorTeaser

const options = reactive({
    autoplay: true,
    muted: true,
    screenshot: true,
    preventClickToggle: true,
    theme: '#FF3366',
    volume: 0.9,
    src: ''
})


/////--- ar button ///

const textForHiddingAndShowing = ref(true)

let root = route('welcome');

/////--- media query types ///
const breakpoints = useBreakpoints(breakpointsTailwind)
// const smAndLarger = breakpoints.greaterOrEqual('sm')
const smAndLarger = breakpoints.smaller('sm')

// type check media collection
const gl = ref(false)
const vd = ref(false)
const ad = ref(false)

const glicon = ref('/images/gallerybutt.svg')
const vdicon = ref('/images/videobutt.svg')
const adicon = ref('/images/audiobutt.svg')
const aricon = ref('/images/arbutt.svg')
const gliconcl = ref('/images/gallerybuttclck.svg')
const vdiconcl = ref('/images/videobuttclck.svg')
const adiconcl = ref('/images/audiobuttclck.svg')
const ariconcl = ref('/images/arbuttclck.svg')
const enbutt = ref('/images/enbutt.svg')
const albutt = ref('/images/albutt.svg')

const emit = defineEmits(['visible'])

const prop = defineProps({
    station: Object,
    tour: Object,
    featured: Object,
    media_collection: Array,
    thread: Object,
    stationProp: Boolean,
})

// computed
const languageChange = computed({
    get() {
        return lang.value
    },
    set(val) {
        lang.value = val
    }
})

const changeTypeOfMedia = computed({
    get() {
        return switchMedia.value
    },
    set(val) {
        switch (val) {
            case 'video':
                switchMedia.value = val
                showVideo()
                break;
            case 'audio':
                switchMedia.value = val

                break;
            case 'gallery':
                switchMedia.value = val
                showImg()
                break;
            default:
                break;
        }
    }
})


// methods
const showVideo = () => {
    let thingvid = prop.media_collection.filter(v => v[0].mime_type === 'video/mp4')

    let flated = thingvid[0].flat()

    options.src = flated[0].original_url

    video.value = true

    visibleRef.value = true

    emit('visible', visibleRef.value)
}


const showImg = () => {
    imgsFORgallery = prop.media_collection.filter(v => v[0].mime_type !== 'video/mp4' && v[0].mime_type !== 'audio/mpeg')


    gallery.value = true

    visibleRef.value = true
    emit('visible', visibleRef.value)
}

const onHide = () => {
    visibleRef.value = false
    emit('visible', visibleRef.value)
    video.value = false
    gallery.value = false
}

const onSlideChange = () => {
    console.log('slidechange');
}

const onSwiper = (swiper) => {
    console.log(swiper);
};

// audio player
function test() {
    console.log('233223')
}
function play() {
    console.log('play')
}
function next() {
    console.log('next')
}
function previous() {
    console.log('previous')
}
function pause() {
    console.log('pause')
}
function set() {
    player.value.setVolume(0.9)
}
function setMute() {
    player.value.setMute(true)
}
function setRate() {
    player.value.setRate(2.0)
}
function setSound() {
    player.value.setMute(false)
}
function seekTo() {
    player.value.seekBySeconds(30)
}
function toggle() {
    player.value.toggle()
}
function playNext() {
    player.value.playNext()
}
function playPrevious() {
    player.value.playPrevious()
}
function getState() {
    console.log(player.value.getSoundState())
}

// change component author & teaser
const changeComponent = (el) => {

    if (el === 'Rreth Stacionit' || el === 'The Station') {
        compChange.value = 1
        compChangeAuthorTeaser.value = 'teaser'
    } else {
        compChange.value = 1
        compChangeAuthorTeaser.value = 'author'
    }
}

const checkMediaTypes = () => {
    prop.media_collection.forEach((el) => {
        if (el[3] === "image/jpeg") {
            gl.value = true
        } else if (el[3] === "video/mp4") {
            vd.value = true
        } else if (el[3] === "audio/mpeg") {
            ad.value = true
        } else {return}
    })
}


onMounted(() => {
    Head, Link, V3dPlayer, Swiper, SwiperSlide, DynamicIslandPlayer, AuthorComponent, TeaserComponent
    FlagIcon, InformationCircleIcon, SpeakerWaveIcon, ChevronLeftIcon, PhotoIcon, FilmIcon, CubeTransparentIcon, XMarkIcon, PlayCircleIcon, ChevronRightIcon

    lang, visibleRef, options, playList, gallery, imgsFORgallery, player, root
    // computed
    languageChange, changeTypeOfMedia, compChange, compChangeAuthorTeaser
    //methods
    showImg, onHide, showVideo, onSlideChange, onSwiper, play, changeComponent

    //video
    let thingvid = prop.media_collection.filter(v => v[0].mime_type === 'video/mp4')

    if (thingvid.length) {
        let flated = thingvid[0].flat()

        vid.value = flated[1]
    }


    // screen sizes
    // console.log(navigator.userAgent);

    checkMediaTypes()

    // console.log(prop.station);

    // check screen size
    // console.log(smAndLarger.value);


    //pic
    let thingpic = prop.media_collection.filter(v => v[0].mime_type !== 'video/mp4' && v[0].mime_type !== 'audio/mpeg')
    if (thingpic.length) {
        let flatpic = thingpic[0].flat()

        pic.value = flatpic[1]
    }

})


// [player, barRef], ([val, bar], [prevFoo, prevBar])
watch(player, (val) => {
    if (val != null) {
        console.log('now then');
        let thingaudio = prop.media_collection.filter(v => v[0].mime_type === 'audio/mpeg')
        let flattaudio = thingaudio[0].flat()

        playList.value.push({
            file: flattaudio[0].original_url,
            howl: null,
        })
    }
}, {
    flush: 'post'
})

</script>

<template>
    <div class="relative h-full max-w-full mx-auto overflow-hidden mt-28 bg-gray-circles">
        <div class="flex flex-col justify-center" v-if="textForHiddingAndShowing">
            <div class="flex flex-col justify-end py-0 space-y-4">
                <div class="mb-10 mt-7 grow">
                    <div class="grid w-full grid-cols-5 pl-8 mx-auto justify-items-center gap-x-5">
                        <img :src="adiconcl" v-if="!ad" alt="audio" class="w-full cursor-pointer">
                        <img v-else :src="changeTypeOfMedia === 'audio' ? adiconcl : adicon" alt="audio"
                         @click="!!ad ? ([
                            changeTypeOfMedia = 'audio'
                        ]) : ''" class="cursor-pointer">
                        <img v-if="!gl" :src="gliconcl" alt="gallery" class="cursor-pointer">
                        <img v-else :src="changeTypeOfMedia === 'gallery' ? gliconcl : glicon" alt="gallery"
                        @click="!!gl ? ([
                            changeTypeOfMedia = 'gallery',
                        ]) : ''" class="cursor-pointer">
                        <!-- audio, gallery -->
                        <img v-if="!vd" :src="vdiconcl" alt="video" class="cursor-pointer">
                        <img v-else :disabled="vd" :src="changeTypeOfMedia === 'video' ? vdiconcl : vdicon" alt="video"
                        @click="!!vd ? ([
                            changeTypeOfMedia = 'video',
                        ]) : ''" class="cursor-pointer">
                        <img :src="languageChange === 'AL' ? albutt : enbutt" @click="languageChange === 'AL' ? languageChange = 'EN' : languageChange = 'AL'">
                    </div>

                    <div class="flex flex-col mt-5">
                        <p class="relative px-8 my-auto text-xl font-light text-start text-virtual-blue">
                            {{ languageChange === 'AL' ? 'Stacioni' : 'Station' }}
                            <ArrowUturnLeftIcon class="absolute top-0 w-6 h-6 cursor-pointer right"
                            @click="$emit('update:stationProp', $event.target.value = false)" />
                        </p>
                        <p class="px-8 my-auto font-semibold uppercase text-title text-start text-virtual-blue">
                            {{ prop.station.title }}
                        </p>
                    </div>
                    <div class="flex flex-col mt-5">
                        <img :src="prop.featured.original_url" class="object-cover object-center pl-8 imageHeight max-h-56 w-90" alt=""
                            v-if="(changeTypeOfMedia === null)">
                        <div class="w-full mix-blend-multiply py-9 bg-gray-circles"
                            v-else-if="(changeTypeOfMedia === 'audio')">
                            <DynamicIslandPlayer ref="player" :play-list="playList" :volume="0.8" :html5="true"
                                @play="play" @pause="pause" @animation-big="test" />
                        </div>
                        <img :src="prop.featured.original_url"
                        v-else-if="(changeTypeOfMedia === 'gallery')"
                        class="object-cover object-center w-full imageHeight max-h-56" alt="">
                        <img :src="prop.featured.original_url" class="object-cover object-center w-full imageHeight max-h-56" alt="" v-else-if="(changeTypeOfMedia === 'video')">
                    </div>
                </div>
                <div class="flex flex-col pl-8">
                    <div class="w-90">
                        <button class="grid w-full grid-cols-3 gap-6 mb-4 cursor-pointer" v-if="compChange !== 1" @click="changeComponent(languageChange === 'AL' ? 'Rreth Stacionit' : 'The Station')">
                            <p class="col-span-2 pb-0 font-semibold text-title text-start text-virtual-blue">
                                {{ languageChange === 'AL' ? 'Rreth Stacionit' : 'The Station' }}
                            </p>
                            <ChevronRightIcon class="inline-block w-4 h-4 mx-auto my-auto stroke-2 text-virtual-blue" />
                        </button>
                        <button class="grid w-full grid-cols-3 gap-6 cursor-pointer" v-if="compChange !== 1" @click="changeComponent">
                            <p class="col-span-2 pt-0 font-semibold text-title text-start text-virtual-blue"
                                v-if="compChange !== 1">
                                {{ languageChange === 'AL' ? 'Rreth Artistit' : 'The Artist' }}
                            </p>
                            <ChevronRightIcon class="inline-block w-4 h-4 mx-auto my-auto stroke-2 text-virtual-blue" />
                        </button>
                        <component :language-change="languageChange" v-if="compChange === 1"
                            v-model:compChange="compChange" :teaser-al="prop.station.teaser_al"
                            :teaser-en="prop.station.teaser_en" :author-en="prop.station.author_en"
                            :author-al="prop.station.author_al"
                            :is="compChangeAuthorTeaser === 'teaser' ? TeaserComponent : AuthorComponent" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed inset-y-0 left-0 flex w-full h-full space-x-0 demo-player z-3" ref="target" v-if="visibleRef">
        <div class="flex-col w-full mx-auto my-auto lg:w-8/12">
            <div class="grid content-center grid-cols-3 my-auto justify-items-center">
                <div class="col-span-2"></div>
                <div class="pb-5 ml-auto mr-2">
                    <XMarkIcon class="text-white w-7 h-7" @click="onHide"> </XMarkIcon>
                </div>
            </div>
            <div class="w-11/12 m-auto lg:w-full" v-if="video">
                <v3d-player ref="playerRef" class="w-11/12 h-auto my-auto lg:w-full" :options="options" />
            </div>
            <div class="w-11/12 m-auto" v-else>
                <swiper
                :slides-per-view="1.5"
                :space-between="20"
                :slidesPerColumn="2"
                @swiper="onSwiper"
                @slideChange="onSlideChange"
                class="max-h-full">
                    <swiper-slide
                    v-for="image in imgsFORgallery"
                    :key="image"
                    lazy="true"
                    class="w-full h-full custom-slide ">
                        <img
                        :src="image[0].original_url"
                        loading="lazy"
                        class="w-full h-full">
                    </swiper-slide>
                </swiper>
            </div>
        </div>
    </div>

</template>

<style scoped>
.demo-player {
    background-color: rgba(0, 0, 0, 0.5);
}

.right {
    right: 2.75rem !important;
}

.imageHeight {
    height: 192px !important;
}

.custom-slide {
    height: 30rem; /* adjust this value according to your needs */
}

.custom-slide img {
    object-fit: contain;
}

</style>>


