<script setup>

import { Head, Link } from '@inertiajs/inertia-vue3';
import { computed, onMounted, ref } from '@vue/runtime-core';
import _ from 'lodash';

// heroicons
import { FlagIcon, InformationCircleIcon, Cog6ToothIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'



const prop = defineProps({
    tours: Array
})

//variables
let arraySpanSizes = ['2', '3', '4', '5']
let arrSpostime = ['1', '2', '3', '4', '5', '6', '7', '8', '8', '10']

let testarr = ref(6)
let arrayTochange = ref([])

onMounted(() => {
    Head, Link
    FlagIcon, InformationCircleIcon, ChevronRightIcon

    // properties
    testarr, arraySpanSizes, arrSpostime

    console.log(prop.tours);


    for (let index = 0; index < testarr.value; index++) {
        const element = _.shuffle(arraySpanSizes);
        let something = _.sample(element)
        arrayTochange.value.push(something)
    }

    console.log(arrayTochange.value);
})

</script>

<template>

    <Head title="Journeys" />
    <div>
        <div class="relative max-w-full mx-auto sm:px-6 lg:px-8 bg-virtual-blue">
            <div class="relative flex flex-col justify-center h-screen">

                <div class="grid w-2/3 gap-4 grid-cols-16">
                    <div class="content-center" v-for="(item, i) in prop.tours" :key="item.slug"
                        :class="[parseInt(arrayTochange[i]) < 4 ?  `col-start-${parseInt(arrayTochange[i]) + 6}` : `col-end-${_.sample(arrSpostime) - 2}`, `col-span-${arrayTochange[i]}`]">
                        <div style="aspect-ratio: 0.3/0.3" class="flex rounded-full bg-gray-circles">
                            <p class="self-center block mx-auto my-auto text-2xl font-semibold text-virtual-blue">
                                <Link class="no-underline" :href="route('landing.tourone', item.slug)">
                                Tour {{ i }}
                                <ChevronRightIcon class="inline-block w-5 h-5 -mt-2 -mr-0.5 text-virtual-blue stroke-2">
                                </ChevronRightIcon>
                                </Link>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
