<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, ref } from '@vue/runtime-core';


// heroicons
import { FlagIcon, InformationCircleIcon, Cog6ToothIcon, ChevronLeftIcon } from '@heroicons/vue/24/outline'
import { Inertia } from '@inertiajs/inertia';
// import { def } from '@vue/shared';


// props
const prop = defineProps({
    settings: Object
})

// variables
let sound = ref(0)
let cameraphone = ref(0)
let locat = ref(0)
let augment = ref(0)

// methods
const ndryshova = (e, t) => {

    switch (t) {
        case 'camera':
            let camera = !cameraphone.value
            Inertia.visit(route('landing.settingsupdate'), {
                    method: 'put',
                    data: {camera, t},
                    replace: true,
                    preserveState: false,
                    preserveScroll: false,
                    headers: {},
                })

            break;
        case 'audio':
            let audio = !sound.value
            Inertia.visit(route('landing.settingsupdate'), {
                    method: 'put',
                    data: {audio, t},
                    replace: true,
                    preserveState: false,
                    preserveScroll: false,
                    headers: {},
                })

            break;
        case 'ar':
            let ar = !augment.value
            console.log(ar);
            Inertia.visit(route('landing.settingsupdate'), {
                    method: 'put',
                    data: {ar, t},
                    replace: true,
                    preserveState: false,
                    preserveScroll: false,
                    headers: {},
                })

            break;
        case 'location':
            let location = !locat.value
            Inertia.visit(route('landing.settingsupdate'), {
                    method: 'put',
                    data: {location, t},
                    replace: true,
                    preserveState: false,
                    preserveScroll: false,
                    headers: {},
                })

            break;

        default:
            break;
    }


    // Inertia.visit(route('landing.settingsupdate'), {
    //         method: 'put',
    //         data: {u, role},
    //         replace: false,
    //         preserveState: false,
    //         preserveScroll: false,
    //         only: [],
    //         headers: {},
    //         errorBag: null,
    //         forceFormData: false,
    //         onCancelToken: cancelToken => { },
    //         onCancel: () => { },
    //         onBefore: visit => { },
    //         onStart: visit => { },
    //         onProgress: progress => { },
    //         onSuccess: page => { },
    //         onError: errors => { },
    //         onFinish: visit => { },
    //     })
}



onMounted(() => {
    BreezeAuthenticatedLayout, Head, Link
    FlagIcon, InformationCircleIcon, Cog6ToothIcon, ChevronLeftIcon

    //methods
    ndryshova

    // variables
    console.log(sound.value)
    console.log(cameraphone.value)
    console.log(locat.value)
    console.log(augment.value)
    sound.value = prop.settings.audio
    cameraphone.value = prop.settings.camera
    locat.value = prop.settings.location
    augment.value = prop.settings.ar

    console.log(prop.settings);
})

</script>

<template>

    <Head title="Settings" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Settings
            </h2>
        </template>

        <div>
            <div class="relative mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- <div class="flex bg-stone-400 text-slate-100 "> -->
                <div class="flex text-white bg-stone-500/[.78] ">
                    <Link class="no-underline" :href="route('landing.all')">
                    <p
                        class="inline-block px-5 py-8 my-auto text-[36px] mb-0 font-semibold leading-none align-text-bottom text-start">
                        <ChevronLeftIcon class="inline-block w-12 h-12 -mt-2 -mr-0.5 text-white stroke-2">
                        </ChevronLeftIcon> <span class="inline-block -mb-4">Settings</span>
                    </p>
                    </Link>
                </div>
                <div class="flex flex-col px-10 py-8 space-y-4">

                    <div class="grid w-full grid-cols-5 mx-auto">
                        <div class="col-span-4 mx-3 font-semibold text-stone-500/[.78] text-3xl">
                            Camera
                        </div>

                        <label for="toggleB" class="flex items-center cursor-pointer">
                            <!-- toggle -->
                            <div class="relative">
                                <!-- input -->
                                <input type="checkbox" id="toggleB" :checked="cameraphone" class="sr-only"
                                    @change="ndryshova(prop.settings.camera, 'camera')">
                                <!-- line -->
                                <div class="block h-8 rounded-full bg-stone-600 w-14 store"></div>
                                <!-- dot -->
                                <div class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"></div>
                            </div>
                            <!-- label -->
                        </label>
                    </div>
                    <div class="grid w-full grid-cols-5 mx-auto">
                        <div class="col-span-4 mx-3 font-semibold text-stone-500/[.78] text-3xl">
                            Audio
                        </div>

                        <label for="toggleBF" class="flex items-center cursor-pointer">
                            <!-- toggle -->
                            <div class="relative">
                                <!-- input -->
                                <input type="checkbox" id="toggleBF" :checked="sound" class="sr-only"
                                    @change="ndryshova(prop.settings.audio, 'audio')">
                                <!-- line -->
                                <div class="block h-8 rounded-full bg-stone-600 w-14 store"></div>
                                <!-- dot -->
                                <div class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"></div>
                            </div>
                            <!-- label -->
                        </label>
                    </div>
                    <div class="grid w-full grid-cols-5 mx-auto">
                        <div class="col-span-4 mx-3 font-semibold text-stone-500/[.78] text-3xl">
                            Augmented Reality
                        </div>

                        <label for="toggleBC" class="flex items-center cursor-pointer">
                            <!-- toggle -->
                            <div class="relative">
                                <!-- input -->
                                <input type="checkbox" id="toggleBC" :checked="augment" class="sr-only"
                                    @change="ndryshova(prop.settings.ar, 'ar')">
                                <!-- line -->
                                <div class="block h-8 rounded-full bg-stone-600 w-14 store"></div>
                                <!-- dot -->
                                <div class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"></div>
                            </div>
                            <!-- label -->
                        </label>
                    </div>
                    <div class="grid w-full grid-cols-5 mx-auto">
                        <div class="col-span-4 mx-3 font-semibold text-stone-500/[.78] text-3xl">
                            Location
                        </div>

                        <label for="toggleBD" class="flex items-center cursor-pointer">
                            <!-- toggle -->
                            <div class="relative">
                                <!-- input -->
                                <input type="checkbox" id="toggleBD" class="sr-only" :checked="locat"
                                    @change="ndryshova(prop.settings.location, 'location')">
                                <!-- line -->
                                <div class="block h-8 rounded-full bg-stone-600 w-14 store"></div>
                                <!-- dot -->
                                <div class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"></div>
                            </div>
                            <!-- label -->
                        </label>
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
input:checked~.dot {
    transform: translateX(100%);
    /* background-color: #48bb78; */
}

input:checked~.store {
    background-color: #d6d3d1;
}
</style>
