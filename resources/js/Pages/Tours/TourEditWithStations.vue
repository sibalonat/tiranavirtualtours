<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { onBeforeMount, onMounted, reactive, ref, watchEffect, watch } from '@vue/runtime-core';

import { LMap, LTileLayer, LMarker, LPopup, LCircleMarker } from '@vue-leaflet/vue-leaflet'

import "leaflet/dist/leaflet.css"

//lodash
import _ from 'lodash';


// modal
import ModalStationVue from './ModalStation.vue';

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
import { Inertia } from '@inertiajs/inertia';

import { computed } from '@vue/reactivity';

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginImagePreview,
    FilePondPluginFilePoster
);


const prop = defineProps({
    tour: Object,
})


let url = ref('https://{s}.tile.osm.org/{z}/{x}/{y}.png')
// let attribution = ref('&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors')
let zoom = ref(12)
let zoomOuter = ref(11)
// let imgs = ref(null)
const name = ref('stationArr')

const imgAudio = ref('imgAudio')
let serverMessage = {};
let idToDelete = ref('')
let routedel = ref('')
let pondus = ref(null)
let img = reactive({})

const view = ref(1)

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


const form = useForm({
    title_en: '',
    title_al: '',
    teaser_en: '',
    teaser_al: '',
    lng: '',
    lat: '',
    tour_id: prop.tour.id
});


let db = reactive({ server: {} })


const submitForm = () => {
    form.lat = updatedMarker.lat
    form.lng = updatedMarker.lng
    form.put(route('tour.stationupdate', { tour: prop.tour.slug, station: response.value.id }));
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




const getImages = async (e, header) => {
    return await axios.get(route('station.imgsget', e), header);
}

// const getFeatureImage = async (e, header) => {
//     return await axios.get(route('station.imgsget', e), header);
// }

const filepondInitialized = async () => {
    console.log('Filepond is ready!');
    console.log('Filepond object:', pond.value);

    // console.log(pond.value.getFiles());


    if (usePage().props.value.modal !== undefined) {
        console.log(usePage().props.value.modal);
        // console.log(response.value);
        response.value = usePage().props.value.modal.props.stat;

        if (computedView.value === 2) {

            setOptions({ files: [] })
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
    console.log('Filepond is ready!');
    console.log('Filepond object:', pondus.value);
    console.log(response.value);

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
        // imgs.value = []
        setOptions({ files: [] })
        await axios.get(route('tour.featureget', { station: response.value.id }), header)
            .then((response) => {
                console.log(response);
                // image = response.data
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


const handleProcessedFile = (error) => {
    if (error) {
        return;
    }
    // filepondInitialized()
}

const handleProcessedFeature = (error, file) => {
    if (error) {
        return;
    }

    console.log(file);

    let obj = JSON.parse(file.serverId)
    console.log(obj);

    idToDelete.value = obj.id

}


const onReady = async () => {
    const map = maped.value.leafletObject
    showBounds(map.getBounds())
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
    // marker.value = updatedMarker
    console.log(updatedMarker);
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



const deleteStation = (s) => {
    axios.delete(route('station.delete', { station: s.id }), header)
        .then((reponse) => {
            Inertia.reload({ only: [] })
        })
        .catch(function (error) {
            console.log(error);
        })
    // Inertia.get(route('tour.edit', {tour: prop.tour.slug}));
}


onBeforeMount(() => {
    navigator.geolocation.getCurrentPosition(pos => {
        geolocation.value = pos.coords;
    })
    stations.value = prop.tour.stations

    if (usePage().props.value.modal !== undefined) {
        console.log('is defined');
        response.value = usePage().props.value.modal.props.stat;
        if (response.value.lat != 0) {

            form.teaser_al = response.value.teaser_al
            form.teaser_en = response.value.teaser_en
            form.title_al = response.value.title_al
            form.title_en = response.value.title_en
            markerEdit.value = { lat: parseFloat(response.value.lat), lng: parseFloat(response.value.lng) }
            updatedMarker = markerEdit.value

        }
    }


})

onMounted(() => {
    thingOnUpdate, filepondInitialized, handleProcessedFile, filepondInitializedAudios, handleProcessedFeature
    LMap, LTileLayer, LMarker, LPopup, LCircleMarker
    // marker.value = [41.32801218205472, 19.818165153265003]
    drag.value = true

    // imageDelete
    imageDelete



    ModalStationVue

    console.log(response.value);


    if (response.value !== null) {
        console.log('does this load');
        setOptions({
            server: {
                url: route('single.station', response.value.id),
                process: {
                    url: '/image-store',
                    onerror: (response) => {
                        console.log(response);
                        // serverMessage = JSON.parse(response);
                    },
                },
                revert: null,
                load: null,
                remove: (source, load, error) => {
                    // console.log(source);
                    axios
                        .delete(route('station.imgdel', {
                            station: response.value.id, id: source.id
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
            }
        })
    }

    url, zoom, zoomOuter, name, center, centerOuter, allTours, FilePond

    submitForm, deleteStation, changingView, onReady, errorCatched

    // imageDelete
    if (geolocation.value) {
        geo.lat = geolocation.value.latitude
        geo.lng = geolocation.value.longitude
    }


    // maped.value.noBlockingAnimations = true

    if (!("geolocation" in navigator)) {
        errorStr.value = 'Geolocation is not available.';
        return;
    }

    // if (usePage().props.value.modal.props.stat) {

})


watchEffect(async () => {
    // lengths
    if (geolocation.value) {
        geo.lat = await geolocation.value.latitude
        geo.lng = await geolocation.value.longitude
    }
    console.log(db);
})


watch(idToDelete, async (newId) => {
    idToDelete.value = newId
    console.log(idToDelete.value);
})

// if (computedView === 3) {

//     }

// watch(computedView.value, async (thing) => {
//     // log
//     // computedView = thing

//     console.log(computedView);

// })
// watchEffect(() => {
//     console.log(computedView);
// })


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
                                <Link class="px-5 py-2 mx-auto text-yellow-300 uppercase rounded-md bg-amber-900"
                                    :href="route('tour.redirect', prop.tour.slug)">
                                CREATE STATION
                                </Link>
                            </div>
                        </div>
                        <div class="col-span-2 col-start-2">
                            <div class="flex flex-row" v-for="(station, i) in prop.tour.stations" :key="station.id">
                                <div class="grid grid-cols-8 py-2 grow gap-x-5">
                                    <p class="col-span-5 text-lg font-semibold">
                                        <span class="text-xs ">{{ i + 1 }}.</span> {{ station.title_al }}
                                    </p>
                                    <div class="col-span-1">
                                        <Link type="button"
                                            class="px-2 py-1 mx-auto my-auto text-base rounded-lg bg-lime-800 text-slate-300 "
                                            :href="route('tour.stationmodal', { tour: prop.tour.slug, station: station.id })">
                                        Edit</Link>
                                    </div>
                                    <div class="col-span-1">
                                        <Link type="button"
                                            class="px-2 py-1 mx-auto my-auto text-base bg-red-600 rounded-lg text-slate-900"
                                            @click="deleteStation(station)"> Delete</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="z-0 col-span-3 col-start-4">
                            <div class="flex h-full">
                                <l-map style="height:80vh" :center="centerOuter" v-model="zoomOuter"
                                    v-model:zoom="zoomOuter" :maxZoom="19">
                                    <l-tile-layer :url="url" />
                                    <l-circle-marker v-for="station in prop.tour.stations" :key="station.id"
                                        :lat-lng="[station.lat, station.lng]" :draggable="false" :radius="7"
                                        :fill="true" :fillColor="'blue'" :fillOpacity="1">
                                        <!-- <l-popup :content="station.teaser_en" /> -->
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
    </BreezeAuthenticatedLayout>

    <ModalStationVue class="bg-neutral-500/[.6]" :tour="prop.tour">
        <template #title>
            <h3 class="text-2xl">Stacion artistik</h3>
        </template>
        <template #default>
            <form class="mt-6" @submit.prevent="submitForm">
                <div class="flex flex-wrap">
                    <div class="grid w-11/12 grid-cols-3 gap-x-2">
                        <div>
                            <label for="title" class="self-center px-8 py-1 text-white bg-black rounded-lg">Title
                                English</label>
                            <input type="text" id="title" v-model="form.title_en">
                            <label for="title" class="self-center px-8 py-1 text-white bg-black rounded-lg">Title
                                Albania</label>
                            <input type="text" id="title" v-model="form.title_al">
                        </div>
                        <div class="col-span-2">
                            <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
                                Teaser English
                            </label>
                            <textarea name="teaser" id="teaser" class="self-center w-full"
                                v-model="form.teaser_en"></textarea>
                            <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
                                Teaser Albanian
                            </label>
                            <textarea name="teaser" id="teaser" class="self-center w-full"
                                v-model="form.teaser_al"></textarea>
                        </div>

                    </div>
                    <br>

                    <!-- <div class="z-50 w-full h-full" v-if="!changeview"> -->
                    <div class="z-50 w-full h-full" v-if="computedView == 1">
                        <p class="py-2 pl-5 text-xs italic bg-slate-400 text-slate-200"> Ka nje marker. Marker, pika,
                            mund te tërhiqet dhe vendoset ku duhet</p>
                        <l-map style="height:50vh" ref="maped" :center="center" v-model="zoom" v-model:zoom="zoom"
                            :maxZoom="19" @ready="onReady" @update:bounds="showBounds">
                            <l-tile-layer :url="url" />
                            <l-marker @update:lat-lng="thingOnUpdate($event)"
                                :lat-lng="markerEdit != null ? markerEdit : marker" :draggable="drag">
                                <!-- <l-popup :content="marker.name" /> -->
                            </l-marker>
                        </l-map>
                    </div>
                    <br>
                    <div class="w-full h-full" v-if="computedView == 2">
                        <FilePond :name="name" ref="pond" allowMultiple="true" credits="false"
                            label-idle="Click to choose image, or drag here..." @init="filepondInitialized"
                            @error="errorCatched" allow-revert="false" :image-preview-height="200"
                            accepted-file-types="image/jpg, image/jpeg, image/png, video/mp4, audio/mp3, audio/mpeg"
                            max-file-size="55MB" />
                    </div>

                    <div class="w-full h-full" v-if="computedView == 3">
                        <FilePond :name="imgAudio" ref="pondus" allowMultiple="false" :server="db.server"
                            credits="false" label-idle="Click to choose image, or drag here..."
                            @init="filepondInitializedAudios" @error="errorCatched" :image-preview-height="200"
                            @processfile="handleProcessedFeature" @removefile="imageDelete"
                            accepted-file-types="image/jpg, image/jpeg, image/png" max-file-size="5MB" />
                    </div>

                </div>
                <div class="grid grid-cols-2">
                    <button type="button" class="text-xl text-white bg-slate-900"
                        @click="computedView > 1 ? computedView = computedView - 1 : computedView = 1">Prev</button>
                    <button type="button" class="text-xl text-white bg-slate-900"
                        @click="computedView < 3 ? computedView = computedView + 1 : computedView = 3">Next</button>
                </div>
                <button type="submit" class="px-6 py-1 mt-12 bg-green-700 rounded-lg text-slate-100">
                    Ruje stacionin
                </button>
            </form>

        </template>

    </ModalStationVue>


</template>

<style>
.filepond--item {
    width: calc(50% - 0.5em);
}
</style>
