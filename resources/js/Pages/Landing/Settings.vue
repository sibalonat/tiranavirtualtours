<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from '@vue/runtime-core';


// heroicons
import { FlagIcon, InformationCircleIcon, Cog6ToothIcon, ChevronLeftIcon } from '@heroicons/vue/24/outline'
// import { Inertia } from '@inertiajs/inertia';
import { router } from '@inertiajs/vue3';

// animatecss
import 'animate.css';

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
            router.visit(route('landing.settingsupdate'), {
                method: 'put',
                data: { camera, t },
                replace: true,
                preserveState: false,
                preserveScroll: false,
                headers: {},
            })
            break;

        case 'audio':
            let audio = !sound.value
            router.visit(route('landing.settingsupdate'), {
                method: 'put',
                data: { audio, t },
                replace: true,
                preserveState: false,
                preserveScroll: false,
                headers: {},
            })
            break;

        case 'ar':
            let ar = !augment.value
            router.visit(route('landing.settingsupdate'), {
                method: 'put',
                data: { ar, t },
                replace: true,
                preserveState: false,
                preserveScroll: false,
                headers: {},
            })
            break;

        case 'location':
            let location = !locat.value
            router.visit(route('landing.settingsupdate'), {
                method: 'put',
                data: { location, t },
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
    cameraphone.value = prop.settings.camera
    sound.value = prop.settings.audio
    augment.value = prop.settings.ar
    locat.value = prop.settings.location

})

</script>

<template>

    <Head title="Settings" />

    <div>
        <div class="h-screen max-w-full mx-auto overflow-hidden bg-gray-circles">
            <div class="text-white bg-virtual-blue ">
                <Link class="w-full no-underline" :href="route('welcome')">
                <div class="grid content-center grid-cols-5">
                    <div class="mx-auto my-auto">
                        <ChevronLeftIcon class="inline-block w-7 h-7 -mt-2 -mr-0.5 text-white stroke-2">
                        </ChevronLeftIcon>
                    </div>
                    <p
                        class="inline-block col-span-4 py-8 my-auto mb-0 text-2xl font-semibold leading-none align-text-bottom text-start">
                        Settings
                    </p>
                </div>
                </Link>
            </div>
            <div class="flex flex-col px-10 py-8 space-y-4">
                <Transition mode="out-in" appear enter-active-class="animate__animated animate__fadeIn"
                    leave-active-class="animate__animated animate__fadeOut">
                    <img :src="'/images/logo.svg'" class="block w-full">
                </Transition>
            </div>
            <div class="flex flex-col px-10 py-8 space-y-4">

                <div class="grid w-full grid-cols-5 mx-auto">
                    <div class="col-span-4 mx-3 text-2xl font-semibold text-virtual-blue">
                        Camera
                    </div>

                    <label for="toggleB" class="flex items-center cursor-pointer">
                        <!-- toggle -->
                        <div class="relative">
                            <!-- input -->
                            <input type="checkbox" id="toggleB" :checked="cameraphone" class="sr-only"
                                @change="ndryshova(prop.settings.camera, 'camera')">
                            <!-- line -->
                            <div class="block h-8 rounded-full bg-virtual-blue w-14 store"></div>
                            <!-- dot -->
                            <div class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"></div>
                        </div>
                        <!-- label -->
                    </label>
                </div>
                <div class="grid w-full grid-cols-5 mx-auto">
                    <div class="col-span-4 mx-3 text-2xl font-semibold text-virtual-blue">
                        Audio
                    </div>

                    <label for="toggleBF" class="flex items-center cursor-pointer">
                        <!-- toggle -->
                        <div class="relative">
                            <!-- input -->
                            <input type="checkbox" id="toggleBF" :checked="sound" class="sr-only"
                                @change="ndryshova(prop.settings.audio, 'audio')">
                            <!-- line -->
                            <div class="block h-8 rounded-full bg-virtual-blue w-14 store"></div>
                            <!-- dot -->
                            <div class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"></div>
                        </div>
                        <!-- label -->
                    </label>
                </div>
                <div class="grid w-full grid-cols-5 mx-auto">
                    <div class="col-span-4 mx-3 text-2xl font-semibold text-virtual-blue">
                        Augmented Reality
                    </div>

                    <label for="toggleBC" class="flex items-center cursor-pointer">
                        <!-- toggle -->
                        <div class="relative">
                            <!-- input -->
                            <input type="checkbox" id="toggleBC" :checked="augment" class="sr-only"
                                @change="ndryshova(prop.settings.ar, 'ar')">
                            <!-- line -->
                            <div class="block h-8 rounded-full bg-virtual-blue w-14 store"></div>
                            <!-- dot -->
                            <div class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"></div>
                        </div>
                        <!-- label -->
                    </label>
                </div>
                <div class="grid w-full grid-cols-5 mx-auto">
                    <div class="col-span-4 mx-3 text-2xl font-semibold text-virtual-blue">
                        Location
                    </div>

                    <label for="toggleBD" class="flex items-center cursor-pointer">
                        <!-- toggle -->
                        <div class="relative">
                            <!-- input -->
                            <input type="checkbox" id="toggleBD" class="sr-only" :checked="locat"
                                @change="ndryshova(prop.settings.location, 'location')">
                            <!-- line -->
                            <div class="block h-8 rounded-full bg-virtual-blue w-14 store"></div>
                            <!-- dot -->
                            <div class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"></div>
                        </div>
                        <!-- label -->
                    </label>
                </div>
            </div>
        </div>
    </div>

</template>


<style scoped>
input:checked~.dot {
    transform: translateX(100%);
    /* background-color: #48bb78; */
}

input:checked~.store {
    background-color: #d6d3d1;
}

.animate__animated.animate__fadeIn {
    --animate-duration: 3s;
}
</style>
