<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { onBeforeMount, onMounted, reactive, ref, watchEffect, watch } from '@vue/runtime-core';

import { LMap, LTileLayer, LMarker, LPopup, LCircleMarker } from '@vue-leaflet/vue-leaflet'

import "leaflet/dist/leaflet.css"

//lodash
import _ from 'lodash';

// heroicons

import {
    ChevronRightIcon,
} from '@heroicons/vue/24/outline'

// use geolocation
// vue use
import { useGeolocation } from '@vueuse/core'
// click outside


// text components
import TeaserForStation from "@/Components/TeaserForStation.vue";
import AuthorBioForTeaser from "@/Components/AuthorBioForTeaser.vue";


// filepond
import vueFilePond, { setOptions } from 'vue-filepond';

import "filepond/dist/filepond.min.css";
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';

// Import the plugin code
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';

// Import the plugin styles
import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';

import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
// import { router } from '@inertiajs/vue3'

import { computed } from '@vue/reactivity';

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginImagePreview,
    FilePondPluginFilePoster
);

const prop = defineProps({
    tour: Object,
    data_station: Object
})

let url = ref('https://{s}.tile.osm.org/{z}/{x}/{y}.png')
// let attribution = ref('&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors')
let zoom = ref(12)
let zoomOuter = ref(11)
// let imgs = ref(null)
const name = ref('stationArr')

const imgAudio = ref('imgAudio')
const threObject = ref('threeDObject')
let serverMessage = {};
let idToDelete = ref('')
let idToModelDelete = ref('')
let routedel = ref('')
let pondus = ref(null)
let img = reactive({})
let model = reactive({})

const view = ref(1)

// use geolocation
const { coords, locatedAt, error, resume, pause } = useGeolocation()

let center = ref([41.341291, 19.861367])
let centerOuter = reactive({ lng: 19.850004785156254, lat: 41.33198614680859 })
let geolocation = ref(null)
let geo = reactive({
    lng: '',
    lat: ''
})


let imgsADelete = ref(null)
let maped = ref(null)
let marker = ref([41.32801218205472, 19.818165153265003])
let markerEdit = ref(null)
let changeview = ref(false)
let drag = ref(false)
let editor = ref('')
let allTours = ref(null)
let updatedMarker = reactive({
    lng: 0,
    lat: 0,
})

let response = ref(null)

let pond = ref(null)

let imgs = ref([])
let imgsserver = ref([])
let lengths = ref(null)

let header = reactive({
    headers: { 'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf_token"]').content }
})

let stations = ref(null)
let openModal = ref(false)
const conditionComp = ref(0)

const serverObject = reactive({ server: {} })


const stationDT = useForm({
    title: '',
    teaser_en: '',
    teaser_al: '',
    author_en: '',
    author_al: '',
    lng: '',
    lat: '',
    tour_id: prop.tour.id
});


let db = reactive({ server: {} })

let dbThreeD = reactive({ server: {} })


const submitForm = () => {
    stationDT.lat = updatedMarker.lat
    stationDT.lng = updatedMarker.lng
    stationDT.put(route('tour.stationupdate', { tour: prop.tour.slug, station: response.value.id }));
    openModal.value = false
    computedView.value = 1
}

const errorCatched = (error) => {
    console.log(error);
}

const computedView = computed({
    // getter
    get() {
        return view.value
    },
    // setter
    set(val) {
        view.value = val
    }
})


const willORNotWill = computed(() => {
  return stationDT.title === '' &&
         stationDT.teaser_en === '' &&
         stationDT.teaser_al === '' &&
         stationDT.author_en === '' &&
         stationDT.author_al === '' ? false : true
})

const getImages = async (e, header) => {
    return await axios.get(route('station.imgsget', e), header);
}

const filepondInitialized = async () => {

    if (response.value) {
        if (computedView.value === 2) {

            setOptions({ files: [] })
            // setOptions({ files: [], allowImagePreview: true })
            imgsADelete.value = null

            imgsADelete.value = await getImages(response.value.id, header);

            if (imgsADelete.value.data.length) {

                imgs.value = imgsADelete.value.data.map((item) => {

                    let single = {
                        source: item[0],
                        options: {
                            type: 'local',
                            metadata: {
                                poster: item[1],
                            },
                            file: {
                                name: item[0].name,
                                size: item[0].size,
                                type: item[0].mime_type
                            }
                        }
                    }
                    return single
                })

                imgs.value.forEach(el => {

                    pond.value.addFiles(
                        el,
                        {
                            type: 'local',
                            metadata: {
                                poster: el.original_url,
                            },
                            file: {
                                name: el.name,
                                size: el.size,
                                type: el.mime_type,
                            },
                        }
                    )
                })
                // setOptions({ files: imgs.value })
            }
        } else if (computedView.value !== 2) {
            return
        }
    }
}

const filepondInitializedAudios = async () => {
    db.server = {
        url: route('single.station', { station: response.value.id }),
        process: {
            url: '/img',
            onerror: (response) => {
                serverMessage = JSON.parse(response);
            },
        },
        revert: null,

        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf_token"]').content
        },
        labelFileProcessingError: () => {
            return serverMessage.error;
        },
    }

    if (computedView.value === 3) {
        setOptions({ files: [] })
        await axios.get(route('tour.featureget', { station: response.value.id }), header)
            .then((response) => {
                img = response.data
            })
            .catch((error) => {
                console.log(error);
            })
        if (!_.isEmpty(img)) {
            await pondus.value.addFile(
                img,
                {
                    type: 'local',
                    metadata: {
                        poster: img.original_url,
                    },
                    file: {
                        name: img.name,
                        size: img.size,
                        type: img.mime_type,
                    },
                }
            )
        }
    } else if (computedView.value !== 3) {
        return
    }
}

const filepondInitializedThree = async () => {
    dbThreeD.server = {
        url: route('single.station', { station: response.value.id }),
        process: {
            url: '/threeobject',
            onerror: (response) => {
                serverMessage = JSON.parse(response);
            },
        },
        revert: null,

        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf_token"]').content
        },
        labelFileProcessingError: () => {
            return serverMessage.error;
        },
    }

    if (computedView.value === 4) {
        setOptions({ files: [] })
        await axios.get(route('tour.threadget', { station: response.value.id }), header)
            .then((response) => {
                model = response.data
            })
            .catch((error) => {
                console.log(error);
            })
        if (!_.isEmpty(model)) {
            await pondus.value.addFile(
                model,
                {
                    type: 'local',
                    metadata: {
                        poster: model.original_url,
                    },
                    file: {
                        name: model.name,
                        size: model.size,
                        type: model.mime_type,
                    },
                }
            )
        }
    } else if (computedView.value !== 4) {
        return
    }
}

const handleProcessedFile = (error) => {
    if (error) {
        return;
    }
}

const initaddingfile = (file) => {
    console.log(file);

}

const handleProcessedFeature = (error, file) => {
    if (error) {
        return;
    }

    let obj = JSON.parse(file.serverId)

    idToDelete.value = obj.id
}

const handleProcessedModel = (error, file) => {
    if (error) {
        return;
    }

    let obj = JSON.parse(file.serverId)

    idToModelDelete.value = obj.id
}

const onReady = async () => {
    const map = maped.value.leafletObject
    showBounds(map.getBounds())
}

const emptyObject = () => {
    stationDT.teaser_al = ''
    stationDT.teaser_en = ''
    stationDT.title = ''
    stationDT.author_en = ''
    stationDT.author_al = ''
    stationDT.lng = 0
    stationDT.lat = 0
    stationDT.tour_id = prop.tour.id
}

const createInitiaStation = () => {

    emptyObject()

    router.visit(route('tour.redirect', prop.tour.slug), {
        method: 'get',
        replace: false,
        only: [],
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            response.value = prop.data_station
            openModal.value = true;
        },
    })


}
const editStation = (s) => {
    response.value = s
    if (response.value !== null) {
        if (response.value.lat != 0) {
            stationDT.teaser_al = response.value.teaser_al
            stationDT.teaser_en = response.value.teaser_en
            stationDT.title = response.value.title
            stationDT.author_en = response.value.author_en
            stationDT.author_al = response.value.author_al
            markerEdit.value = { lat: parseFloat(response.value.lat), lng: parseFloat(response.value.lng) }
            updatedMarker = markerEdit.value
        }
    }
    computedView.value = 1
    response.value = s
    openModal.value = true;
}

const closeModal = () => {
    openModal.value = false
    computedView.value = 1

    if (!willORNotWill.value) {
        deleteStation(response.value)
    }
}


const showBounds = (bounds) => {
    bounds.getNorthWest()
    bounds.getSouthEast()
}

const thingOnUpdate = (el) => {
    updatedMarker.lat = parseFloat(el.lat)
    updatedMarker.lng = parseFloat(el.lng)
}

const changingView = () => {
    changeview.value = !changeview.value
}

function imageDelete(error, file) {
    if (error) {
        console.error(error);
        return;
    }

    axios.delete(route('tour.delfeature', { station: response.value.id, id: idToDelete.value }), header)
        .then((reponse) => {
            console.log(reponse);
        })
        .catch(function (error) {
            console.log(error);
        })
}

function objectDelete(error, file) {
    if (error) {
        console.error(error);
        return;
    }

    axios.delete(route('tour.delmodel', { station: response.value.id, id: idToModelDelete.value }), header)
        .then((reponse) => {
            console.log(reponse);
        })
        .catch(function (error) {
            console.log(error);
        })
}

const deleteStation = (s) => {
    axios.delete(route('station.delete', { station: s.id }), header)
        .then((reponse) => {
            router.reload({ only: [] })
        })
        .catch(function (error) {
            console.log(error);
        })
}


onBeforeMount(() => {
    stations.value = prop.tour.stations

    if (response.value !== null) {
        if (response.value.lat != 0) {
            stationDT.teaser_al = response.value.teaser_al
            stationDT.teaser_en = response.value.teaser_en
            stationDT.title = response.value.title
            stationDT.author_en = response.value.author_en
            stationDT.author_al = response.value.author_al
            markerEdit.value = { lat: parseFloat(response.value.lat), lng: parseFloat(response.value.lng) }
            updatedMarker = markerEdit.value
        }
    }
})

onMounted(() => {
    thingOnUpdate, filepondInitialized, handleProcessedFile, filepondInitializedAudios, handleProcessedFeature, filepondInitializedThree, objectDelete, handleProcessedModel
    // properties
    serverObject, imgsserver, lengths, Head, Link, marker, geolocation, routedel, threObject, imgAudio
    // map
    LMap, LTileLayer, LMarker, LPopup, LCircleMarker, TeaserForStation, AuthorBioForTeaser, BreezeAuthenticatedLayout
    // heroicons
    ChevronRightIcon

    drag.value = true

    editor.value = localStorage.getItem('editor');

    // imageDelete
    imageDelete

    openModal.value = false;

    conditionComp.value = 0


    url, zoom, zoomOuter, name, center, centerOuter, allTours, FilePond

    submitForm, deleteStation, changingView, onReady, errorCatched, createInitiaStation, editStation, closeModal, initaddingfile

    if (!("geolocation" in navigator)) {
        errorStr.value = 'Geolocation is not available.';
        return;
    }
})


watchEffect(async () => {
    if (coords.value.latitude !== Infinity && coords.value.longitude !== Infinity) {
        geo.lat = await coords.value.latitude
        geo.lng = await coords.value.longitude
    }
})


watch(idToDelete, async (newId) => {
    idToDelete.value = newId
})

watch(response, async (res) => {
    if (res !== null) {
        setOptions({
            server: {
                url: route('single.station', res.id),
                process: {
                    url: '/image-store',
                    // onload: (dt) => {
                    //     console.log(dt);
                    //     console.log(pond.value);
                    // },
                    onerror: (response) => {
                        console.log(response);
                    },
                    // labelFileProcessing: () => {
                    //     console.log('something');
                    // }
                },
                revert: null,
                load: null,
                remove: (source, load, error) => {
                    axios
                        .delete(route('station.imgdel', {
                            station: res.id, id: source.id
                        }), header)

                    // Should somehow send `source` to server so server can remove the file with this source

                    // Can call the error method if something is wrong, should exit after
                    error('oh my goodness');

                    // Should call the load method when done, no parameters required
                    load();
                },
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf_token"]').content
                }
            },
        })
    }
})


</script>
<template>

    <Head title="Single Tour" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ prop.tour.title }}
            </h2>
        </template>
        <div class="py-12">
            <div class="relative mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="flex justify-around w-full py-2 overflow-hidden bg-white shadow-sm sm:rounded-lg space-x-11">
                    <div class="grid w-full grid-cols-6 gap-x-2">
                        <div class="flex items-center justify-center py-5 my-auto bg-gray-500 h-5/6 drop-shadow-lg">
                            <div class="h-min">
                                <button class="px-5 py-2 mx-auto text-yellow-300 uppercase rounded-md bg-amber-900"
                                    @click.prevent="createInitiaStation">
                                    CREATE STATION
                                </button>
                            </div>
                        </div>
                        <div class="col-span-2 col-start-2">
                            <div class="flex flex-row" v-for="(station, i) in prop.tour.stations" :key="station.id">
                                <div class="grid grid-cols-8 py-2 grow gap-x-5">
                                    <p class="col-span-5 text-lg font-semibold">
                                        <span class="text-xs ">{{ i + 1 }}.</span> {{ station.title }}
                                    </p>
                                    <div class="col-span-1">
                                        <button type="button"
                                            class="px-2 py-1 mx-auto my-auto text-base rounded-lg bg-lime-800 text-slate-300"
                                            @click.prevent="editStation(station)">
                                            Edit
                                        </button>
                                    </div>
                                    <div class="col-span-1">
                                        <button type="button"
                                            class="px-2 py-1 mx-auto my-auto text-base bg-red-600 rounded-lg text-slate-900"
                                            @click.prevent="deleteStation(station)">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="z-0 col-span-3 col-start-4">
                            <div class="flex h-full">
                                <l-map style="height:70vh" :center="centerOuter" v-model="zoomOuter"
                                    v-model:zoom="zoomOuter" :maxZoom="19">
                                    <l-tile-layer :url="url" />
                                    <l-circle-marker v-for="station in prop.tour.stations" :key="station.id"
                                        :lat-lng="[station.lat, station.lng]" :draggable="false" :radius="7"
                                        :fill="true" :fillColor="'blue'" :fillOpacity="1">
                                    </l-circle-marker>
                                    <l-circle-marker :stroke="true" :radius="7" :weight="1" :dashArray="'4.5'"
                                        :fill="true" :fillColor="'red'" :fillOpacity="1" :color="'blue'" :lat-lng="geo">
                                    </l-circle-marker>
                                </l-map>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <vue-final-modal v-model="openModal">
            <div class="w-2/3 mx-auto mt-16 bg-white rounded-md shadow-md">
                <div class="p-10">
                    <form class="mt-6" @submit.prevent="submitForm">
                        <h3 class="w-1/3 text-2xl text-start ">Stacion artistik</h3>
                        <div class="flex flex-wrap mt-5">
                            <div class="grid w-full grid-cols-3 gap-x-2">
                                <div class="grid grid-cols-2 gap-x-5">
                                    <div class="col-span-2">
                                        <label for="title"
                                            class="flex self-center px-8 py-1 text-white bg-black rounded-lg">
                                            Title English
                                        </label>
                                        <input type="text" id="title" class="w-full -mt-2" v-model="stationDT.title">
                                    </div>
                                </div>
                                <div class="grid grid-cols-8 col-span-2 gap-x-5">
                                    <div class="grid grid-cols-2 col-span-7 gap-x-5">
                                        <KeepAlive>
                                            <component :is="conditionComp === 0 ? TeaserForStation : AuthorBioForTeaser"
                                                v-model:teaser_en="stationDT.teaser_en"
                                                v-model:teaser_al="stationDT.teaser_al"
                                                v-model:author_en="stationDT.author_en"
                                                v-model:author_al="stationDT.author_al" />
                                        </KeepAlive>
                                    </div>
                                    <div class="flex">
                                        <button type="button" class="mx-auto my-auto text-white bg-black rounded-lg place-self-center"
                                            @click="conditionComp === 0 ? conditionComp = 1 : conditionComp = 0">
                                            <ChevronRightIcon class="w-1/2 mx-auto h-1/2" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="z-50 w-full h-full" v-if="computedView == 1 && openModal">
                                <p class="py-2 pl-5 text-xs italic bg-slate-400 text-slate-200">
                                    Ka nje marker. Marker, pika, mund te tërhiqet dhe vendoset ku duhet
                                </p>
                                <l-map style="height:35vh;" ref="maped" :center="center" v-model="zoom"
                                    v-model:zoom="zoom" :maxZoom="19" @ready="onReady" @update:bounds="showBounds">
                                    <l-tile-layer :url="url" />
                                    <l-marker @update:lat-lng="thingOnUpdate($event)"
                                        :lat-lng="markerEdit != null ? markerEdit : marker" :draggable="drag">
                                    </l-marker>
                                </l-map>
                            </div>
                            <br>
                            <div class="w-full h-full" v-if="computedView == 2">
                                <FilePond :name="name" ref="pond" allowMultiple="true" credits="false"
                                    label-idle="Click to choose image, or drag here..." @init="filepondInitialized"
                                    @error="errorCatched" @addfilestart="initaddingfile" allow-revert="false"
                                    :imagePreviewMaxHeight="100" :filePosterMaxHeight="100"
                                    accepted-file-types="image/jpg, image/jpeg, image/png, video/mp4, audio/mp3, audio/mpeg"
                                    max-file-size="55MB" />
                            </div>

                            <div class="w-full h-full featuredImage" v-if="computedView == 3">
                                <FilePond :name="imgAudio" ref="pondus" allowMultiple="false" :server="db.server"
                                    credits="false" label-idle="Click to choose image, or drag here..."
                                    @init="filepondInitializedAudios" @error="errorCatched" :image-preview-height="200"
                                    @processfile="handleProcessedFeature" @removefile="imageDelete"
                                    accepted-file-types="image/jpg, image/jpeg, image/png" max-file-size="5MB" />
                            </div>
                            <div class="w-full h-full threeDobject" v-if="computedView == 4">
                                <!-- application/octet-stream -->
                                <FilePond :name="threObject" ref="pondus" allowMultiple="false"
                                    :server="dbThreeD.server" credits="false"
                                    label-idle="Click to choose image, or drag here..." @init="filepondInitializedThree"
                                    @error="errorCatched" :image-preview-height="200"
                                    @processfile="handleProcessedModel" @removefile="objectDelete"
                                    max-file-size="55MB" />
                            </div>
                            <br>
                        </div>
                        <div class="grid grid-cols-2">
                            <button type="button" class="text-xl text-white bg-slate-900"
                                @click="computedView > 1 ? computedView = computedView - 1 : computedView = 1">Prev</button>
                            <button type="button" class="text-xl text-white bg-slate-900"
                                @click="computedView < 4 ? computedView = computedView + 1 : computedView = 4">Next</button>
                        </div>
                        <div class="grid w-1/2 grid-cols-2 mx-auto gap-x-5">
                            <button type="submit"
                                class="w-full px-6 py-1 mt-8 ml-auto bg-green-700 rounded-lg text-slate-100">
                                Ruje stacionin
                            </button>
                            <button class="w-full px-6 py-1 mt-8 ml-auto rounded-lg bg-slate-400 text-slate-900"
                                type="button" @click="closeModal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </vue-final-modal>
    </BreezeAuthenticatedLayout>
</template>

<style>
.filepond--item {
    width: calc(50% - 25.5em);
}

.threeDobject .filepond--item {
    width: calc(50% - 0.5em);
}

.featuredImage .filepond--item {
    width: calc(50% - 5.5em);
}
</style>
