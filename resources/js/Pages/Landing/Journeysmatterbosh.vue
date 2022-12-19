<script setup>

import { Head, Link } from '@inertiajs/inertia-vue3';
import { computed, onMounted, ref } from '@vue/runtime-core';
import _ from 'lodash';
// import Matter from "matter-js";
import {
  Engine,
  Render,
  World,
  Bodies,
  Body,
  Events,
  Composite,
  Composites,
  Constraint,
  Vertices,
  Mouse,
  MouseConstraint,
  Query,
  Common
} from "matter-js";

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

//methods


onMounted(() => {
    Head, Link
    FlagIcon, InformationCircleIcon, ChevronRightIcon
    // matterjs
    Engine, Render, World, Bodies, Body, Events, Composite, Composites, Constraint, Vertices, Mouse, MouseConstraint, Query, Common

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
            <div class="relative flex flex-col justify-center h-screen falling-scene">


                <!-- <div class="grid w-2/3 gap-4 grid-cols-16 falling-scene"> -->
                <!-- <div class="content-center" v-for="(item, i) in prop.tours" :key="item.slug"
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
                    </div> -->
                <!-- </div> -->
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.fallbox {
    position: relative;
    height: 100vh;
    width: 100%;
    margin: auto;
    background: black;
    overflow: hidden;

    .fallbox-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 95%;
        max-width: 1050px;
        z-index: 2;

        // -khtml-user-select: none;
        // -moz-user-select: none;
        // -ms-user-select: none;
        // user-select: none;
        // pointer-events: none;

        h1 {
            font-size: 160px;
            font-weight: 500;
            line-height: 140px;
            margin-bottom: 150px;
            text-align: center;
            color: white;
        }
    }

    .fallbox-scene {
        height: 100%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
        contain: strict;

        .item {
            height: 120px;
            width: 120px;
            background: red;
            position: absolute;
            opacity: 0;
            user-select: none;
            will-change: transform;

            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            pointer-events: none;
        }
    }
}
</style>
