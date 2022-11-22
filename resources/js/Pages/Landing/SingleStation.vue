<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { computed, onMounted, ref } from '@vue/runtime-core';


// heroicons
import {
    FlagIcon,
    InformationCircleIcon,
    SpeakerWaveIcon,
    ChevronLeftIcon,
    PhotoIcon,
    FilmIcon,
    CubeTransparentIcon
} from '@heroicons/vue/24/outline'

// variables
let lang = ref('AL')

const prop = defineProps({
    station: Object,
    tour: Object,
    featured: Object
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

onMounted(() => {
    BreezeAuthenticatedLayout, Head, Link
    FlagIcon, InformationCircleIcon, SpeakerWaveIcon, ChevronLeftIcon, PhotoIcon, FilmIcon, CubeTransparentIcon

    console.log(prop.tour);
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
                    <div class="flex w-full mt-10 ">
                        <img :src="prop.featured.original_url" class="object-cover w-2/3 h-3/5 rounded-xl" alt="">
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
                            <!-- <button class="rounded-full text-white mx-auto px-3 py-8 bg-stone-500/[.78] w-1/5 "> -->
                            <button class="rounded-full text-white mx-auto px-0 py-7 bg-stone-500/[.78] w-2/5">
                                <SpeakerWaveIcon class="w-12 mx-auto h-14"></SpeakerWaveIcon>
                            </button>
                            <button class="rounded-full text-white mx-auto px-0 py-7 bg-stone-500/[.78] w-2/5">
                                <PhotoIcon class="w-12 mx-auto h-14"></PhotoIcon>
                            </button>
                            <button class="rounded-full text-white mx-auto px-0 py-7 bg-stone-500/[.78] w-2/5">
                                <FilmIcon class="w-12 mx-auto h-14"></FilmIcon>
                            </button>
                            <button class="rounded-full text-white mx-auto px-0 py-7 bg-stone-500/[.78] w-2/5">
                                <CubeTransparentIcon class="w-12 mx-auto h-14"></CubeTransparentIcon>
                            </button>
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
