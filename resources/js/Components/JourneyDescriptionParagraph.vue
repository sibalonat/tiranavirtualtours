<script setup>
// props
// heroicons
import { ChevronLeftIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/vue3';
import { onMounted } from '@vue/runtime-core';

const prop = defineProps({
    smAndLarger: Boolean,
    languageChange: String,
    description_al: String,
    description_en: String
})
onMounted(() => {
    ChevronLeftIcon
    // props
    prop, Link
})
</script>
<template>
    <div class="grid w-11/12 grid-cols-4 mt-20 mb-8 overflow-hidden">
        <Link class="grid grid-cols-7 col-span-3" :href="route('landing.tours')">
        <ChevronLeftIcon class="col-start-2 my-auto stroke-2 text-virtual-blue w-7 h-7" />
        <p class="col-span-5 col-start-3 my-auto text-3xl font-semibold text-start text-virtual-blue">
            {{ prop.languageChange === 'AL' ? 'Rreth rrugëtimit' : 'About this tour' }}
        </p>
        </Link>
        <button class="h-8 px-3 ml-auto mr-5 text-white bg-virtual-blue rounded-xl"
            @click="$emit('update:languageChange', $event.target.value === 'AL' ? $event.target.value = 'EN' : $event.target.value = 'AL')">
            {{ prop.languageChange }}
        </button>
    </div>
    <div class="relative max-h-full overflow-y-auto">
        <p class="h-full text-justify text-virtual-blue" :class="!smAndLarger ?
        'px-5 text-sm font-normal leading-loose pb-96' :
        'pl-12 pr-10 text-sm font-normal leading-loose pb-0'" v-if="languageChange === 'AL'">
            {{ prop.description_al }}
        </p>
        <p class="h-full text-justify text-virtual-blue" :class="!smAndLarger ?
        'px-5 text-sm font-normal leading-loose pb-96' :
        'pl-12 pr-10 text-sm font-normal leading-loose pb-0'" v-else>
            {{ prop.description_en }}
        </p>
    </div>
</template>
