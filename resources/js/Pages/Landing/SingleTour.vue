<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Start from "@/Components/HalfStart.vue";
import { computed, onBeforeMount, onMounted, onUnmounted, reactive, ref, watch, watchEffect } from '@vue/runtime-core';

// leaflet
import { LMap, LTileLayer, LMarker, LPopup, LCircleMarker, LTooltip } from '@vue-leaflet/vue-leaflet'
// LIcon
import "leaflet/dist/leafletgray.css"
// import L from 'leaflet';

// vue use
import { useGeolocation } from '@vueuse/core'


import * as L from 'leaflet';
import { OSRMv1, Control as RoutingControl } from '@fleetbase/leaflet-routing-machine';
import "leaflet-routing-machine";
// heroicons
import { FlagIcon, ChevronLeftIcon, ChevronDoubleRightIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'


// variables
// let pop = ref(null)
const reloaded = ref(null)
let icon = reactive(L.icon({ iconUrl: '/images/marker.svg', iconSize: [32, 37], iconAnchor: [16, 37] }))
const { coords, locatedAt, error, resume, pause } = useGeolocation()
let myMap = ref(null)
let renderMarkerDt = ref(null)
let marker = ref(null)

// let dtReload = ref(0)
let routingControl = ref(null);

let selectedMarker = ref(null)
let totalTime = ref(null)

let lang = ref('AL')
let checkForNotNull = ref(null)
let initialCount = ref(0)
let njeprap = ref(0)
let stations = ref(null)
let zoomOuter = ref(12)
let centerOuter = reactive({ lng: 19.850004785156254, lat: 41.33198614680859 })
// let url = ref('https://stamen-tiles.a.ssl.fastly.net/toner/{z}/{x}/{y}.png')
let url = ref('https://{s}.tile.osm.org/{z}/{x}/{y}.png')
// let url = ref('https://maps.omniscale.net/v2/{id}/style.grayscale/{z}/{x}/{y}.png')

let station = ref(null)

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
const getDtStation = (i) => {

    selectedMarker.value = { lng: Number(i.lng), lat: Number(i.lat) }


    station.value = { al: i.title_al, en: i.title_en }

    if (initialCount.value === 0) {

        let paneline = myMap.value.leafletObject.createPane('paneline');
        paneline.style.zIndex = 200;
        setTimeout(() => {
            let interactive = document.querySelectorAll('.leaflet-overlay-pane>svg path.leaflet-interactive:not(.tashohim)');
            interactive.forEach(active => {
                active.remove();
            });
        }, 500)

        const serviceUrl = 'https://router.project-osrm.org/route/v1';
        const router = new OSRMv1({ serviceUrl, profile: 'walking' });
        routingControl.value = new RoutingControl({
            waypoints: [geo, selectedMarker.value],
            router,
            showAlternatives: false,
            addWaypoints: false,
            draggableWaypoints: false,
            lineOptions: {
                styles: [
                    // { pane: 'paneline', color: '#0019DA', opacity: 0.8, weight: 6 },
                    { pane: 'paneline', color: 'white', opacity: 0.15, weight: 1 },
                    { pane: 'paneline', color: '#0019DA', opacity: 1, weight: 3 }
                ],
            },
            show: false,
            createMarker: function () { return null; },
        }).addTo(myMap.value.leafletObject);

        routingControl.value.on('routeselected', function (e) {
            let route = e.route

            totalTime.value = toHoursAndMinutes(route.summary.totalTime)

        })

    } else { return }
}

const changeDtStation = (toLatLng) => {
    routingControl.value.getPlan().setWaypoints([
        L.latLng(geo),
        L.latLng(toLatLng),
    ])
}

const changeStyle = () => {

    njeprap.value++

    if (njeprap.value < 2) {

        marker.value.forEach(element => {

            element.leafletObject._path.classList.remove("leaflet-interactive");
            element.leafletObject._path.style.cursor = 'pointer'

            element.leafletObject._path.style.pointerEvents = 'visiblePainted'
            element.leafletObject._path.style.pointerEvents = 'auto'
            element.leafletObject._path.style.zIndex = '1000'

        });
    }

}

const toHoursAndMinutes = (totalSeconds) => {
    const totalMinutes = Math.floor(totalSeconds / 60);

    const seconds = totalSeconds % 60;
    const hours = Math.floor(totalMinutes / 60);
    const minutes = totalMinutes % 60;

    return { h: hours, m: minutes, s: seconds };
}





onBeforeMount(() => {
    stations.value = prop.tour.stations
})

onMounted(() => {
    BreezeAuthenticatedLayout, Head, Link, Start,
        FlagIcon, ChevronLeftIcon, ChevronDoubleRightIcon, ChevronRightIcon

    // methods
    getDtStation, changeStyle, toHoursAndMinutes

    // leaflet
    LMap, LTileLayer, LMarker, LPopup, LCircleMarker,
        zoomOuter, url, centerOuter, geo, LTooltip, myMap, renderMarkerDt,
        icon, routingControl

    // computed
    languageChange

    // local storage
    reloaded.value = localStorage.getItem('reloaded');
    if (reloaded.value !== 'true') {
        localStorage.setItem('reloaded', 'true');
        location.reload();
    }
})

onUnmounted(() => {
    localStorage.setItem('reloaded', 'false');
})

watch(selectedMarker, (newer, older) => {

    initialCount.value++
    checkForNotNull.value = older
    console.log('select');
    console.log(older);
    console.log(initialCount.value);

    // if (initialCount.value > 0 && older !== null) {
    if (initialCount.value > 0 || older !== null) {
        // console.log('is bigger');
        // setTimeout(() => {
        //     console.log('here');
        //     // let interactive = document.querySelectorAll('.leaflet-overlay-pane>svg path.leaflet-interactive');
        //     // .leaflet-pane>svg path.leaflet-interactive
        //     // let interactive = document.querySelectorAll('.leaflet-overlay-pane>svg g path.leaflet-interactive:not(.tashohim)');
        //     let interactive = document.querySelectorAll('.leaflet-overlay-pane>svg path.leaflet-interactive:not(.tashohim)');
        //     console.log(interactive);
        //     interactive.forEach(active => {
        //         console.log('here again');
        //         active.remove();
        //     });
        // }, 500)
        changeDtStation(newer)
    }
})

watch(totalTime, (n) => {
    console.log(n);
})

watchEffect(() => {
    selectedMarker.value

    if (coords.value.latitude !== Infinity && coords.value.longitude !== Infinity) {
        geo.lat = coords.value.latitude
        geo.lng = coords.value.longitude
    }

})



</script>

<template>

    <Head title="Tour" />
    <div class="relative h-screen max-w-full mx-auto overflow-hidden bg-gray-circles">
        <div class="flex flex-col justify-center">
            <div class="text-white bg-virtual-blue ">
                <Link class="w-full no-underline" :href="route('landing.tours')">
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
                <div class="grow bg-virtual-blue" v-if="reloaded === 'false'">
                    <Start />
                </div>
                <div class="grow" v-else-if="reloaded === 'true'">
                    <l-map style="height:55vh" :center="centerOuter" v-model="zoomOuter" v-model:zoom="zoomOuter"
                        :maxZoom="19" ref="myMap" class="rounded-0" :useGlobalLeaflet="true">
                        <l-tile-layer :url="url" />

                        <l-circle-marker v-for="station in stations" :key="station.id"
                            :lat-lng="[station.lat, station.lng]" :draggable="false" ref="marker" :radius="12" stroke
                            :color="'#0019DA'" :fill="true" :fillColor="'#0019DA'" :fillOpacity="1"
                            :className="'tashohim'" @click="getDtStation(station)" @ready="changeStyle">

                            <l-popup>
                                <Link
                                    :href="route('landing.stationone', { tour: prop.tour.slug, station: station.id })">
                                <p class="py-1 pr-2 font-medium text-xm text-virtual-blue">
                                    {{ languageChange === 'AL' ? station.title_al : station.title_en }}
                                    <ChevronRightIcon
                                        class="inline-block w-4 h-4 -mt-0.5 ml-0.5 -mr-0.5 text-virtual-blue stroke-2" />
                                </p>
                                </Link>
                            </l-popup>


                        </l-circle-marker>

                        <l-marker :lat-lng="geo" :icon="icon">
                        </l-marker>

                    </l-map>
                    <div class="relative grid w-11/12 grid-cols-6 mx-auto -mt-5 z-2 gap-x-2" v-if="station">

                        <div class="col-span-4 bg-white text-virtual-blue">
                            <div class="flex justify-between" v-if="languageChange === 'AL'">
                                <p class="px-3 py-1 text-base">
                                    {{ station.al }}
                                </p>
                                <ChevronDoubleRightIcon class="w-5 h-5 my-auto mr-3 " />
                            </div>
                            <div class="flex justify-between" v-else>
                                <p class="px-3 py-1 text-base">
                                    {{ station.en }}
                                </p>
                                <ChevronDoubleRightIcon class="w-5 h-5 my-auto mr-3 " />
                            </div>
                        </div>
                        <div class="col-span-2 text-white bg-virtual-blue">
                            <div class="flex items-stretch justify-between h-full">
                                <div class="grid self-center w-11/12 grid-cols-3 mx-auto">
                                    <img :src="'/images/walking.svg'" class="block px-1 my-auto" alt="">
                                    <p class="col-span-2 text-base text-center" v-if="totalTime !== null">
                                        {{ totalTime.h > 0 ? totalTime.h + ',' + totalTime.m : totalTime.m }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative overflow-y-hidden h-60 grow">

                    <div class="grid w-11/12 grid-cols-4 overflow-hidden">
                        <p class="col-span-3 px-5 pb-2 my-auto text-3xl font-semibold text-start text-virtual-blue">
                           {{ languageChange === 'AL' ? 'Rreth rrugëtimit' :  'About this tour' }}
                        </p>
                        <button class="h-8 px-3 ml-auto mr-5 text-white bg-virtual-blue rounded-xl"
                            @click="languageChange === 'AL' ? languageChange = 'EN' : languageChange = 'AL'">
                            {{ languageChange }}
                        </button>
                    </div>
                    <div class="relative max-h-full overflow-y-auto">
                        <p class="h-full px-5 text-sm font-normal leading-loose pb-96 text-start text-virtual-blue"
                            v-if="languageChange === 'AL'">
                            {{ prop.tour.description_al }}
                        </p>
                        <p class="h-full px-5 text-sm font-normal leading-loose pb-96 text-start text-virtual-blue"
                            v-else>
                            {{ prop.tour.description_en }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.leaflet-control-container {
    display: none !important;
}

.leaflet-control-container .leaflet-routing-container-hide {
    display: none;
}

.tashohim {
    z-index: 600;
}
</style>
