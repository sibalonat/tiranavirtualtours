<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { computed, onMounted, reactive, ref, watch } from '@vue/runtime-core';

// AR
import AugmentFBX from "@/Components/AugmentState.vue";

// audio
import { DynamicIslandPlayer } from '@/Components/AuPlay/index.js'

// video
import V3dPlayer from 'v3d-player'
import 'v3d-player/dist/style.css'

import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';

// heroicons
import {
    FlagIcon,
    XMarkIcon,
    InformationCircleIcon,
    SpeakerWaveIcon,
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

/// permissions
const audioper = ref(null)
const camper = ref(null)
const locper = ref(null)
const arper = ref(null)

/////--- ar button ///

const textForHiddingAndShowing = ref(true)

let root = route('welcome');

const prop = defineProps({
    station: Object,
    tour: Object,
    featured: Object,
    media_collection: Array
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
    textForHiddingAndShowing.value === true
    ? textForHiddingAndShowing.value = false
    : textForHiddingAndShowing.value = true;
}

const changeDisplayFromARToStation = (e) => {
    if (e[1] === 2) {
        textForHiddingAndShowing.value = e
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

    let flated = thingvid[0].flat()

    vid.value = flated[1]

    // screen sizes
    console.log(navigator.userAgent);

    console.log(prop.station);


    audioper.value = usePage().props.value.permissions.audio
    camper.value = usePage().props.value.permissions.camera
    locper.value = usePage().props.value.permissions.location
    arper.value = usePage().props.value.permissions.ar

    //pic
    let thingpic = prop.media_collection.filter(v => v[0].mime_type !== 'video/mp4' && v[0].mime_type !== 'audio/mpeg')
    let flatpic = thingpic[0].flat()

    pic.value = flatpic[1]

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
    <div class="relative h-screen max-w-full mx-auto overflow-hidden bg-gray-circles">
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
            <div class="flex flex-col justify-end py-0 space-y-4">
                <div class="mt-8 grow">
                    <div class="grid w-11/12 grid-cols-5 mx-auto gap-x-2 ">
                        <button class="w-full py-5 mx-auto rounded-full " :disabled="audioper == false"
                            :class="audioper == false ? 'text-gray-circles bg-white' : 'text-white bg-virtual-blue'">
                            <SpeakerWaveIcon class="w-8 h-8 mx-auto"
                                @click="(audioper == false ? '' : changeTypeOfMedia = 'audio')" />
                        </button>
                        <button class="w-full py-5 mx-auto text-white rounded-full bg-virtual-blue">
                            <PhotoIcon class="w-8 h-8 mx-auto" @click="(changeTypeOfMedia = 'gallery')" />
                        </button>
                        <button class="w-full py-5 mx-auto text-white rounded-full bg-virtual-blue">
                            <FilmIcon class="w-8 h-8 mx-auto" @click="(changeTypeOfMedia = 'video')" />
                        </button>
                        <button class="w-full py-5 mx-auto rounded-full " :disabled="!camper"
                            :class="camper == false ? 'text-gray-circles bg-white' : 'text-white bg-virtual-blue'">
                            <CubeTransparentIcon class="w-8 h-8 mx-auto" @click="arTrigger" />
                        </button>
                        <button class="w-full py-5 mx-auto text-white rounded-full bg-virtual-blue"
                            @click="languageChange === 'AL' ? languageChange = 'EN' : languageChange = 'AL'">
                            {{ languageChange }}
                        </button>
                    </div>
                    <div class="flex flex-col mt-5">
                        <p class="px-5 my-auto text-xl font-light text-start text-virtual-blue">
                            {{ languageChange === 'AL' ? 'Stacioni' : 'Station' }}
                        </p>
                        <p class="px-5 my-auto text-3xl font-semibold text-start text-virtual-blue">
                            {{ languageChange === 'AL' ? prop.station.title_al : prop.station.title_en }}
                        </p>
                    </div>
                    <div class="flex flex-col mt-7">
                        <img :src="prop.featured.original_url" class="object-cover object-center w-full h-64" alt=""
                            v-if="(changeTypeOfMedia === null)">
                        <div class="mix-blend-multiply py-9 bg-gray-circles"
                            v-else-if="(changeTypeOfMedia === 'audio')">
                            <DynamicIslandPlayer ref="player" :play-list="playList" :volume="0.8" :html5="true"
                                @play="play" @next="next" @pause="pause" @previous="previous" @animation-big="test" />
                        </div>
                        <div class="relative" v-else-if="(changeTypeOfMedia === 'gallery')">
                            <p class="absolute z-50 w-full h-64 text-center text-white underline inset-y-1/2"
                                @click="showImg">

                                {{ languageChange === 'AL' ? 'Hap galerin??' : 'See Gallery' }}
                            </p>
                            <div class="absolute w-full h-64 bg-black opacity-50">
                            </div>
                            <img :src="pic" class="object-cover object-center w-full h-64" alt="">
                        </div>
                        <div class="relative" v-else-if="(changeTypeOfMedia === 'video')">
                            <PlayCircleIcon class="absolute z-50 w-20 h-20 text-white stroke-1 inset-x-4/4 inset-y-1/3"
                                @click="showVideo" />

                            <div class="absolute w-full h-64 bg-black opacity-50">
                            </div>
                            <img :src="vid" class="object-cover object-center w-full h-64" alt="">
                        </div>
                    </div>
                </div>
                <div class="relative overflow-y-hidden h-60 grow">
                    <div class="relative max-h-full overflow-y-auto">
                        <p class="h-full px-5 text-sm font-normal leading-loose pb-96 text-start text-virtual-blue">
                            {{ languageChange === 'AL' ? prop.station.teaser_al : prop.station.teaser_en }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- // ketu ar -->
        <AugmentFBX :buttonCondition="textForHiddingAndShowing" @condition-display="changeDisplayFromARToStation" v-else />

    </div>
    <div class="fixed inset-y-0 left-0 z-50 flex w-screen h-screen space-x-0 demo-player" ref="target"
        v-if="visibleRef">
        <div class="flex-col w-full my-auto">
            <div class="grid content-center grid-cols-3 my-auto justify-items-center">
                <div class="col-span-2"></div>
                <div class="pb-5 ml-auto mr-2">
                    <XMarkIcon class="text-white w-7 h-7" @click="onHide"> </XMarkIcon>
                </div>
            </div>
            <div class="w-11/12 m-auto" v-if="video">
                <v3d-player ref="playerRef" class="w-11/12 h-auto my-auto" :options="options" />
            </div>
            <div class="w-11/12 m-auto" v-else>
                <swiper :slides-per-view="1.5" :space-between="20" :slidesPerColumn="2" @swiper="onSwiper"
                    @slideChange="onSlideChange">
                    <swiper-slide v-for="image in imgsFORgallery" :key="image">
                        <img :src="image[0].original_url" class="w-full">
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
</style>>


