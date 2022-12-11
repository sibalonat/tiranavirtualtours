<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted } from '@vue/runtime-core';


// heroicons
import { FlagIcon, InformationCircleIcon, Cog6ToothIcon, ChevronLeftIcon } from '@heroicons/vue/24/outline'


const prop = defineProps({
    tours: Array
})

onMounted(() => {
    BreezeAuthenticatedLayout, Head, Link
    FlagIcon, InformationCircleIcon

    console.log(prop.tours);
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
                <!-- <div class="flex bg-stone-400 text-slate-100 "> -->
                <div class="flex text-white bg-stone-500/[.78] ">
                    <Link class="no-underline" :href="route('landing.all')">
                    <p class="inline-block px-5 py-8 my-auto text-[36px] mb-0 font-semibold leading-none align-text-bottom text-start">
                        <ChevronLeftIcon class="inline-block w-12 h-12 -mt-2 -mr-0.5 text-white stroke-2"></ChevronLeftIcon> <span class="inline-block -mb-4">Tours</span>
                    </p>
                    </Link>
                </div>
                <div class="flex flex-col px-10 py-8 space-y-4">
                    <div v-for="tour in prop.tours" :key="tour.slug" class="grow border-stone-500/[.78] border-4 rounded-xl">
                        <Link class="no-underline" :href="route('landing.tourone', tour.slug)">
                            <p class="flex uppercase py-4 text-3xl text-stone-500/[.78] ml-5">
                                <FlagIcon class="w-8 h-8 text-stone-500/[.78] mr-2 stroke-2"> </FlagIcon> {{ tour.title }}
                            </p>
                        </Link>
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
