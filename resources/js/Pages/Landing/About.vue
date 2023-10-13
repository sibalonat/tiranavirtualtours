<script setup>
import { breakpointsTailwind, useBreakpoints } from '@vueuse/core'
import { computed, onMounted, ref } from 'vue'

import AboutEn from "@/Pages/Landing/Parts/AboutEn.vue";
import AboutAl from "@/Pages/Landing/Parts/AboutAl.vue";

// heroicons
import { FlagIcon, ChevronLeftIcon, ChevronDoubleRightIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'
import { Head, Link } from '@inertiajs/vue3'

const breakpoints = useBreakpoints(breakpointsTailwind)
const smAndLarger = breakpoints.greater('sm')

// properties
let visible = ref(true)
const language = ref('AL')

//computed

const changeLanguage = computed({
    get() {
        return language.value
    },
    set(val) {
        language.value = val
    }
})


// methods
const visibleHeader = (e) => {
    visible.value = !e
}

// hooks

</script>
<template>
    <Head title="TFT - About" />
    <div class="relative h-screen max-w-full mx-auto overflow-hidden bg-gray-circles">
        <div class="flex flex-col justify-center">
            <div class="w-full text-white bg-virtual-blue z-900" v-if="visible">
                <Link class="w-screen no-underline lg:w-full" :href="route('welcome')" v-if="!smAndLarger">
                <div class="grid content-center grid-cols-5">
                    <div class="mx-auto my-auto">
                        <ChevronLeftIcon class="inline-block w-7 h-7 -mt-2 -mr-0.5 text-white stroke-2">
                        </ChevronLeftIcon>
                    </div>
                    <p
                        class="inline-block col-span-4 py-8 my-auto mb-0 text-2xl font-semibold leading-none align-text-bottom text-start">
                        About
                    </p>
                </div>
                </Link>
                <Link class="grid w-full grid-cols-12" :href="route('welcome')" v-else>
                <img :src="'/images/logo.svg'" class="block w-1/2 col-span-1 mx-auto" alt="">
                <div class="col-span-8 my-auto">
                    <p class="text-3xl">Tirana Floating Tours</p>
                </div>
                </Link>
            </div>
            <div class="flex justify-end py-0 mt-8" :class="!smAndLarger ? 'flex-col' : 'flex-row'">
                <div :class="!smAndLarger ? 'grow' : 'w-1/3'">
                    <div class="flex flex-row" :class="!smAndLarger ? '' : 'w-11/12'">
                        <h2 class="mb-4 text-2xl font-semibold basis-3/4 text-virtual-blue"
                        :class="!smAndLarger ? 'pl-8' : 'pl-12'">
                           {{ changeLanguage === 'AL' ? 'Reth këtij projekti' : 'About this project' }}
                        </h2>
                        <div class="px-4 py-3 ml-auto -mt-3 basis-1/4">
                            <button class="w-12 ml-auto text-white rounded-lg bg-virtual-blue"
                            @click="changeLanguage === 'AL' ? changeLanguage = 'EN' : changeLanguage = 'AL'">
                                {{ changeLanguage }}
                            </button>
                        </div>
                    </div>
                    <div class="relative mx-auto overflow-y-auto w-85"
                    :class="!smAndLarger ? 'max-h-90' : 'max-h-120'">
                        <component :is="changeLanguage === 'AL' ? AboutAl : AboutEn" :view-port="smAndLarger" />
                    </div>
                </div>
                <div class="relative w-2/3" v-if="smAndLarger">
                    <h2 class="pl-12 mb-4 text-2xl font-semibold basis-3/4 text-virtual-blue">
                           {{ changeLanguage === 'AL' ? 'Mbështetur prej:' : 'Supported by:' }}
                    </h2>
                    <div class="absolute bottom-0 w-2/3 mt-8" v-if="smAndLarger">
                        <img src="/images/logosTFT.png" alt="supporters tft">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
