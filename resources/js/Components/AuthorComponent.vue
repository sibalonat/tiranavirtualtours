<script setup>
// heroicons
import {
    XMarkIcon,
} from '@heroicons/vue/24/outline';
import { onMounted } from '@vue/runtime-core';
const prop = defineProps({
    languageChange: String,
    authorAl: String,
    authorEn: String,
    compChange: Number
})

onMounted(() => {
    // heroicons
    XMarkIcon
    //props
    prop
})

</script>

<template>
    <div class="relative mt-4 overflow-y-hidden grow" v-if="prop.authorAl && prop.authorEn">
        <div class="grid grid-cols-6 w-90">
            <p class="col-span-5 text-xl font-semibold text-start text-virtual-blue">
                {{ prop.languageChange === 'AL' ? 'Rreth Artistit' : 'The Artist' }}
            </p>
            <button type="button" class="mx-auto" @click="$emit('update:compChange', $event.target.value = 0)">
                <XMarkIcon class="text-virtual-blue w-7 h-7"> </XMarkIcon>
            </button>

        </div>
        <div class="relative overflow-y-auto w-90 max-h-52 scroll-smooth">
            <p class="h-full mt-4 text-sm font-normal leading-loose text-start text-virtual-blue">
                {{ prop.languageChange === 'AL' ? prop.authorAl : prop.authorEn }}
            </p>
        </div>
    </div>
</template>
