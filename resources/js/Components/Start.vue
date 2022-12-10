<script setup>
import { ref } from '@vue/reactivity';
import { onMounted } from '@vue/runtime-core';
import 'animate.css';

let dissapear = ref(true)

onMounted(() => {
    setTimeout(() => {
        dissapear.value = false
    }, 5000)
})
</script>
<template>
    <div class="self-center">
        <Transition mode="out-in" appear enter-active-class="animate__animated animate__fadeIn"
            leave-active-class="animate__animated animate__fadeOut">
            <img :src="'/images/logo.svg'" class="block w-full" alt="" v-if="dissapear">
        </Transition>
    </div>
    <div class="absolute inset-x-0 bottom-0">
        <Transition mode="out-in" appear enter-active-class="animate__animated animate__slideInUp"
            leave-active-class="animate__animated animate__fadeOut">
            <img :src="'/images/tal-sm.svg'" class="block w-1/12 mx-auto mb-20" alt="" v-if="dissapear">
        </Transition>
    </div>
</template>
<style scoped>
.animate__animated.animate__fadeIn {
    --animate-duration: 3s;
}
</style>
