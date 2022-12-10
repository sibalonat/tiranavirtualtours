<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref } from '@vue/reactivity';
import { onMounted, watch } from '@vue/runtime-core';
import Start from "@/Components/Start.vue";
import 'animate.css';

import {
    ChevronRightIcon,
} from '@heroicons/vue/24/outline'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
})

let animation = ref(null)
let statusAnimation = ref(true)
let spaner1 = ref(null)



onMounted(() => {
    //components
    Start, ChevronRightIcon


    console.log(spaner1.value);
    setTimeout(() => {
        statusAnimation.value = false
    }, 6000)

})

</script>

<template>

    <div>
        <div class="relative max-w-full mx-auto sm:px-6 lg:px-8 bg-virtual-blue">
            <div class="relative flex flex-col justify-center h-screen">
                <Start ref="animation" v-if="statusAnimation" />
                <template v-else>
                    <div class="h-full mx-auto">
                        <div class="flex flex-col h-full">
                            <div class="mt-20">
                                <Transition mode="out-in" appear name="spaner1">
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
                                </Transition>
                            </div>
                            <div class="mt-20 w-72 h-72">
                                <div class="flex w-full h-full bg-white rounded-full">
                                    <p class="self-center block mx-auto my-auto text-2xl font-semibold text-virtual-blue">
                                        START NOW
                                        <ChevronRightIcon class="inline-block w-5 h-5 -mt-2 -mr-0.5 text-virtual-blue stroke-2">
                                        </ChevronRightIcon>
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
