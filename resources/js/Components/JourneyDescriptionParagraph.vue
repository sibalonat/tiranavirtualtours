<script setup>
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
    prop, Link
})
</script>
<template>
    <div class="grid w-11/12 grid-cols-4 mt-8 mb-8 overflow-hidden lg:mt-28">
        <Link class="grid grid-cols-8 col-span-3 px-3 lg:px-0" :href="route('landing.tours')">
        <ChevronLeftIcon class="col-start-1 my-auto stroke-2 lg:col-start-2 text-virtual-blue w-7 h-7" />
        <p class="col-span-7 col-start-2 my-auto font-semibold lg:col-span-6 text-title xl:text-3xl text-start text-virtual-blue">
            {{ prop.languageChange === 'AL' ? 'Rreth rrugëtimit' : 'About this tour' }}
        </p>
        </Link>
        <button type="button" class="h-8 px-3 ml-auto mr-5 text-white bg-virtual-blue rounded-xl"
            @click="$emit('update:languageChange', $event.target.value === 'AL' ? $event.target.value = 'EN' : $event.target.value = 'AL')">
            {{ prop.languageChange }}
        </button>
    </div>
    <div class="relative max-h-full h-[92%]">
        <p class="flex h-[80%] overflow-y-auto text-justify text-virtual-blue" :class="!smAndLarger ?
        'px-5 text-sm font-normal leading-relaxed pb-96' :
        'pl-12 pr-10 lg:pl-8 lg:pr-6 text-body font-normal leading-relaxed pb-0'" v-if="languageChange === 'AL'">
            {{ prop.description_al }}
        </p>
        <p class="flex h-[80%] overflow-y-auto text-justify text-virtual-blue" :class="!smAndLarger ?
        'px-5 text-sm font-normal leading-relaxed pb-96' :
        'pl-12 pr-10 lg:pl-8 lg:pr-6 text-body font-normal leading-relaxed pb-0'" v-else>
            {{ prop.description_en }}
        </p>
    </div>
</template>
