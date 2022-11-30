<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted } from '@vue/runtime-core';


// heroicons
import { FlagIcon, InformationCircleIcon, Cog6ToothIcon, ChevronLeftIcon } from '@heroicons/vue/24/outline'


const prop = defineProps({
    settings: Object
})

// methods
const ndryshova = (e, i) => {
    console.log('now');
}


// Inertia.visit(route('user.change'), {
//         method: 'post',
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

onMounted(() => {
    BreezeAuthenticatedLayout, Head, Link
    FlagIcon, InformationCircleIcon

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
                        <div class="col-span-4 mx-3 font-medium text-stone-500/[.78]">
                            Toggle Me!
                        </div>

                        <label for="toggleB" class="flex items-center cursor-pointer">
                            <!-- toggle -->
                            <div class="relative">
                                <!-- input -->
                                <input type="checkbox" id="toggleB" class="sr-only" @change="ndryshova">
                                <!-- line -->
                                <div class="block h-8 rounded-full bg-stone-600 w-14 store"></div>
                                <!-- dot -->
                                <div class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"></div>
                            </div>
                            <!-- label -->
                        </label>
                    </div>
                    <div class="grid w-full grid-cols-5 mx-auto">
                        <div class="col-span-4 mx-3 font-medium text-stone-500/[.78]">
                            Toggle Me!
                        </div>

                        <label for="toggleBF" class="flex items-center cursor-pointer">
                            <!-- toggle -->
                            <div class="relative">
                                <!-- input -->
                                <input type="checkbox" id="toggleBF" class="sr-only" @change="ndryshova">
                                <!-- line -->
                                <div class="block h-8 rounded-full bg-stone-600 w-14 store"></div>
                                <!-- dot -->
                                <div class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"></div>
                            </div>
                            <!-- label -->
                        </label>
                    </div>
                    <div class="grid w-full grid-cols-5 mx-auto">
                        <div class="col-span-4 mx-3 font-medium text-stone-500/[.78]">
                            Toggle Me!
                        </div>

                        <label for="toggleBC" class="flex items-center cursor-pointer">
                            <!-- toggle -->
                            <div class="relative">
                                <!-- input -->
                                <input type="checkbox" id="toggleBC" class="sr-only" @change="ndryshova">
                                <!-- line -->
                                <div class="block h-8 rounded-full bg-stone-600 w-14 store"></div>
                                <!-- dot -->
                                <div class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"></div>
                            </div>
                            <!-- label -->
                        </label>
                    </div>
                    <div class="grid w-full grid-cols-5 mx-auto">
                        <div class="col-span-4 mx-3 font-medium text-stone-500/[.78]">
                            Toggle Me!
                        </div>

                        <label for="toggleBD" class="flex items-center cursor-pointer">
                            <!-- toggle -->
                            <div class="relative">
                                <!-- input -->
                                <input type="checkbox" id="toggleBD" class="sr-only" @change="ndryshova">
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
