<script setup>
// heroicons
import {
    XMarkIcon,
} from '@heroicons/vue/24/outline';
import { onMounted } from '@vue/runtime-core';

const prop = defineProps({
    languageChange: String,
    teaserAl: String,
    teaserEn: String,
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
    <div class="relative mt-4 overflow-y-hidden grow">
        <div class="grid w-full grid-cols-6 lg:w-90">
            <p class="col-span-5 font-semibold text-title text-start text-virtual-blue">
                {{ prop.languageChange === 'AL' ? 'Rreth Stacionit' : 'The Station' }}
            </p>
            <button type="button" class="mx-auto" @click="$emit('update:compChange', $event.target.value = 0)">
                <XMarkIcon class="text-virtual-blue w-7 h-7"> </XMarkIcon>
            </button>
        </div>
        <div class="relative w-full overflow-y-auto lg:w-90 max-h-52 scroll-smooth">
            <p class="h-full mt-4 font-normal leading-relaxed text-body text-start text-virtual-blue">
                {{ prop.languageChange === 'AL' ? prop.teaserAl : prop.teaserEn }}
            </p>
        </div>
    </div>
</template>
