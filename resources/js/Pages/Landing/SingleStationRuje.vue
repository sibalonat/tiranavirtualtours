<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { computed, onMounted, reactive, ref, watch } from '@vue/runtime-core';


// audio
import { DynamicIslandPlayer } from '@/components/AuPlay/index.js'

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
    CubeTransparentIcon
} from '@heroicons/vue/24/outline'

// variables

let lang = ref('AL')
let visibleRef = ref(false)
let video = ref(false)
let gallery = ref(false)
let audioswitch = ref(0)
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

const audioPlayer = computed({
    get() {
        return audioswitch.value
    },
    set(val) {
        audioswitch.value = val
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
function test () {
  console.log('233223')
}
function play () {
  console.log('play')
}
function next () {
  console.log('next')
}
function previous () {
  console.log('previous')
}
function pause () {
  console.log('pause')
}
function set () {
  player.value.setVolume(0.9)
}
function setMute () {
  player.value.setMute(true)
}
function setRate () {
  player.value.setRate(2.0)
}
function setSound () {
  player.value.setMute(false)
}
function seekTo () {
  player.value.seekBySeconds(30)
}
function toggle () {
  player.value.toggle()
}
function playNext () {
  player.value.playNext()
}
function playPrevious () {
  player.value.playPrevious()
}
function getState () {
  console.log(player.value.getSoundState())
}

onMounted(() => {
    BreezeAuthenticatedLayout, Head, Link, V3dPlayer, Swiper, SwiperSlide,
        console.log(DynamicIslandPlayer);
    FlagIcon, InformationCircleIcon, SpeakerWaveIcon, ChevronLeftIcon, PhotoIcon, FilmIcon, CubeTransparentIcon, XMarkIcon

    lang, visibleRef, options, playList, gallery, imgsFORgallery, player
    // computed
    languageChange, audioPlayer
    //methods
    showImg, onHide, showVideo, onSlideChange, onSwiper, play

    console.log(prop.media_collection);
    // console.log(prop.media_collection);
})

// function toggle () {
//   player.value.toggle()
// }

// [player, barRef], ([val, bar], [prevFoo, prevBar])
watch(player, (val) => {
    // console.log(val);
    if (val != null) {
        let thingaudio = prop.media_collection.filter(v => v[0].mime_type === 'audio/mpeg')
        let flattaudio = thingaudio[0].flat()

        playList.value.push({
            author: 'marini',
            cover: prop.featured.original_url,
            file: flattaudio[0].original_url,
            title: 'kush eshte',
            howl: null,
        })
        console.log(player.value);

        // console.log(playList.value);
        // console.log(markRaw(player.value));
        // nextTick(async () => {
        //     // isRef()
        //     // console.log(player.value.getTarget());
        //     console.log(isProxy(player.value));
        //     console.log(unref(player.value));
        //     console.log(player);
        //     // console.log(await player.value);
        //     // console.log(await markRaw(player.value));
        //     // console.log(player.value.get(toogle()));

        //     // console.log(JSON.parse(JSON.stringify(player.value)));

        // })
        // player.value.toggle()
        // player.value.playPrevious()
        // console.log({...val});
        // let oneup = {...val}.toggle()
        // let oneup = JSON.parse(JSON.stringify(val))
        // console.log(oneup);
        // console.log(oneup);
        // oneup.toggle()
        // oneup.playPrevious()

    }
},
    {
        flush: 'post'
    })

</script>

<template>

    <Head title="Landing" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Landing
            </h2>
        </template>

        <div>
            <div class="relative mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex text-white bg-stone-500/[.78] ">
                    <Link class="no-underline" :href="route('landing.tourone', prop.tour.slug)">
                    <p
                        class="inline-block px-5 py-8 my-auto text-[36px] mb-0 font-semibold leading-none align-text-bottom text-start">
                        <ChevronLeftIcon class="inline-block w-12 h-12 -mt-2 -mr-0.5 text-white stroke-2">
                        </ChevronLeftIcon> <span class="inline-block -mb-4">{{ prop.tour.title }}</span>
                    </p>
                    </Link>
                </div>
                <div class="flex flex-col px-10 py-8 space-y-4">

                    <div class="grid grid-cols-3 grow">
                        <div class="col-span-2">
                            <p class="px-10 text-xl font-semibold col-span-2 my-auto text-start text-stone-500/[.78]">
                                Station 1
                            </p>
                            <p class="px-10 text-3xl font-semibold col-span-2 my-auto text-start text-stone-500/[.78]">
                                {{ prop.station.title_al }}
                            </p>
                        </div>
                        <div>
                            <p class="px-10 text-xl col-span-2 my-auto text-start text-stone-500/[.78]">
                                Next station
                            </p>
                            <p class="px-10 text-xl font-semibold col-span-2 my-auto text-start text-stone-500/[.78]">
                                30min
                            </p>
                        </div>
                    </div>
                    <div class="flex w-full mt-1" v-if="(audioPlayer === 0)">
                        <img :src="prop.featured.original_url" class="object-cover w-2/3 h-3/5 rounded-xl" alt="">
                    </div>
                    <div v-else>
                        <DynamicIslandPlayer ref="player" :play-list="playList" :volume="0.8" :html5="true" @play="play"
                            @next="next" @pause="pause" @previous="previous" @animation-long="test" />
                    </div>
                    <div class="grow">
                        <div class="grid grid-cols-3 grid-rows-1">
                            <p class="px-10 text-3xl font-semibold col-span-2 my-auto text-start text-stone-500/[.78]">

                            </p>
                            <button class="px-10 py-2 ml-auto w-9 bg-stone-500/[.78] rounded-xl text-white"
                                @click="languageChange === 'AL' ? languageChange = 'EN' : languageChange = 'AL'">
                                {{ languageChange }}
                            </button>
                        </div>
                    </div>
                    <div class="grow">
                        <p class="px-10 py-8 text-base font-semibold text-start" v-if="languageChange === 'AL'">
                            {{ prop.station.teaser_al }}
                        </p>
                        <p class="px-10 py-8 text-base font-semibold text-start" v-if="languageChange === 'EN'">
                            {{ prop.station.teaser_en }}
                        </p>
                    </div>
                    <div class="grow">
                        <div class="grid grid-cols-4 ">
                            <!-- @click="playAudio" -->

                            <button class="rounded-full text-white mx-auto px-0 py-7 bg-stone-500/[.78] w-2/5">
                                <SpeakerWaveIcon class="w-12 mx-auto h-14"
                                    @click="(audioPlayer === 0 ? audioPlayer = 1 : audioPlayer = 0)"></SpeakerWaveIcon>
                            </button>
                            <button class="rounded-full text-white mx-auto px-0 py-7 bg-stone-500/[.78] w-2/5">
                                <PhotoIcon class="w-12 mx-auto h-14" @click="showImg"></PhotoIcon>
                            </button>
                            <button class="rounded-full text-white mx-auto px-0 py-7 bg-stone-500/[.78] w-2/5">
                                <FilmIcon class="w-12 mx-auto h-14" @click="showVideo"></FilmIcon>
                            </button>
                            <button class="rounded-full text-white mx-auto px-0 py-7 bg-stone-500/[.78] w-2/5">
                                <CubeTransparentIcon class="w-12 mx-auto h-14"></CubeTransparentIcon>
                            </button>
                        </div>
                    </div>

                    <div class="fixed inset-y-0 left-0 z-50 flex w-screen h-screen space-x-0 demo-player" ref="target"
                        v-if="visibleRef">
                        <div class="flex-col w-full my-auto">
                            <div class="grid content-center grid-cols-2 my-auto justify-items-center">
                                <div></div>
                                <div class="pb-5">
                                    <div class="rounded-full bg-slate-50">
                                        <XMarkIcon class="text-black w-7 h-7" @click="onHide"> </XMarkIcon>
                                    </div>
                                </div>
                            </div>
                            <div class="w-1/2 m-auto" v-if="video">
                                <v3d-player ref="playerRef" class="w-1/2 h-auto my-auto" :options="options" />
                            </div>
                            <div class="w-1/2 m-auto" v-else>
                                <swiper :slides-per-view="1.5" :space-between="20" :slidesPerColumn="2"
                                    @swiper="onSwiper" @slideChange="onSlideChange">
                                    <swiper-slide v-for="image in imgsFORgallery" :key="image">
                                        <img :src="image[0].original_url" class="w-full">
                                    </swiper-slide>
                                </swiper>
                            </div>
                        </div>
                    </div>

                    <!-- <div v-for="tour in prop.tours" :key="tour.slug" class="grow border-stone-500/[.78] border-4 rounded-xl">
                        <Link class="no-underline" :href="route('landing.tourone', tour.slug)">
                            <p class="flex uppercase py-4 text-3xl text-stone-500/[.78] ml-5">
                                <FlagIcon class="w-8 h-8 text-stone-500/[.78] mr-2 stroke-2"> </FlagIcon> {{ tour.title }}
                            </p>
                        </Link>
                    </div> -->
                </div>
                <div class="flex flex-col bg-stone-500/[.78] text-white space-y-4">
                    <div class="p-5 grow">
                        <img :src="'/images/TAL.svg'" class="block w-1/4" alt="">
                    </div>
                    <div class="p-5 pb-1 grow">
                        <p>Qëndër për Artin Bashkëkohor</p>
                        <p>Adresa: Rr. Muhamed Gjollesha, <br> P64, Sh.6, Ap.54, Tiranë</p>
                    </div>
                    <div class="p-5 pt-1 grow">
                        <p>Tel: </p>
                        <p>Nipt: </p>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.demo-player {
    background-color: rgba(0, 0, 0, 0.5);
}
</style>>


