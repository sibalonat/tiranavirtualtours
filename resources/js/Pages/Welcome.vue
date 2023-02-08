<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from '@vue/reactivity';
import { defineAsyncComponent, onBeforeMount, onMounted, watch } from '@vue/runtime-core';
import Start from "@/Components/Start.vue";
import 'animate.css';
import anime from 'animejs'

import { vIntersectionObserver } from '@vueuse/components'

import {
    ChevronRightIcon,
    ChevronDoubleDownIcon
} from '@heroicons/vue/24/outline'

// media queries
import { breakpointsTailwind, useBreakpoints } from '@vueuse/core'

import { router } from '@inertiajs/vue3'

const breakpoints = useBreakpoints(breakpointsTailwind)
const smAndLarger = breakpoints.greater('sm')

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
})

let statusAnimation = ref(true)

const animation = ref(null)

const targetIsVisible = ref(false)


// methods
const onIntersectionObserver = ([{ isIntersecting }]) => {
    targetIsVisible.value = isIntersecting

    anime({
        targets: '.pathVertical rect',
        keyframes: [
            { height: 0, duration: 160 },
            { height: 250, duration: 3060, delay: 50 },
        ],
        easing: 'easeInOutSine',
        complete: function () {
            console.log('this will throw');
        }
    })
    anime({
        targets: '.pathVertical2 rect',
        keyframes: [
            { height: 0, duration: 160 },
            { height: 150, duration: 2060, delay: 400 },
        ],
        easing: 'easeInOutSine',
        complete: function () {
            console.log('this will throw');
        }
    })
    anime({
        targets: '.chevrons',
        keyframes: [
            { opacity: 1, duration: 3060, delay: 3300 },
        ],
        easing: 'easeInOutSine',
        complete: function () {
            console.log('this will throw');
        }
    })
}

const renderStart = async () => {
    console.log('something');
    const module = await import('@/Components/Start.vue');
    animation.value = module.default;
}

onBeforeMount(() => {
    if (smAndLarger.value) {
        setTimeout(() => {
            router.visit(route('landing.tours'))
        }, 5000)
    }
})

onMounted(() => {
    //components
    Start, ChevronRightIcon, vIntersectionObserver, Head, ChevronDoubleDownIcon

    // css

    // methods
    onIntersectionObserver, anime

    renderStart()


    setTimeout(() => {
        statusAnimation.value = false
    }, 6000)

})

</script>

<template>

    <Head title="Landing" />
    <div>
        <div class="relative max-w-full mx-auto sm:px-6 lg:px-8 bg-virtual-blue">
            <div class="relative flex flex-col justify-center h-screen">
                <component v-if="statusAnimation" :is="animation"></component>
                <template v-else>
                    <div class="w-full h-full mx-auto">
                        <div class="flex flex-col h-full">
                            <div class="relative mx-12">
                                <Transition mode="out-in" appear>
                                    <svg width="8" height="250" v-intersection-observer="onIntersectionObserver"
                                        class="absolute ml-22 pathVertical" viewBox="0 0 8 250" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.596436" y="-0.000488281" width="7.01306" height="0" fill="white" />
                                    </svg>
                                </Transition>
                                <Transition mode="out-in" appear name="spaner1">
                                    <img :src="'/images/Tirana.svg'" class="mt-36 ml-28" alt="">
                                </Transition>
                                <Transition mode="out-in" appear>
                                    <svg width="8" height="150" v-intersection-observer="onIntersectionObserver"
                                        class="absolute ml-58 pathVertical2 -bottom-14" viewBox="0 0 8 150" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.596436" y="-0.000488281" width="7.01306" height="0" fill="white" />
                                    </svg>
                                </Transition>
                                <Transition mode="out-in" appear>
                                    <ChevronDoubleDownIcon
                                        class="absolute w-12 h-12 text-white chevrons stroke-3 ml-51 -bottom-20 animate-pulse"
                                        style="opacity: 0;" />
                                </Transition>
                                <Transition mode="out-in" appear name="spaner2" class="animate__delay-3s">
                                    <img :src="'/images/Floating.svg'" class="ml-14" alt="">
                                </Transition>
                                <Transition mode="out-in" appear name="spaner3" class="animate__delay-5s">
                                    <img :src="'/images/Tours.svg'" alt="">
                                </Transition>

                            </div>
                            <div class="mx-auto mt-20 w-60 h-60">
                                <div class="flex w-full h-full rounded-full bg-gray-circles">
                                    <p
                                        class="self-center block mx-auto my-auto text-2xl font-semibold text-virtual-blue">
                                        <Link class="no-underline" :href="route('landing.tours')">
                                        START NOW
                                        <ChevronRightIcon
                                            class="inline-block w-5 h-5 -mt-2 -mr-0.5 text-virtual-blue stroke-2">
                                        </ChevronRightIcon>
                                        </Link>
                                    </p>
                                </div>
                            </div>
                            <div class="mx-12 mt-20">
                                <div class="grid grid-cols-2 gap-x-7">
                                    <Link class="px-3 py-1 text-center text-white no-underline border border-white">
                                    About
                                    </Link>
                                    <Link class="px-3 py-1 text-center text-white no-underline border border-white"
                                        :href="route('landing.settings')">
                                    Settings
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<style scoped>
:root {
    --animate-delay: 2s;
}

.spaner1-enter-active {
    animation: slideInRight;
    animation-duration: 2s;
    /* --animate-duration: 4s; */
    /* transition-delay: 0.5s */
    /* --animate-delay: 7s; */
}

.spaner2-enter-active {
    animation: slideInUp;
    /* --animate-duration: 4s; */
    animation-duration: 4s;
    /* transition-delay: 3s */
    /* --animate-delay: 10s; */
}

.spaner3-enter-active {
    animation: slideInLeft;
    /* --animate-duration: 4s; */
    animation-duration: 6s;
    /* transition-delay: 5s */
    /* --animate-delay: 15s; */
}

/* .vl {
    border-left: 9.5px solid white;
    margin-left: -0.4px;
    animation: grow 3s 3s forwards;
}


@keyframes grow {
	0% {
		height: 0px;
	}
	100% {
		height: 200px;
	}
} */

/* transition: width 1s ease; */


/*
.transtiion-leave-active {
    animation: fadeOut;
  animation-duration: 4s;
}

.transtiion-enter-from,
.transtiion-leave-to {
  opacity: 0;
} */
</style>
