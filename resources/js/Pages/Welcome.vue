<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref } from '@vue/reactivity';
import { onMounted, watch } from '@vue/runtime-core';
import Start from "@/Components/Start.vue";
import 'animate.css';
import anime from 'animejs'
// import { useIntersectionObserver } from '@vueuse/core'
import { vIntersectionObserver } from '@vueuse/components'

import {
    ChevronRightIcon,
} from '@heroicons/vue/24/outline'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
})

let statusAnimation = ref(true)
const target = ref(null)
const targetIsVisible = ref(false)


// methods
const onIntersectionObserver = ([{ isIntersecting }]) => {
    targetIsVisible.value = isIntersecting
    let vert = document.querySelector('.pathVertical')
    console.log(vert);

    // anime({
    //   targets: '.pathVertical rect',
    //   keyframes: [
    //     { width: '100vw', height: '20vh', duration: 160 },
    //     { scaleX: 1.04, duration: 160 },
    //     { scaleX: 1, duration: 160 }
    //   ],
    //   easing: 'easeInOutSine',
    //   complete: function () {
    //     animationState.value = 'bigger'
    //   }
    // })
    anime({
        targets: '.pathVertical rect',
        keyframes: [
            { height: 0, duration: 160 },
            { height: 135, duration: 360 },
        ],
        easing: 'easeInOutSine',
        // duration: 1500,
        delay: function (el, i) { return i * 250 },
        complete: function () {
            console.log('this will trhow');
            // animationState.value = 'bigger'
        }
    })
}

onMounted(() => {
    //components
    Start, ChevronRightIcon, vIntersectionObserver

    // css

    // methods
    onIntersectionObserver, anime

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
                <Start ref="animation" v-if="statusAnimation" />
                <template v-else>
                    <div class="h-full mx-auto">
                        <div class="flex flex-col h-full">
                            <div class="relative mt-20">
                                <Transition>
                                    <svg width="8" height="135" v-intersection-observer="onIntersectionObserver"
                                        class="pathVertical" viewBox="0 0 8 135" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.596436" y="-0.000488281" width="7.01306" height="0" fill="white" />
                                    </svg>
                                </Transition>
                                <Transition mode="out-in" appear name="spaner1">
                                    <img :src="'/images/Tirana.svg'" alt="">
                                </Transition>
                                <Transition mode="out-in" appear name="spaner2">
                                    <img :src="'/images/Floating.svg'" alt="">
                                </Transition>
                                <Transition mode="out-in" appear name="spaner3">
                                    <img :src="'/images/Tours.svg'" alt="">
                                </Transition>
                                <!-- <Transition mode="out-in" appear name="spaner1">
                                    <p class="font-bold text-white text-7xl ml-28">
                                        Tirana
                                    </p>
                                </Transition>
                                <Transition mode="out-in" appear name="spaner2">
                                    <p class="ml-12 font-bold text-white text-7xl">
                                        Virtual
                                    </p>
                                </Transition>
                                <Transition mode="out-in" appear name="spaner3">
                                    <p class="font-bold text-white text-7xl">
                                        Tours
                                    </p>
                                </Transition> -->
                            </div>
                            <div class="mt-20 w-72 h-72">
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
                            <div class="mt-20">
                                <div class="grid grid-cols-2 gap-x-7">
                                    <button class="px-3 py-1 text-white border border-white">About</button>
                                    <button class="px-3 py-1 text-white border border-white">Settings</button>
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
.spaner1-enter-active {
    animation: slideInLeft;
    animation-duration: 4s;
    transition-delay: 0.5s
}

.spaner2-enter-active {
    animation: slideInLeft;
    animation-duration: 4s;
    transition-delay: 2s
}

.spaner3-enter-active {
    animation: slideInLeft;
    animation-duration: 4s;
    transition-delay: 4s
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
