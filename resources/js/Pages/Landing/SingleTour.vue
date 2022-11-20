<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { computed, onMounted, ref } from '@vue/runtime-core';


// heroicons
import { FlagIcon, InformationCircleIcon, Cog6ToothIcon, ChevronLeftIcon } from '@heroicons/vue/24/outline'

// variables
let lang = ref('AL')

const prop = defineProps({
    tour: Object
})

const languageChange = computed({
    get() {
        return lang.value
    },
    set(val) {
        console.log(val);
        lang.value = val
    }
})

onMounted(() => {
    BreezeAuthenticatedLayout, Head, Link
    FlagIcon, InformationCircleIcon

    // computed
    languageChange

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
                    <Link class="no-underline" :href="route('landing.tours')">
                    <p class="inline-block px-5 py-8 my-auto text-[36px] mb-0 font-semibold leading-none align-text-bottom text-start">
                        <ChevronLeftIcon class="inline-block w-12 h-12 -mt-2 -mr-0.5 text-white stroke-2"></ChevronLeftIcon> <span class="inline-block -mb-4">{{ prop.tour.title }}</span>
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
