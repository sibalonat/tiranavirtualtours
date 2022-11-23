<script setup>
import * as L from 'leaflet';
import { OSRMv1, Control as RoutingControl } from '@fleetbase/leaflet-routing-machine';
import { onMounted, watchEffect } from 'vue';

const props = defineProps({
    latlng: Object,
    location: Object,
    map: Object
})

onMounted(() => {
    // const map = new L.Map('myMap');
    const serviceUrl = 'https://router.project-osrm.org/route/v1';
    const router = new OSRMv1({ serviceUrl, profile: 'driving' });
    console.log(props);
    console.log(router);
    const routingControl = new RoutingControl({ waypoints: [props.location, props.latlng], router });
})

watchEffect(() => {
    props.latlng
    props.location
    props.map
    console.log(props.latlng);
})
</script>

<template>
    <div>this is it</div>

</template>
