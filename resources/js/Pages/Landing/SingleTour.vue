<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { computed, markRaw, nextTick, onBeforeMount, onMounted, onUpdated, reactive, readonly, ref, shallowReadonly, toRaw, unref } from '@vue/runtime-core';

// leaflet
import { LMap, LTileLayer, LMarker, LPopup, LCircleMarker, LTooltip } from '@vue-leaflet/vue-leaflet'
import "leaflet/dist/leafletgray.css"
// import CustomMarker from 'vue-leaflet-custom-marker';

// heroicons
import { FlagIcon, ChevronLeftIcon } from '@heroicons/vue/24/outline'

// variables
// let pop = ref(null)
let pop = ref([])
let pops = []
let pos = []
let i = 0
// let pop = ref(null)
let lang = ref('AL')
let stations = ref(null)
let zoomOuter = ref(13)
let centerOuter = reactive({ lng: 19.850004785156254, lat: 41.33198614680859 })
// let url = ref('https://stamen-tiles.a.ssl.fastly.net/toner/{z}/{x}/{y}.png')
let url = ref('https://{s}.tile.osm.org/{z}/{x}/{y}.png')
// let url = ref('https://maps.omniscale.net/v2/{id}/style.grayscale/{z}/{x}/{y}.png')
let geolocation = ref(null)
let geo = reactive({
    lng: '',
    lat: ''
})


// props
const prop = defineProps({
    tour: Object
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


// methods



onBeforeMount(() => {
    navigator.geolocation.getCurrentPosition(pos => {
        geolocation.value = pos.coords;
    })
    stations.value = prop.tour.stations
})

onMounted(() => {
    BreezeAuthenticatedLayout, Head, Link
    FlagIcon, ChevronLeftIcon,

        console.log(stations.value.length);


    // leaflet
    LMap, LTileLayer, LMarker, LPopup, LCircleMarker, zoomOuter, url, centerOuter, geo, LTooltip

    // computed
    languageChange

    console.log(prop.tour);
})

// onUpdated(() => {
//     console.log('what');
// })

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
                    <Link class="no-underline" :href="route('landing.tours')">
                    <p
                        class="inline-block px-5 py-8 my-auto text-[36px] mb-0 font-semibold leading-none align-text-bottom text-start">
                        <ChevronLeftIcon class="inline-block w-12 h-12 -mt-2 -mr-0.5 text-white stroke-2">
                        </ChevronLeftIcon> <span class="inline-block -mb-4">{{ prop.tour.title }}</span>
                    </p>
                    </Link>
                </div>
                <div class="flex flex-col justify-end px-10 py-8 space-y-4">
                    <div class="grid grid-cols-3 grid-rows-1">
                        <p class="px-10 text-3xl font-semibold col-span-2 my-auto text-start text-stone-500/[.78]">
                            About this tour
                        </p>
                        <button class="px-10 py-2 ml-auto w-9 bg-stone-500/[.78] rounded-xl text-white"
                            @click="languageChange === 'AL' ? languageChange = 'EN' : languageChange = 'AL'">
                            {{ languageChange }}
                        </button>
                    </div>
                    <div class="grow">
                        <p class="px-10 py-8 text-base font-semibold text-start" v-if="languageChange === 'AL'">
                            {{ prop.tour.description_al }}
                        </p>
                        <p class="px-10 py-8 text-base font-semibold text-start" v-else>
                            {{ prop.tour.description_en }}
                        </p>
                    </div>

                    <div class="grow">
                        <l-map style="height:80vh" :center="centerOuter" v-model="zoomOuter" v-model:zoom="zoomOuter"
                            :maxZoom="19" id="myMap" class="rounded-3xl">
                            <l-tile-layer :url="url" />

                            <l-circle-marker v-for="(station, index) in stations" :key="station.id"
                                :lat-lng="[station.lat, station.lng]" :draggable="false" :radius="12" stroke
                                :color="'black'" :fill="true" :fillColor="'white'" :fillOpacity="1">

                                <l-tooltip :options="{
                                    permanent: true,
                                    interactive: true
                                }">
                                    <Link
                                        :href="route('landing.stationone', { tour: prop.tour.slug, station: station.id })"
                                        class="text-black">
                                    {{ index }}
                                    </Link>
                                </l-tooltip>

                            </l-circle-marker>
                            <l-circle-marker :stroke="true" :radius="7" :weight="1" :dashArray="'4.5'" :fill="true"
                                :fillColor="'red'" :fillOpacity="1" :color="'red'" :lat-lng="geo">
                            </l-circle-marker>
                        </l-map>

                    </div>

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
.leaflet-control-container {
    display: none !important;
}
</style>
