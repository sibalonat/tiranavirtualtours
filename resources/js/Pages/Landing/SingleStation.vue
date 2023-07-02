<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, reactive, ref, watch } from '@vue/runtime-core';

// comp for author and teaser
import TeaserComponent from "@/Components/TeaserComponent.vue";
import AuthorComponent from '@/Components/AuthorComponent.vue';

// AR
import AugmentFBX from "@/Components/AugmentState.vue";

// audio
import { DynamicIslandPlayer } from '@/Components/AuPlay/index.js'

// video
import V3dPlayer from 'v3d-player'
import 'v3d-player/dist/style.css'

import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';

// media queries
import { breakpointsTailwind, useBreakpoints } from '@vueuse/core'

// heroicons
import {
    FlagIcon,
    XMarkIcon,
    InformationCircleIcon,
    SpeakerWaveIcon,
    ChevronRightIcon,
    ChevronLeftIcon,
    PhotoIcon,
    FilmIcon,
    CubeTransparentIcon,
    PlayCircleIcon
} from '@heroicons/vue/24/outline'

// variables
let lang = ref('AL')
let visibleRef = ref(false)
let video = ref(false)
let gallery = ref(false)

let vid = ref(null)
let pic = ref(null)
let switchMedia = ref(null)
let player = ref(null)

const compChange = ref(0)
const compChangeAuthorTeaser = ref('')

let imgsFORgallery = ref([])

const playList = ref([])

const options = reactive({
    autoplay: true,
    muted: true,
    screenshot: true,
    preventClickToggle: true,
    theme: '#FF3366',
    volume: 0.9,
    src: ''
})

// type check media collection
const gl = ref(false)
const vd = ref(false)
const ad = ref(false)
const ar = ref(false)

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

/////--- ar button ///

const textForHiddingAndShowing = ref(true)

const threeDObject = ref(null)

let root = route('welcome');

/////--- media query types ///
const breakpoints = useBreakpoints(breakpointsTailwind)
// const smAndLarger = breakpoints.greaterOrEqual('sm')
const smAndLarger = breakpoints.smaller('sm')

const prop = defineProps({
    station: Object,
    tour: Object,
    featured: Object,
    media_collection: Array,
    thread: Object,
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
        switchMedia.value = val
    }
})


// methods
const showVideo = () => {
    let thingvid = prop.media_collection.filter(v => v[0].mime_type === 'video/mp4')

    let flated = thingvid[0].flat()

    options.src = flated[0].original_url

    video.value = true

    visibleRef.value = true
}


const showImg = () => {
    imgsFORgallery = prop.media_collection.filter(v => v[0].mime_type !== 'video/mp4' && v[0].mime_type !== 'audio/mpeg')
    gallery.value = true

    visibleRef.value = true
}

const onHide = () => {
    visibleRef.value = false
    video.value = false
    gallery.value = false
}

const onSlideChange = () => {
    console.log('slidechange');
}

const onSwiper = (swiper) => {
    console.log(swiper);
};

const changeComponent = (el) => {
    if (el === 'Rreth Stacionit' || el === 'The station') {
        compChange.value = 1
        compChangeAuthorTeaser.value = 'teaser'
    } else {
        compChange.value = 1
        compChangeAuthorTeaser.value = 'author'
    }
}

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

///--- ar methods
const arTrigger = () => {
    if (!!ar.value) {
        textForHiddingAndShowing.value === true
            ? textForHiddingAndShowing.value = false
            : textForHiddingAndShowing.value = true;
    }
}

const changeDisplayFromARToStation = (e) => {
    if (e[1] === 2) {
        textForHiddingAndShowing.value = e
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
        } else { return }
    })

    // console.log(prop.thread);


    if (prop.thread.length) {
        console.log(prop.thread);
        prop.thread.forEach((el) => {
            if (el[3] === 'application/octet-stream' || el[3] === 'application/json') {
                ar.value = true
                threeDObject.value = el[0].original_url
            }
        })
    }
}

onMounted(() => {
    BreezeAuthenticatedLayout, Head, Link, V3dPlayer, Swiper, SwiperSlide, AugmentFBX
    FlagIcon, InformationCircleIcon, SpeakerWaveIcon, ChevronLeftIcon, PhotoIcon, FilmIcon, CubeTransparentIcon, XMarkIcon, PlayCircleIcon

    lang, visibleRef, options, playList, gallery, imgsFORgallery, player, root
    // computed
    languageChange, changeTypeOfMedia
    //methods
    showImg, onHide, showVideo, onSlideChange, onSwiper, play, arTrigger, changeDisplayFromARToStation


    //video
    let thingvid = prop.media_collection.filter(v => v[0].mime_type === 'video/mp4')

    if (thingvid.length) {
        let flated = thingvid[0].flat()

        vid.value = flated[1]
    }


    // screen sizes
    // console.log(navigator.userAgent);

    // check mime_type
    checkMediaTypes()

    // console.log(threeDObject.value);

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
        let thingaudio = prop.media_collection.filter(v => v[0].mime_type === 'audio/mpeg')
        let flattaudio = thingaudio[0].flat()

        playList.value.push({
            file: flattaudio[0].original_url,
            howl: null,
        })
        console.log(player.value);
    }
}, {
    flush: 'post'
})


</script>

<template>
    <Head title="Station" />
    <div class="relative h-screen max-w-full mx-auto overflow-hidden"
    :class="!textForHiddingAndShowing ? 'bg-transparent' : 'bg-gray-circles'">
        <div class="flex flex-col justify-center" v-if="textForHiddingAndShowing">
            <div class="text-white bg-virtual-blue ">
                <Link class="w-full no-underline" :href="route('landing.tourone', prop.tour.slug)">
                <div class="grid content-center grid-cols-5">
                    <div class="mx-auto my-auto">
                        <ChevronLeftIcon class="inline-block w-7 h-7 -mt-2 -mr-0.5 text-white stroke-2">
                        </ChevronLeftIcon>
                    </div>
                    <p
                        class="inline-block col-span-4 py-8 my-auto mb-0 text-2xl font-semibold leading-none align-text-bottom text-start">
                        {{ prop.tour.title }}
                    </p>
                </div>
                </Link>
            </div>
            <div class="flex flex-col justify-end py-0 space-y-2">
                <div class="mt-5 grow">
                    <div class="grid w-11/12 grid-cols-5 mx-auto gap-x-2 ">
                        <img :src="adiconcl" v-if="!ad" alt="audio" class="cursor-pointer">
                        <img v-else :src="changeTypeOfMedia === 'audio' ? adiconcl : adicon" alt="audio" @click="!!ad ? ([
                                changeTypeOfMedia = 'audio'
                            ]) : ''" class="cursor-pointer">
                        <img v-if="!gl" :src="gliconcl" alt="gallery" class="cursor-pointer">
                        <img v-else :src="changeTypeOfMedia === 'gallery' ? gliconcl : glicon" alt="gallery" @click="!!gl ? ([
                                changeTypeOfMedia = 'gallery',
                            ]) : ''" class="cursor-pointer">
                        <img v-if="!vd" :src="vdiconcl" alt="video" class="cursor-pointer">
                        <img v-else
                        :disabled="vd"
                        :src="changeTypeOfMedia === 'video' ? vdiconcl : vdicon"
                        alt="video"
                        @click="!!vd ? ([
                                    changeTypeOfMedia = 'video',
                                ]) : ''" class="cursor-pointer">
                        <img v-if="!ar" :src="ariconcl" alt="ar" class="cursor-pointer">
                        <img :disabled="ar" v-else :src="!!ar ? aricon : ariconcl" alt="ar" @click="arTrigger"
                            class="cursor-pointer">
                        <img :src="languageChange === 'AL' ? albutt : enbutt"
                            @click="languageChange === 'AL' ? languageChange = 'EN' : languageChange = 'AL'">
                    </div>
                    <div class="flex flex-col mt-5">
                        <p class="px-5 my-auto mb-3 text-xl font-light text-start text-virtual-blue">
                            {{ languageChange === 'AL' ? 'Stacioni' : 'Station' }}
                        </p>
                        <p class="px-5 my-auto text-3xl font-semibold uppercase text-start text-virtual-blue">
                            {{ prop.station.title }}
                        </p>
                    </div>
                    <div class="flex flex-col mt-2 mb-2">
                        <img :src="prop.featured.original_url" class="object-cover object-center w-full imageHeight" alt=""
                            v-if="(changeTypeOfMedia === null)">
                        <div class="mix-blend-multiply py-9 bg-gray-circles" v-else-if="(changeTypeOfMedia === 'audio')">
                            <DynamicIslandPlayer ref="player" :play-list="playList" :volume="0.8" :html5="true" @play="play"
                                @next="next" @pause="pause" @previous="previous" @animation-big="test" />
                        </div>
                        <div class="relative" v-else-if="(changeTypeOfMedia === 'gallery')">
                            <p class="absolute w-full text-center text-white underline h-14 top-2/4" @click="showImg"
                                :class="compChange === 1 ? '' : 'z-50'">
                                {{ languageChange === 'AL' ? 'Hap galerinë' : 'See Gallery' }}
                            </p>
                            <div class="absolute w-full h-48 bg-black opacity-50">
                            </div>
                            <img :src="pic" class="object-cover object-center w-full h-48" alt="">
                        </div>
                        <div class="relative" v-else-if="(changeTypeOfMedia === 'video')">
                            <PlayCircleIcon class="absolute w-20 h-20 text-white stroke-1 inset-x-4/4 inset-y-1/3"
                                @click="showVideo" :class="compChange === 1 ? '' : 'z-50'" />

                            <div class="absolute w-full h-48 bg-black opacity-50">
                            </div>
                            <img :src="vid" class="object-cover object-center w-full h-48" alt="">
                        </div>
                    </div>
                </div>
                <div class="flex flex-col pl-7" :class="compChange === 1 ? 'absolute top-0 bg-gray-circles' : ''">
                    <div class="w-97">
                        <button class="grid w-full grid-cols-3 gap-6 mb-4 cursor-pointer" v-if="compChange !== 1"
                            @click="changeComponent(languageChange === 'AL' ? 'Rreth Stacionit' : 'The station')">
                            <p class="col-span-2 pb-0 font-semibold text-title text-start text-virtual-blue">
                                {{ languageChange === 'AL' ? 'Rreth Stacionit' : 'The Station' }}
                            </p>
                            <ChevronRightIcon class="inline-block w-4 h-4 mx-auto my-auto stroke-2 text-virtual-blue" />
                        </button>
                        <button class="grid w-full grid-cols-3 gap-6 cursor-pointer"
                        v-if="compChange !== 1 && prop.station.author_en.length > 50"
                            @click="changeComponent">
                            <p class="col-span-2 pt-0 font-semibold text-title text-start text-virtual-blue"
                                v-if="compChange !== 1">
                                {{ languageChange === 'AL' ? 'Rreth Artistit' : 'The Artist' }}
                            </p>
                            <ChevronRightIcon class="inline-block w-4 h-4 mx-auto my-auto stroke-2 text-virtual-blue" />
                        </button>
                        <component :language-change="languageChange" v-if="compChange === 1" v-model:compChange="compChange"
                            :teaser-al="prop.station.teaser_al" :teaser-en="prop.station.teaser_en"
                            :author-en="prop.station.author_en" :smAndLarger="smAndLarger"
                            :author-al="prop.station.author_al"
                            :is="compChangeAuthorTeaser === 'teaser' ? TeaserComponent : AuthorComponent" />
                    </div>
                </div>
            </div>
        </div>

        <!-- // ketu ar -->
        <AugmentFBX :buttonCondition="textForHiddingAndShowing" :threeD="threeDObject"
            @condition-display="changeDisplayFromARToStation" v-else />

    </div>
    <div class="fixed inset-y-0 left-0 z-50 flex w-screen h-screen space-x-0 demo-player" ref="target" v-if="visibleRef">
        <div class="flex-col w-full my-auto">
            <div class="grid content-center grid-cols-3 my-auto justify-items-center">
                <div class="col-span-2"></div>
                <div class="pb-2 ml-auto mr-2">
                    <XMarkIcon class="text-white w-7 h-7" @click="onHide"> </XMarkIcon>
                </div>
            </div>
            <div class="w-11/12 m-auto" v-if="video">
                <v3d-player ref="playerRef" class="w-11/12 h-auto my-auto" :options="options" />
            </div>
            <div class="w-11/12 m-auto" v-else>
                <swiper :slides-per-view="1.5" :space-between="20" :slidesPerColumn="2" @swiper="onSwiper"
                    @slideChange="onSlideChange" class="max-h-120">
                    <swiper-slide v-for="image in imgsFORgallery" :key="image" class="h-full custom-slide">
                        <img :src="image[0].original_url" class="object-cover w-full h-full">
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

.imageHeight {
    height: 192px !important;
}

.heightContain {
    max-height: 18rem;
}

.custom-slide {
    height: 170px; /* adjust this value according to your needs */
}

.custom-slide img {
    object-fit: cover;
}
</style>>


