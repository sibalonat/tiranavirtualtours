<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted } from '@vue/runtime-core';
// Link

// heroicons
import { FlagIcon, InformationCircleIcon, Cog6ToothIcon } from '@heroicons/vue/24/outline'

onMounted(() => {
    BreezeAuthenticatedLayout, Head
    FlagIcon, InformationCircleIcon
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

        <!-- <div class="py-12"> -->
        <div>
            <div class="relative mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- <div class="flex bg-stone-400 text-slate-100 "> -->
                <div class="flex text-white bg-stone-500/[.78] ">
                    <p class="px-10 py-8 text-xl font-semibold text-start">
                        Tirana <br>
                        Virtual Tours
                    </p>
                </div>
                <div class="flex flex-col px-10 py-8 space-y-4">
                    <div class="grow border-stone-500/[.78] border-4 rounded-xl">

                        <p class="flex uppercase py-4 text-3xl text-stone-500/[.78] ml-5">
                            <FlagIcon class="w-8 h-8 text-stone-500/[.78] mr-2 stroke-2"> </FlagIcon>
                            <Link class="no-underline text-3xl text-stone-500/[.78]" :href="route('landing.tours')">Tours</Link>
                        </p>

                    </div>
                    <div class="grow border-stone-500/[.78] border-4 rounded-xl">
                        <p class="flex uppercase py-4 text-3xl text-stone-500/[.78] ml-5">
                            <InformationCircleIcon class="w-8 h-8 text-stone-500/[.78] mr-2 stroke-2"> </InformationCircleIcon>
                            About
                        </p>
                    </div>
                    <div class="grow border-stone-500/[.78] border-4 rounded-xl">
                        <p class="flex uppercase py-4 text-3xl text-stone-500/[.78] ml-5">
                            <Cog6ToothIcon class="w-8 h-8 text-stone-500/[.78] mr-2 stroke-2"> </Cog6ToothIcon> Settings
                        </p>
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
