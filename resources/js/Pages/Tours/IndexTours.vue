<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from '@vue/runtime-core';
// console.log('has mounted');
const prop = defineProps({
    tours: Object
})

const remove = () => {
    console.log('it removes')
}

onMounted(() => {
    console.log(prop.tours.length);
    remove
})
</script>
<template>

    <Head title="Tours" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tour Create
            </h2>
        </template>

        <div class="py-12">
            <div class="relative mx-auto max-w-7xl sm:px-6 lg:px-8">
                <a :href="route('tour.create')" class="absolute px-4 py-2 text-white rounded-lg bg-slate-900 top-4 right-32">Create one</a>
                <div class="flex justify-center py-40 overflow-hidden bg-white shadow-sm sm:rounded-lg space-x-11">
                    <ul class="flex-1 px-8 list-none" v-if="prop.tours.length">
                        <!-- {{ prop.tours.length }} -->
                        <li v-for="tour in tours" :key="tour.id" class="border-b-2">
                        <div class="grid grid-cols-5">
                            <p class="col-span-3 text-lg">{{ tour.title }}</p>
                            <div class="grid grid-cols-2">
                                <a class="px-4 text-center text-white bg-slate-900" :href="route('tour.edit', tour.slug)">Edit</a>
                                <button @click="remove">delete</button>
                            </div>
                        </div>
                        </li>
                    </ul>
                    <p v-else>No tours yet</p>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>

</template>
